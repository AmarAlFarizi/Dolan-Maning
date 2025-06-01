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

    protected $casts = [
        'started_at' => 'date'
    ];

    //generate kode unik dengan prefix BMS
    public static function generateUniqueTrxId()
    {
        $prefix = 'BMS';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
