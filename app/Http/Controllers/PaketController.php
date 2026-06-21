<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        return response()->json(Paket::all());
    }

    public function show($id)
    {
        return response()->json(Paket::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => ['required', 'string', 'max:255'],
            'isi'       => ['required', 'string'],
            'jenis'     => ['required', 'string', 'max:255'],
            'posisi'    => ['nullable', 'string', 'max:255'],
            'fasilitas' => ['nullable', 'string'],
            'gambar'    => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('paket', 'public');
        }

        return response()->json(Paket::create($data), 201);
    }

    // ===== TAMBAHKAN METHOD UPDATE =====
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'judul'     => ['required', 'string', 'max:255'],
            'isi'       => ['required', 'string'],
            'jenis'     => ['required', 'string', 'max:255'],
            'posisi'    => ['nullable', 'string', 'max:255'],
            'fasilitas' => ['nullable', 'string'],
            'gambar'    => ['nullable', 'image', 'max:2048'],
        ]);

        $paket = Paket::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('paket', 'public');
        } else {
            // Jika tidak ada gambar baru, hapus key 'gambar' agar tidak mengupdate kolom menjadi null
            unset($data['gambar']);
        }

        $paket->update($data);

        return response()->json($paket);
    }

    public function destroy($id)
    {
        Paket::findOrFail($id)->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}