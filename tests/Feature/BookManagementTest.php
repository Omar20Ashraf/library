<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_book_can_be_added_to_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books',[
            'title' => 'cracking',
            'author' => 'name',
        ]);

        $book = Book::first();

        $this->assertCount(1,Book::all());

        $response->assertRedirect('/books/' . $book->id);
    }

    /**
     * @test
     */
    public function a_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'name',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'title',
            'author' => 'name',
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'. $book->id, [
            'title' => 'new title',
            'author' => 'new name',
        ]);

        $this->assertEquals('new title',Book::first()->title);
        $this->assertEquals('new name',Book::first()->author);

        $response->assertRedirect('/books/'.$book->id);
    }

    /**
     * @test
     */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'title',
            'author' => 'name',
        ]);

        $book = Book::first();

        $response = $this->delete('/books/'. $book->id);

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
}
