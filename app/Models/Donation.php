<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'campaign_id',
        'amount',
    ];

    // Relationship to User (donor)
    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    // Relationship to Campaign
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}

