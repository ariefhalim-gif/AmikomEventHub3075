<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Organizations
        |--------------------------------------------------------------------------
        */

        $hima = Organization::create([
            'name' => 'HIMA Informatika',
            'slug' => Str::slug('HIMA Informatika'),
            'description' => 'Himpunan Mahasiswa Informatika',
        ]);

        $bem = Organization::create([
            'name' => 'BEM Universitas',
            'slug' => Str::slug('BEM Universitas'),
            'description' => 'Badan Eksekutif Mahasiswa',
        ]);

        $ukm = Organization::create([
            'name' => 'UKM Musik',
            'slug' => Str::slug('UKM Musik'),
            'description' => 'Unit Kegiatan Mahasiswa Musik',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@amikom.ac.id',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        User::create([
            'name' => 'Admin HIMA',
            'email' => 'hima@amikom.ac.id',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'organization_id' => $hima->id,
        ]);

        User::create([
            'name' => 'Admin BEM',
            'email' => 'bem@amikom.ac.id',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'organization_id' => $bem->id,
        ]);

        User::create([
            'name' => 'Admin UKM Musik',
            'email' => 'ukm@amikom.ac.id',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'organization_id' => $ukm->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $category1 = Category::create([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);

        $category2 = Category::create([
            'name' => 'Entertainment',
            'slug' => 'entertainment',
        ]);

        $category3 = Category::create([
            'name' => 'Workshop',
            'slug' => 'workshop',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Events
        |--------------------------------------------------------------------------
        */

        Event::create([
            'organization_id' => $ukm->id,
            'category_id' => $category2->id,
            'title' => 'Jazz Night 2025',
            'description' => 'Nikmati malam yang indah dengan alunan musik.',
            'date' => '2026-05-10 19:00:00',
            'location' => 'Amikom Baru',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-1.png',
        ]);

        Event::create([
            'organization_id' => $hima->id,
            'category_id' => $category1->id,
            'title' => 'AI Summit & Expo 2026',
            'description' => 'Jelajahi tren terkini dalam bidang Artificial Intelligence.',
            'date' => '2026-05-01 13:00:00',
            'location' => 'Ruang Cinema',
            'price' => 45000,
            'stock' => 150,
            'poster_path' => 'posters/event-2.png',
        ]);

        Event::create([
            'organization_id' => $hima->id,
            'category_id' => $category3->id,
            'title' => 'Laravel Bootcamp',
            'description' => 'Belajar Laravel dari dasar hingga mahir.',
            'date' => '2026-06-15 09:00:00',
            'location' => 'Lab Komputer 1',
            'price' => 75000,
            'stock' => 50,
            'poster_path' => 'posters/event-3.png',
        ]);

        Event::create([
            'organization_id' => $hima->id,
            'category_id' => $category3->id,
            'title' => 'UI/UX Masterclass',
            'description' => 'Pelajari desain UI/UX modern.',
            'date' => '2026-06-20 08:00:00',
            'location' => 'Lab Multimedia',
            'price' => 60000,
            'stock' => 80,
            'poster_path' => 'posters/event-4.png',
        ]);

        Event::create([
            'organization_id' => $bem->id,
            'category_id' => $category2->id,
            'title' => 'E-Sport Championship',
            'description' => 'Turnamen E-Sport tingkat nasional.',
            'date' => '2026-07-05 10:00:00',
            'location' => 'GOR Amikom',
            'price' => 25000,
            'stock' => 300,
            'poster_path' => 'posters/event-5.png',
        ]);

        Event::create([
            'organization_id' => $hima->id,
            'category_id' => $category1->id,
            'title' => 'Cyber Security Conference',
            'description' => 'Seminar keamanan siber bersama praktisi industri.',
            'date' => '2026-08-10 13:00:00',
            'location' => 'Auditorium Amikom',
            'price' => 100000,
            'stock' => 120,
            'poster_path' => 'posters/event-6.png',
        ]);
    }
}