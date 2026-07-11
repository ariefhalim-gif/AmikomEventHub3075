<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Music',
                'description' => 'Event konser dan musik'
            ],
            [
                'id' => 2,
                'name' => 'Technology',
                'description' => 'Workshop dan seminar IT'
            ],
            [
                'id' => 3,
                'name' => 'Sports',
                'description' => 'Kompetisi olahraga'
            ],
            [
                'id' => 4,
                'name' => 'Education',
                'description' => 'Pelatihan dan edukasi'
            ]
        ];

        return view('admin.categories.index', compact('categories'));
    }
}