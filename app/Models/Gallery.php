<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'event_id',     // link to charity event
        'campaign_id',  // link to campaign
    ];

    // Relationship: each gallery image belongs to one event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // ✅ New relationship: each gallery image can belong to one campaign
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}



