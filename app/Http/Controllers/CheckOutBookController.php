<?php

namespace App\Http\Controllers;

use App\Models\Book;

class CheckOutBookController extends Controller
{
    //
    public function store(Book $book)
    {
        # code...
        $book->checkout(auth()->user());

    }
}
