<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // handle seeder semester
        DB::table('semester')->insert([
            [
                'semester_tipe' => 'Semester 1'
            ],
            [
                'semester_tipe' => 'Semester 2'
            ],
            [
                'semester_tipe' => 'Semester 3'
            ],
            [
                'semester_tipe' => 'Semester 4'
            ],
            [
                'semester_tipe' => 'Semester 5'
            ],
            [
                'semester_tipe' => 'Semester 6'
            ],
            [
                'semester_tipe' => 'Semester 7'
            ],
            [
                'semester_tipe' => 'Semester 8'
            ],
        ]);

        // handle seeder kelas
        DB::table('kelas')->insert([
            [
                'nama_kelas'    => 'Kelas A'
            ],
            [
                'nama_kelas'    => 'Kelas B'
            ]
        ]);

        // handle seeder user
        DB::table('users')->insert([
            [
                'username'       => 'nepil',
                'password'       => bcrypt('123nepil456'),
                'email'          => 'nepil@gmail.com',
                'level'          => 'admin',
                'nama'           => 'Neville Jeremy Onorato Laia',
                'nim'            => null,
                'nip'            => null,
                'kelas_id'       => null,
                'jenis_kelamin'  => 'Laki-Laki',
                'tempat_lahir'   => 'Medan',
                'tanggal_lahir'  => '2005-09-22',
                'image'          => 'default.png',
                'no_telepon'     => '082373919293',
                'provinsi'       => 'Sumatera Utara',
                'kabupaten_kota' => 'Deli Serdang',
                'kecamatan'      => 'Pancur Batu',
                'desa_kelurahan' => 'LAMA',
                'alamat'         => 'Jl. Pipa no. 4',
                'semester_id'    => 5,
                'status'         => 'terverifikasi'
            ],
            [
                'username'       => 'erikaja01',
                'password'       => bcrypt('123erik456'),
                'email'          => 'erik@gmail.com',
                'level'          => 'dosen',
                'nama'           => 'Erik Bertua',
                'nip'            => '198107092021211000',
                'nim'            => null,
                'kelas_id'       => null,
                'jenis_kelamin'  => 'Laki-Laki',
                'tempat_lahir'   => 'Medan',
                'tanggal_lahir'  => '1990-09-22',
                'image'          => 'default.png',
                'no_telepon'     => '082173919293',
                'provinsi'       => 'Sumatera Utara',
                'kabupaten_kota' => 'Deli Serdang',
                'kecamatan'      => 'Pancur Batu',
                'desa_kelurahan' => 'BARU',
                'alamat'         => 'Jl. Pipa no. 4',
                'semester_id'    => 2,
                'status'         => 'terverifikasi'
            ],
            [
                'username'       => 'pokuji',
                'password'       => bcrypt('123pokuji456'),
                'email'          => 'pokuji@gmail.com',
                'level'          => 'mahasiswa',
                'nama'           => 'Pokuji San Jaya',
                'nip'            => null,
                'nim'            => '2003090',
                'kelas_id'       => 1,
                'jenis_kelamin'  => 'Laki-Laki',
                'tempat_lahir'   => 'Medan',
                'tanggal_lahir'  => '1990-09-22',
                'image'          => 'default.png',
                'no_telepon'     => '082173919293',
                'provinsi'       => 'Sumatera Utara',
                'kabupaten_kota' => 'Deli Serdang',
                'kecamatan'      => 'Pancur Batu',
                'desa_kelurahan' => 'BARU',
                'alamat'         => 'Jl. Pipa no. 4',
                'semester_id'    => 2,
                'status'         => 'terverifikasi'
            ],
            [
                'username'       => 'citra04',
                'password'       => bcrypt('123citra456'),
                'email'          => 'citra@gmail.com',
                'level'          => 'mahasiswa',
                'nama'           => 'Citra Putri',
                'nip'            => null,
                'nim'            => '2003000',
                'kelas_id'       => 2,
                'jenis_kelamin'  => 'Perempuan',
                'tempat_lahir'   => 'Medan',
                'tanggal_lahir'  => '1990-09-22',
                'image'          => 'default.png',
                'no_telepon'     => '082173919293',
                'provinsi'       => 'Sumatera Utara',
                'kabupaten_kota' => 'Deli Serdang',
                'kecamatan'      => 'Pancur Batu',
                'desa_kelurahan' => 'BARU',
                'alamat'         => 'Jl. Pipa no. 4',
                'semester_id'    => 2,
                'status'         => 'terverifikasi'
            ],
        ]);


        // handle data mata kuliah
        DB::table('matkul')->insert([
            'dosen_id'          => 2,
            'image'             => 'code.png',
            'nama_matkul'       => 'Mobile Programming',
            'semester_id'       => 2,
            'deskripsi'         => '-',
            'status'            => 'aktif'
        ]);

        // handle data modul
        DB::table('modul')->insert([
            'matkul_id'         => 1,
            'kelas_id'          => 1,
            'nama_modul'        => 'Rest API',
            'file_modul'        => 'oke.pdf',
            'deskripsi'         => 'okelah'
        ]);
    }
}
