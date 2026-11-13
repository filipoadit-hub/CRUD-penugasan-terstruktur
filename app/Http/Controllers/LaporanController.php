<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Transaksi;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    public function anggota()
    {
        $anggotas = Anggota::with('user')->orderBy('nama')->get();
        $columns = [
            ['No', 10, 'C'],
            ['Nomor Anggota', 32, 'L'],
            ['Nama', 45, 'L'],
            ['Alamat', 82, 'L'],
            ['Telepon', 32, 'L'],
            ['Dicatat oleh', 76, 'L'],
        ];

        $pdf = $this->createPdf('Laporan Data Anggota');
        $this->writePdfSubtitle($pdf, 'Jumlah data: '.$anggotas->count());
        $this->drawTableHeader($pdf, $columns);

        if ($anggotas->isEmpty()) {
            $pdf->Cell(277, 8, $this->toPdfText('Belum ada data anggota.'), 1, 1, 'C');
        } else {
            foreach ($anggotas as $index => $anggota) {
                $this->drawTableRow($pdf, [
                    (string) ($index + 1),
                    $anggota->nomor_anggota,
                    $anggota->nama,
                    $anggota->alamat,
                    $anggota->telepon,
                    $anggota->user->name ?? '-',
                ], $columns);
            }
        }

        return $this->downloadPdf($pdf, 'laporan-anggota-'.now()->format('Ymd-His').'.pdf');
    }

    public function transaksi()
    {
        $transaksis = Transaksi::with('anggota')
            ->orderByDesc('tanggal_transaksi')
            ->orderByDesc('id')
            ->get();

        $totalSimpanan = $transaksis->where('jenis_transaksi', 'simpanan')->sum('jumlah');
        $totalPinjaman = $transaksis->where('jenis_transaksi', 'pinjaman')->sum('jumlah');
        $columns = [
            ['No', 10, 'C'],
            ['Kode Transaksi', 33, 'L'],
            ['Tanggal', 25, 'C'],
            ['Nomor Anggota', 30, 'L'],
            ['Nama Anggota', 40, 'L'],
            ['Jenis', 25, 'L'],
            ['Jumlah', 35, 'R'],
            ['Keterangan', 79, 'L'],
        ];

        $pdf = $this->createPdf('Laporan Simpan Pinjam');
        $this->writePdfSubtitle($pdf, 'Jumlah data: '.$transaksis->count());
        $this->drawTableHeader($pdf, $columns);

        if ($transaksis->isEmpty()) {
            $pdf->Cell(277, 8, $this->toPdfText('Belum ada data transaksi.'), 1, 1, 'C');
        } else {
            foreach ($transaksis as $index => $transaksi) {
                $this->drawTableRow($pdf, [
                    (string) ($index + 1),
                    $transaksi->kode_transaksi,
                    Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y'),
                    $transaksi->anggota->nomor_anggota,
                    $transaksi->anggota->nama,
                    ucfirst($transaksi->jenis_transaksi),
                    $this->formatRupiah($transaksi->jumlah),
                    $transaksi->keterangan ?: '-',
                ], $columns);
            }
        }

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(55, 7, $this->toPdfText('Total Simpanan'), 1);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(45, 7, $this->toPdfText($this->formatRupiah($totalSimpanan)), 1, 1, 'R');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(55, 7, $this->toPdfText('Total Pinjaman'), 1);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(45, 7, $this->toPdfText($this->formatRupiah($totalPinjaman)), 1, 1, 'R');

        return $this->downloadPdf($pdf, 'laporan-transaksi-'.now()->format('Ymd-His').'.pdf');
    }

    private function createPdf(string $title): \FPDF
    {
        $pdf = new \FPDF('L', 'mm', 'A4');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->SetTitle($this->toPdfText($title));
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, $this->toPdfText($title), 0, 1, 'C');

        return $pdf;
    }

    private function writePdfSubtitle(\FPDF $pdf, string $subtitle): void
    {
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 7, $this->toPdfText('Dicetak pada '.now()->format('d/m/Y H:i')), 0, 1, 'C');
        $pdf->Cell(0, 7, $this->toPdfText($subtitle), 0, 1, 'C');
        $pdf->Ln(3);
    }

    private function drawTableHeader(\FPDF $pdf, array $columns): void
    {
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(233, 236, 239);
        $pdf->SetDrawColor(68, 68, 68);

        foreach ($columns as [$label, $width, $alignment]) {
            $pdf->Cell($width, 8, $this->toPdfText($label), 1, 0, $alignment, true);
        }

        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
    }

    private function drawTableRow(\FPDF $pdf, array $values, array $columns): void
    {
        $wrappedValues = [];
        $lineCount = 1;

        foreach ($columns as $index => [$label, $width, $alignment]) {
            $wrappedValues[$index] = $this->wrapPdfText(
                $pdf,
                $this->toPdfText((string) $values[$index]),
                $width - 2
            );
            $lineCount = max($lineCount, substr_count($wrappedValues[$index], "\n") + 1);
        }

        $rowHeight = $lineCount * 4 + 2;
        if ($pdf->GetY() + $rowHeight > $pdf->GetPageHeight() - 10) {
            $pdf->AddPage();
            $this->drawTableHeader($pdf, $columns);
        }

        $startX = $pdf->GetX();
        $startY = $pdf->GetY();
        $pdf->SetDrawColor(68, 68, 68);

        foreach ($columns as $index => [$label, $width, $alignment]) {
            $pdf->Rect($pdf->GetX(), $startY, $width, $rowHeight);
            $pdf->SetXY($pdf->GetX() + 1, $startY + 1);
            $pdf->MultiCell($width - 2, 4, $wrappedValues[$index], 0, $alignment);
            $pdf->SetXY($startX + array_sum(array_column(array_slice($columns, 0, $index + 1), 1)), $startY);
        }

        $pdf->SetXY($startX, $startY + $rowHeight);
    }

    private function wrapPdfText(\FPDF $pdf, string $text, float $width): string
    {
        $text = trim(preg_replace('/\s+/', ' ', $text) ?? '');
        if ($text === '') {
            return '';
        }

        $lines = [];
        $line = '';
        foreach (explode(' ', $text) as $word) {
            if ($line !== '' && $pdf->GetStringWidth($line.' '.$word) <= $width) {
                $line .= ' '.$word;

                continue;
            }

            if ($line !== '') {
                $lines[] = $line;
                $line = '';
            }

            $part = '';
            foreach (str_split($word) as $character) {
                if ($part !== '' && $pdf->GetStringWidth($part.$character) > $width) {
                    $lines[] = $part;
                    $part = '';
                }
                $part .= $character;
            }
            $line = $part;
        }

        if ($line !== '') {
            $lines[] = $line;
        }

        return implode("\n", $lines);
    }

    private function toPdfText(string $text): string
    {
        $converted = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text);
        if ($converted === false) {
            throw new \RuntimeException('Teks laporan tidak dapat dikonversi untuk FPDF.');
        }

        return $converted;
    }

    private function formatRupiah(mixed $amount): string
    {
        return 'Rp '.number_format((float) $amount, 2, ',', '.');
    }

    private function downloadPdf(\FPDF $pdf, string $filename)
    {
        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
