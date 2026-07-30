<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        Organization::create([
            'name' => 'HIMA Informatika',
            'slug' => Str::slug('HIMA Informatika'),
            'description' => 'Himpunan Mahasiswa Informatika',
        ]);

        Organization::create([
            'name' => 'BEM Universitas',
            'slug' => Str::slug('BEM Universitas'),
            'description' => 'Badan Eksekutif Mahasiswa',
        ]);

        Organization::create([
            'name' => 'UKM Musik',
            'slug' => Str::slug('UKM Musik'),
            'description' => 'Unit Kegiatan Mahasiswa Musik',
        ]);
    }
}