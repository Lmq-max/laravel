<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsSku extends Model
{
    protected $table = 'shop_goods_sku';
    public $primaryKey='sku_id';
    public $timestamps=false;
    public function goods(){
        return $this->belongsTo('App\Models\Goods' , 'goods_id' , 'goods_id');
    }


}
