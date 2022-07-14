<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    //
    public function store(BookRequest $request)
    {
        # code...
        Book::create($request->validated());
    }


    public function update(BookRequest $request,Book $book)
    {
        # code...
        $book->update($request->validated());
    }
}
