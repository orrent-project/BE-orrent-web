<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class OfficeSpaces extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'name',
        'slug',
        'thumbnail',
        'about',
        'city_id',
        'is_open',
        'is_full_booked',
        'price',
        'duration',
        'address',
    ];

    public function setNameAttribute($value){
        $this->attributes['name']=$value;
        $this->attributes['slug']=Str::slug($value);
    }

    public function city():BelongsTo{
        return $this->belongsTo(City::class);
    }

    public function benefits():HasMany{
        return $this->hasMany(OfficeSpaceBenefits::class, 'office_space_id');
    }

    public function photos():HasMany{
        return $this->hasMany(OfficeSpacePhotos::class, 'office_space_id');
    }

    public function bookingTransactions():HasMany{
        return $this->hasMany(BookingTransactions::class);
    }  
}
