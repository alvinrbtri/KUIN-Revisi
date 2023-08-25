<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel, WithStartRow, WithChunkReading, WithBatchInserts
{
    public function model(array $row)
    {
        if ($row[3] == 'dosen') {
            $semester = null;
            $tempat_lahir = null;
            $tanggal_lahir = null;
            $nip = null;
            $nim = null;
        } elseif ($row[3] == 'mahasiswa') {
            $semester = $row[8];
            $tempat_lahir = null; 
            $tanggal_lahir = null; 
            $nim = $row[6];
            $nip = null;
        }

        // Mendapatkan kelas_id dari tabel kelas berdasarkan nama kelas
        $kelas = Kelas::where('nama_kelas', $row[4])->first();
        $kelas_id = $kelas ? $kelas->kelas_id : null;

        return new User([
            'username'          => $row[1],
            'password'          => Hash::make('kuin#' . $row[1]),
            'email'             => $row[2],
            'level'             => $row[3],
            'nama'              => $row[0],
            'nip'               => $nip,
            'nim'               => $nim,
            'kelas_id'          => $kelas_id,
            'jenis_kelamin'     => $row[5],
            'tempat_lahir'      => $tempat_lahir,
            'tanggal_lahir'     => $tanggal_lahir,
            'image'             => 'default.png',
            'no_telepon'        => $row[7],
            'semester_id'       => $semester,
            'status'            => 'terverifikasi',
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
