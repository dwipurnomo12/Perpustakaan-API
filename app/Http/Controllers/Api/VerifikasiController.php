<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Pemesanan;

class VerifikasiController extends Controller
{
    public function verifikasi(Request $request)
    {
        $kd_pesanan = $request->input('kd_pesanan');

        $pemesanan = Pemesanan::where('kd_pesanan', $kd_pesanan)->first();

        if(!$pemesanan){
            return ResponseFormatter::error(null, 'Kode Pesanan tidak ditemukan!', 404);
        }

        $pemesanan->update(['status' => 'terverifikasi']);

        return ResponseFormatter::success([], 'Pesanan berhasil di verifikasi !');
    }
}
