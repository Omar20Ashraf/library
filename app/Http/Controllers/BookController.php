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
        $book =  Book::create($request->validated());

        return redirect('/books/' . $book->id);
    }


    public function update(BookRequest $request,Book $book)
    {
        # code...
        $book->update($request->validated());

        return redirect('/books/'.$book->id);
    }


    public function destroy(Book $book)
    {
        # code...
        $book->delete();

        return redirect('/books');
    }
}
