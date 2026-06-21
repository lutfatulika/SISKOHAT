<?php
namespace App\Http\Controllers;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller {
    public function index() {
        return response()->json(Slider::orderBy('urutan')->get());
    }
    public function store(Request $request) {
        $data = $request->validate([
            'gambar' => ['required', 'image', 'max:2048'],
            'urutan' => ['nullable', 'integer', 'min:1'],
        ]);
        $data['urutan'] = $data['urutan'] ?? 1;
        $data['gambar'] = $request->file('gambar')->store('slider','public');
        return response()->json(Slider::create($data), 201);
    }
    public function destroy($id) {
        Slider::findOrFail($id)->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
