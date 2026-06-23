<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use App\Models\Donation;
use App\Models\VolunteerActivity;
use App\Models\Event;
use App\Models\Participation;
use App\Models\Notification;
use App\Models\Feedback;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo', // ✅ allow photo uploads
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ✅ Donations made by the user
    public function donations()
    {
        return $this->hasMany(Donation::class, 'donor_id');
    }

    // ✅ Events joined via volunteer pivot table
    public function joinedEvents()
    {
        return $this->belongsToMany(Event::class, 'event_volunteer')->withTimestamps();
    }

    // ✅ Events joined via donor pivot table
    public function joinedDonorEvents()
    {
        return $this->belongsToMany(Event::class, 'event_donor')->withTimestamps();
    }

    // ✅ Volunteer activities (for VolunteerController)
    public function activities()
    {
        return $this->hasMany(VolunteerActivity::class, 'user_id');
    }

    // ✅ Volunteer activities (for DonorController)
    public function volunteerActivities()
    {
        return $this->hasMany(VolunteerActivity::class, 'user_id');
    }

    // ✅ Participation records (hours, status, etc.)
    public function participations()
    {
        return $this->hasMany(Participation::class, 'user_id');
    }

    // ✅ Notifications for the user
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    // ✅ Feedback submitted by the user
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }

    // ✅ Accessor for full photo URL with silhouette fallback
    public function getPhotoUrlAttribute(): string
    {
        return $this->photo 
            ? Storage::url($this->photo) 
            : asset('images/default-avatar.png'); // silhouette fallback
    }
}












