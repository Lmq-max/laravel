<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'shop_goods';
    public $primaryKey='goods_id';
    public $timestamps=false;
    public function goodsSku(){
        return $this->hasMany('App\Models\GoodsSku' , 'goods_id' , 'goods_id');
    }

}
