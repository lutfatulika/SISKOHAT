<?php
namespace App\Http\Controllers;
use App\Models\VideoPanduan;
use Illuminate\Http\Request;

class VideoPanduanController extends Controller {
    public function index() {
        return response()->json(VideoPanduan::orderBy('urutan')->get());
    }
    public function store(Request $request) {
        $data = $request->validate([
            'jenis' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer', 'min:1'],
        ]);
        $data['urutan'] = $data['urutan'] ?? 1;
        $v = VideoPanduan::create($data);
        return response()->json($v, 201);
    }
    public function destroy($id) {
        VideoPanduan::findOrFail($id)->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
