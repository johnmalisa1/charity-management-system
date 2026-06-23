<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharityDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'charity_id',
        'file_path',
        'description',
    ];

    public function charity()
    {
        return $this->belongsTo(Charity::class);
    }
}

