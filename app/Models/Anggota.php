<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = ['user_id', 'nomor_anggota', 'nama', 'alamat', 'telepon'];

public function user() {
    return $this->belongsTo(User::class);
}
public function transaksis() {
    return $this->hasMany(Transaksi::class);
}
}
