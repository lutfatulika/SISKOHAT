<?php
namespace App\Http\Controllers;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller {
    public function index() {
        return response()->json(Pengaduan::latest()->get());
    }
    public function store(Request $request) {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:255'],
            'pesan' => ['required', 'string'],
        ]);
        $p = Pengaduan::create($data);
        return response()->json($p, 201);
    }
}
