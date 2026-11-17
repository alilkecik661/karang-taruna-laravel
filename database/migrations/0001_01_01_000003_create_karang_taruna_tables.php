<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi database Karang Taruna sesuai PLANNING.md.
     */
    public function up(): void
    {
        Schema::create('bidang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 30)->default('pengurus')->after('password')->index();
            $table->foreignId('bidang_id')->nullable()->after('role')->constrained('bidang')->nullOnDelete();
        });

        Schema::create('pengurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->foreignId('bidang_id')->nullable()->constrained('bidang')->nullOnDelete();
            $table->string('foto')->nullable();
            $table->unsignedInteger('urutan')->default(0)->index();
            $table->boolean('is_aktif')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->foreignId('bidang_id')->nullable()->constrained('bidang')->nullOnDelete();
            $table->longText('deskripsi');
            $table->dateTime('tanggal_mulai')->index();
            $table->dateTime('tanggal_selesai')->nullable()->index();
            $table->string('lokasi');
            $table->string('gambar_sampul')->nullable();
            $table->string('status', 20)->default('draft')->index(); // draft | publish
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('isi');
            $table->string('gambar_sampul')->nullable();
            $table->boolean('is_pinned')->default(false)->index();
            $table->string('status', 20)->default('draft')->index(); // draft | publish
            $table->timestamp('published_at')->nullable()->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('album', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->foreignId('kegiatan_id')->nullable()->constrained('kegiatan')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('foto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained('album')->cascadeOnDelete();
            $table->string('path');
            $table->string('caption')->nullable();
            $table->unsignedInteger('urutan')->default(0)->index();
            $table->timestamps();
        });

        Schema::create('banner', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('subjudul')->nullable();
            $table->string('gambar')->nullable();
            $table->string('tautan')->nullable();
            $table->unsignedInteger('urutan')->default(0)->index();
            $table->boolean('is_aktif')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('pendaftaran_anggota', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin', 20);
            $table->date('tanggal_lahir')->index();
            $table->text('alamat');
            $table->string('no_whatsapp', 30);
            $table->string('email')->nullable();
            $table->string('bidang_minat', 100)->nullable();
            $table->string('status', 20)->default('baru')->index(); // baru | diproses | diterima | ditolak
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });

        Schema::create('pesan_kontak', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('subjek')->nullable();
            $table->text('isi');
            $table->boolean('sudah_dibaca')->default(false)->index();
            $table->timestamps();
        });

        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('kunci')->unique();
            $table->text('nilai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi database.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
        Schema::dropIfExists('pesan_kontak');
        Schema::dropIfExists('pendaftaran_anggota');
        Schema::dropIfExists('banner');
        Schema::dropIfExists('foto');
        Schema::dropIfExists('album');
        Schema::dropIfExists('berita');
        Schema::dropIfExists('kegiatan');
        Schema::dropIfExists('pengurus');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['bidang_id']);
            $table->dropColumn(['role', 'bidang_id']);
        });

        Schema::dropIfExists('bidang');
    }
};
