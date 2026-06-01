<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransactions extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone_number',
        'booking_trx',
        'office_space_id',
        'total_amount',
        'duration',
        'started_at',
        'ended_at',
        'is_paid',
    ];

    public static function generateUniqueTrxId(){
        $prefix = 'FO-';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx', $randomString)->exists());

        return $randomString;
    }

    public function getBookingTrxIdAttribute()
    {
        return $this->attributes['booking_trx'] ?? null;
    }

    public function setBookingTrxIdAttribute($value)
    {
        $this->attributes['booking_trx'] = $value;
    }

    public function officeSpace():BelongsTo{
        return $this->belongsTo(OfficeSpaces::class);
    }
}
