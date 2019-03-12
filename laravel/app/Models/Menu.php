<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'shop_menu';
    public $primaryKey='menu_id';
    public $timestamps=false;
}
