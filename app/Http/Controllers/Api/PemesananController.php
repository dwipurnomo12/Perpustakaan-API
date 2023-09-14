<?php

namespace App\Http\Controllers\Api;

use App\Models\Produk;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use App\Models\DetailPesananan;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PemesananController extends Controller
{
    public function tambahPesanan(Request $request)
    {
       $kd_pesanan = 'INV-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
       $user_id    = auth()->user()->id;

       $pemesanan = new Pemesanan();
       $pemesanan->kd_pesanan   = $kd_pesanan;
       $pemesanan->user_id      = $user_id;

       $pemesanan->save();

       foreach($request->input('produk') as $produk){
            $produk_id  = $produk['id'];
            $qty        = $produk['qty'];

            $produk = Produk::find($produk_id);

            if($produk){
                $hargaTotal = $produk->harga * $qty;

                $detailPesanan = new DetailPesanan();
                $detailPesanan->pemesanan_id    = $pemesanan->id;
                $detailPesanan->produk_id       = $produk_id;
                $detailPesanan->qty             = $qty;
                $detailPesanan->total_harga     = $hargaTotal;

                $detailPesanan->save();
            }

            $pemesanan->sub_total += $hargaTotal;
            if($pemesanan->sub_total >= 25000){
                $pemesanan->tiket_gratis = true;
            }

            $pemesanan->save();
        }
        

        return ResponseFormatter::success([
            'data'  => $pemesanan
        ], 'Successfully added data');
    }

}

