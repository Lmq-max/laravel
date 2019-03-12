<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'shop_address';
    public $primaryKey='address_id';
    public $timestamps=false;
}
