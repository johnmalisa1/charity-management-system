<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',     // ✅ include event_id for linking to events
        'activity_name',
        'description',
        'date',
        'status',       // ✅ include status
    ];

    // ✅ Cast date to Carbon
    protected $casts = [
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}




