<?php

namespace Laracommerce\CustomerGroup\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laracommerce\Core\Customers\Customer;

/**
 * Class Group
 * @package Laracommerce\CustomerGroup\Core
 */
class CustomerGroup extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
