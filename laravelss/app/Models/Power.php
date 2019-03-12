<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Power extends Model
{
    protected $table = 'shop_power_node';
    public $primaryKey='node_id';
    public $timestamps=false;
}
