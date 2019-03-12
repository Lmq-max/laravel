<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'shop_category';
    public $primaryKey='cate_id';
    public $timestamps=false;

    public function goods(){
        return $this->hasMany('App\Models\Goods' , 'cate_id' , 'cate_id');
    }

}
