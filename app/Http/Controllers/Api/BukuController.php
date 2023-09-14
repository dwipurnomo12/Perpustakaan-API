<?php

namespace App\Http\Controllers\Api;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::where('user_id', auth()->user()->id)
            ->orderBy('id', 'DESC')->get();
            
        return ResponseFormatter::success([
            'bukus'  => $buku
        ], 'Success Show Data Buku');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nm_buku'       => 'required',
            'penerbit'      => 'required',
            'deskripsi'     => 'required',
            'thn_terbit'    => 'required|numeric'
        ], [
            'nm_buku.required'      => 'Nama buku wajib di isi !',
            'penerbit.required'     => 'Penerbit wajb di isi !',
            'deskripsi.required'    => 'Deskripsi wwajib di isi !',
            'thn_terbit.required'   => 'Tahun terbit wajib di isi !',
            'thn_terbit.numeric'    => 'Tahun terbit harus berupa angka !'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $buku = Buku::create([
            'nm_buku'       => $request->nm_buku,
            'penerbit'      => $request->penerbit,
            'deskripsi'     => $request->deskripsi,
            'thn_terbit'    => $request->thn_terbit,
            'user_id'       => auth()->user()->id
        ]);

        return ResponseFormatter::success([
            'data'  => $buku
        ], 'Successfully added a new book');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        //
    }
}
