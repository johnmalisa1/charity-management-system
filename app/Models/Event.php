<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'charity_id',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];

    // Each event belongs to one charity
    public function charity()
    {
        return $this->belongsTo(Charity::class);
    }

    // ✅ Participants relationship
    public function participants()
    {
        return $this->hasMany(EventParticipant::class);
    }

    // ✅ Volunteers relationship (pivot table event_volunteer)
    public function volunteers()
    {
        return $this->belongsToMany(User::class, 'event_volunteer')->withTimestamps();
    }

    // ✅ Donors relationship (pivot table event_donor)
    public function donors()
    {
        return $this->belongsToMany(User::class, 'event_donor')->withTimestamps();
    }

    // Optional: link to campaign if events are tied to fundraising
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    // ✅ Galleries relationship
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}










