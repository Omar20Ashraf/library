<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    private $book;
    private $user;

    public function setUp(): void
    {
        # code...
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->book = Book::factory()->create();
        $this->user = User::factory()->create();

        $this->actingAs($this->user)->post('/checkout/' . $this->book->id);
    }

    /**
     * @test
     */
    public function a_book_can_be_checked_out_by_signed_in_user()
    {
        $this->assertCount(1, Reservation::all());
        $this->assertEquals($this->user->id, Reservation::first()->user_id);
        $this->assertEquals($this->book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);

    }

    /**
     * @test
     */
    public function a_book_can_be_checked_in_by_signed_in_user()
    {

        $this->actingAs($this->user)->post('/checkin/' . $this->book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($this->user->id, Reservation::first()->user_id);
        $this->assertEquals($this->book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }
}
