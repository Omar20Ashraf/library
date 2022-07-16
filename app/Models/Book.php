<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = ['title', 'author_id'];

    public function setAuthorIdAttribute($author)
    {
        # code...
        $this->attributes['author_id'] = Author::firstOrCreate([
            'name' => $author
        ])->id;
    }
}
