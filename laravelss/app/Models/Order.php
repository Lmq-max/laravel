<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'shop_order';
    public $primaryKey='order_id';
    public $timestamps=false;
}
