<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('video_panduans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis'); // haji / umrah
            $table->string('url');
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('video_panduans');
    }
};