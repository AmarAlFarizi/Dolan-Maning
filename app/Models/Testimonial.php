<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'origin',
        'message',
        'rating',
        'is_approved',
        'reply_admin',
    ];
}
