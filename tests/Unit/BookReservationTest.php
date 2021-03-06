<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
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
    }

    /**
     * @test
     */
    public function a_book_can_be_checked_out()
    {

        $this->book->checkout($this->user);

        $this->assertCount(1,Reservation::all());
        $this->assertEquals($this->user->id,Reservation::first()->user_id);
        $this->assertEquals($this->book->id,Reservation::first()->book_id);
        $this->assertEquals(now(),Reservation::first()->checked_out_at);

    }

    /**
     * @test
     */
    public function a_book_can_be_returned()
    {
        $this->book->checkout($this->user);
        $this->book->checkin($this->user);

        $this->assertCount(1,Reservation::all());
        $this->assertEquals($this->user->id,Reservation::first()->user_id);
        $this->assertEquals($this->book->id,Reservation::first()->book_id);
        $this->assertEquals(now(),Reservation::first()->checked_in_at);

    }

    /**
     * @test
     */
    public function a_user_can_check_out_book_twice()
    {

        $this->book->checkout($this->user);
        $this->book->checkin($this->user);

        $this->book->checkout($this->user);

        $this->assertCount(2,Reservation::all());
        $this->assertEquals($this->user->id,Reservation::find(2)->user_id);
        $this->assertEquals($this->book->id,Reservation::find(2)->book_id);
        $this->assertNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(),Reservation::find(2)->checked_out_at);

        $this->book->checkin($this->user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($this->user->id, Reservation::find(2)->user_id);
        $this->assertEquals($this->book->id, Reservation::find(2)->book_id);
        $this->assertNotNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_in_at);

    }
}
