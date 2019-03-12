<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDefault extends Model
{
    protected $table = 'shop_order_detail';
    public $primaryKey='address_id';
    public $timestamps=false;
}
