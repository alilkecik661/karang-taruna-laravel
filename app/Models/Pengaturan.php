<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan';

    protected $fillable = [
        'kunci',
        'nilai',
    ];

    public static function defaultValues(): array
    {
        return [
            'nama_organisasi' => 'Karang Taruna 04 (KARUPAT)',
            'teks_logo' => '04',
            'logo' => 'identitas/logo-karupat.png',
            'subjudul_organisasi' => 'KARUPAT · Karang Taruna 04',
            'judul_hero' => 'Bersama pemuda, membangun lingkungan yang lebih berdaya',
            'deskripsi_singkat' => 'Wadah kreativitas, kepedulian sosial, dan kepemimpinan bagi pemuda Karang Taruna 04 (KARUPAT). Ikuti kegiatan, baca kabar terbaru, dan bergabung menjadi anggota.',
            'sejarah' => 'Karang Taruna 04 (KARUPAT) merupakan organisasi sosial kemasyarakatan sebagai wadah dan sarana pengembangan setiap anggota masyarakat yang tumbuh dan berkembang atas dasar kesadaran dan tanggung jawab sosial dari, oleh, dan untuk masyarakat terutama generasi muda.',
            'visi' => 'Pemuda yang mandiri, peduli, dan berkontribusi bagi kemajuan lingkungan.',
            'misi' => "Mengembangkan kepemimpinan dan keterampilan pemuda.\nMenggerakkan kegiatan sosial dan lingkungan.\nMembangun kemitraan dengan warga dan pengurus lingkungan setempat.",
            'tujuan' => 'Terwujudnya pertumbuhan dan perkembangan setiap anggota masyarakat yang berkualitas, terampil, cerdas, inovatif, berkarakter serta memiliki kesadaran dan tanggung jawab sosial.',
            'alamat' => 'Wadassari RT 004/RW 002, Kel. Pondok Betung, Kec. Pondok Aren, Tangerang Selatan, Banten, 15221',
            'telepon' => '+62 852-1533-8228',
            'whatsapp' => '6285215338228',
            'email' => 'karupat04@karangtaruna.or.id',
            'jam_sekretariat' => 'Senin sampai Sabtu, 16.00 sampai 21.00 WIB',
            'instagram' => 'https://www.instagram.com/karupat0402_?obrf=N285cXV4Zml6dmV0',
            'facebook' => 'https://facebook.com',
            'youtube' => 'https://youtube.com',
            'maps_embed' => 'https://maps.google.com/maps?q=Wadassari+RT+004+RW+002+Pondok+Betung+Pondok+Aren+Tangerang+Selatan&t=&z=16&ie=UTF8&iwloc=&output=embed',
            'stat_anggota' => '18',
            'stat_kegiatan' => '24',
            'stat_bidang' => '6',
        ];
    }

    public static function semua(): array
    {
        $defaults = self::defaultValues();

        try {
            if (! Schema::hasTable('pengaturan')) {
                return $defaults;
            }
            $stored = self::query()->pluck('nilai', 'kunci')->toArray();

            return array_merge($defaults, array_filter($stored, fn ($v) => $v !== null && $v !== ''));
        } catch (\Throwable) {
            return $defaults;
        }
    }

    public static function ambil(string $kunci, mixed $default = null): mixed
    {
        $all = self::semua();

        return $all[$kunci] ?? $default;
    }
}
