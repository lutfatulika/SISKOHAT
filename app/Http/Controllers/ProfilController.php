<?php
namespace App\Http\Controllers;
use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller {
    public function index() {
        return response()->json(Profil::latest()->first());
    }
    public function store(Request $request) {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'visi' => ['required', 'string'],
            'misi' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);
        Profil::truncate();
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('profil','public');
        }
        return response()->json(Profil::create($data), 201);
    }
    public function destroy($id) {
        Profil::findOrFail($id)->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
