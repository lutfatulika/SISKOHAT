<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BeritaController extends Controller
{
    /**
     * Menampilkan semua berita
     */
    public function index()
    {
        try {
            $berita = Berita::latest()->get();
            return response()->json($berita);
        } catch (\Exception $e) {
            Log::error('Berita index error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal mengambil data berita'
            ], 500);
        }
    }

    /**
     * Menampilkan detail berita berdasarkan ID
     */
    public function show($id)
    {
        try {
            $berita = Berita::findOrFail($id);
            return response()->json($berita);
        } catch (\Exception $e) {
            Log::error('Berita show error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Menyimpan berita baru
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'judul'    => ['required', 'string', 'max:255'],
                'isi'      => ['nullable', 'string'],
                'jenis'    => ['required', 'string', 'max:255', 'in:terkini,lainnya'],
                'posisi'   => ['nullable', 'string', 'max:255'],
                'gambar'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:10240'],
            ]);
    
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                if ($file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('berita', $filename, 'public');
                    if ($path) {
                        // Simpan path relatif (tanpa 'storage/')
                        $data['gambar'] = $path; // contoh: berita/1712345678_abc.jpg
                    }
                }
            }
    
            $data['isi'] = $data['isi'] ?? '';
            $berita = Berita::create($data);
    
            return response()->json([
                'message' => 'Berita berhasil disimpan',
                'data' => $berita
            ], 201);
    
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Berita store error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan berita'
            ], 500);
        }
    }

    /**
     * MENGUPDATE BERITA (TAMBAHKAN INI)
     */
    public function update(Request $request, $id)
    {
        try {
            $berita = Berita::findOrFail($id);

            $data = $request->validate([
                'judul'    => ['sometimes', 'required', 'string', 'max:255'],
                'isi'      => ['nullable', 'string'],
                'jenis'    => ['sometimes', 'required', 'string', 'max:255', 'in:terkini,lainnya'],
                'posisi'   => ['nullable', 'string', 'max:255'],
                'youtube'  => ['nullable', 'string', 'max:255'],
                'gambar'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:10240'],
            ]);

            // Upload gambar baru jika ada
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                if ($file->isValid()) {
                    // Hapus gambar lama jika ada
                    if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                        Storage::disk('public')->delete($berita->gambar);
                    }

                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('berita', $filename, 'public');
                    if ($path) {
                        $data['gambar'] = $path;
                    }
                }
            }

            $berita->update($data);

            return response()->json([
                'message' => 'Berita berhasil diperbarui',
                'data' => $berita
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Berita update error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengupdate berita'
            ], 500);
        }
    }

    /**
     * Menghapus berita
     */
    public function destroy($id)
    {
        try {
            $berita = Berita::findOrFail($id);

            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }

            $berita->delete();

            return response()->json([
                'message' => 'Berita berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Berita destroy error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menghapus berita'
            ], 500);
        }
    }
}