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

    public function reservations()
    {
        # code...
        return $this->hasMany(Reservation::class,'book_id');
    }

    public function checkout($user)
    {
        # code...

        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now(),
        ]);
    }

    public function checkin($user)
    {
        # code...
        $reservation =  $this->reservations()
                            ->where('user_id',$user->id)
                            ->whereNotNull('checked_out_at')
                            ->whereNull('checked_in_at')
                            ->first();

        $reservation->update(['checked_in_at' => now()]);
    }
}
