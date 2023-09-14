<?php

namespace App\Http\Controllers\Api;

use App\Models\Buku;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\PeminjamanBuku;
use Illuminate\Support\Facades\Validator;

class PeminjamanBukuController extends Controller
{
    public function listBuku()
    {
        $buku = Buku::all();
        return ResponseFormatter::success([
            'bukus' => $buku
        ], 'Success Show All Data Buku');
    }

    public function pinjamBuku(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nm_peminjam'   => 'required',
            'buku_id'       => 'required|exists:bukus,id,status,tersedia',
        ], [
            'nm_peminjam'       => 'required',
            'buku_id.required'  => 'Pilih buku yang akan dipinjam !',
            'buku_id.exists'    => 'Buku sudah dipinjam !'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $peminjam = PeminjamanBuku::create([
            'nm_peminjam'   => $request->nm_peminjam,
            'buku_id'       => $request->buku_id
        ]);

        $statusBuku = Buku::where('id', $request->buku_id)->first();
        if($statusBuku){
            $statusBuku->update(['status'   => 'dipinjam']);
        }

        return ResponseFormatter::success([
            'data'  => $peminjam
        ], 'Successfully added data');
    }

    public function kembalikanBuku(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'peminjaman_id' => 'required|exists:peminjaman_bukus,id',
        ], [
            'peminjaman_id.required' => 'ID peminjaman buku diperlukan!',
            'peminjaman_id.exists'   => 'ID peminjaman buku tidak valid!',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $peminjaman = PeminjamanBuku::find($request->peminjaman_id);

        if (!$peminjaman) {
            return ResponseFormatter::error(null, 'Peminjaman buku tidak ditemukan!', 404);
        }

        $buku = Buku::find($peminjaman->buku_id);

        if (!$buku) {
            return ResponseFormatter::error(null, 'Buku tidak ditemukan!', 404);
        }

        $buku->update(['status' => 'tersedia']);

        $peminjaman->delete();
        return ResponseFormatter::success([], 'Buku berhasil dikembalikan');
    }


}
