<?php

namespace Laracommerce\Core\Addresses;

use Laracommerce\Core\Customers\Customer;
use Laracommerce\Core\Orders\Order;
use Laracommerce\Core\Provinces\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracommerce\Core\Cities\City;
use Laracommerce\Core\Countries\Country;
use Sofa\Eloquence\Eloquence;

class Address extends Model
{
    use SoftDeletes, Eloquence;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'alias',
        'address_1',
        'address_2',
        'zip',
        'city_id',
        'province_id',
        'country_id',
        'customer_id',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
