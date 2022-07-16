<?php

namespace App\Http\Controllers;

use App\Models\Book;

class CheckInBookController extends Controller
{
    //
    public function store(Book $book)
    {
        # code...
        $book->checkin(auth()->user());

    }
}
