<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'skills',
        'availability',
        'user_id',   // if linked to a User account
    ];

    // If volunteers belong to users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // If volunteers join events
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_participants');
    }
}

