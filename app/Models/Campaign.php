<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'charity_id',
        'title',
        'description',
        'goal_amount',
        'start_date',
        'end_date',
    ];

    public function charity()
    {
        return $this->belongsTo(Charity::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    // ✅ New relationship: Campaign → Galleries
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}


