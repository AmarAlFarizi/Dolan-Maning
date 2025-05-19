<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingTransaction extends Model
{
    use HasFactory, softDeletes;
    
    //mass assignment
    protected $fillable = 
    [
        'name',
        'booking_trx_id',
        'phone_number',
        'email',
        'proof',
        'total_amount',
        'total_participant',
        'is_paid',
        'started_at',
        'ticket_id',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }
}
