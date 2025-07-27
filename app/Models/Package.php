<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_id','user_id', 'city_id', 'area_id', 'property_id',
        'name', 'address', 'map_link', 'number_of_rooms','number_of_kitchens',
        'seating', 'details', 'video_link' , 'common_bathrooms'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function maintains(): BelongsToMany
    {
        return $this->belongsToMany(Maintain::class, 'package_maintains')
                    ->withPivot('is_paid', 'price');
    }


    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'package_amenities')
                    ->withPivot('is_paid', 'price');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function entireProperty()
    {
        return $this->hasOne(EntireProperty::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }



}
