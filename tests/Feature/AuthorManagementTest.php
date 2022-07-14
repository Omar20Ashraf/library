<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Author;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_author_can_be_created()
    {
        # code...
        $this->withoutExceptionHandling();

        $this->post('/author',[
            'name' => 'name',
            'date_of_birth' => '15-9-1990',
        ]);

        $this->assertCount(1,Author::all());

    }
}
