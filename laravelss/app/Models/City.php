<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'shop_city';
    public $primaryKey='id';
    public $timestamps=false;
}
