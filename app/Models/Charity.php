<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'registration_number',
        'manager_id',
    ];

    // Each charity belongs to a manager (User)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // Each charity can have many documents
    public function documents()
    {
        return $this->hasMany(CharityDocument::class);
    }

    // ✅ New: Each charity can have many events
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}


