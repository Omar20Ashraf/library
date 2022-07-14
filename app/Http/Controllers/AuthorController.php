<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    //
    public function store(Request $request)
    {
        # code...
        Author::create($request->all());
    }
}
