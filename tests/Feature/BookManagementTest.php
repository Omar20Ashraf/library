<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
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

        $response = $this->post('/books', $this->data());

        $book = Book::first();

        $this->assertCount(1,Book::all());

        $response->assertRedirect('/books/' . $book->id);
    }

    /**
     * @test
     */
    public function a_title_is_required()
    {
        $response = $this->post('/books',array_merge($this->data(), ['title' => '',]));

        $response->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch('/books/'. $book->id, [
            'title' => 'new title',
            'author_id' => 'new author',
        ]);

        $this->assertEquals('new title',Book::first()->title);
        $this->assertEquals(2,Book::first()->author_id);

        $response->assertRedirect('/books/'.$book->id);
    }

    /**
     * @test
     */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->delete('/books/'. $book->id);

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }

    /**
     * @test
     */
    public function a_new_author_is_automatically_created()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id,$book->author_id);
        $this->assertCount(1,Author::all());
    }

    public function data()
    {
        # code...
        return [
            'title' => 'title',
            'author_id' => 'victor',
        ];
    }
}
