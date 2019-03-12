<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class W_login extends Model
{
    protected $table = 'shop_wechat_login';
    public $primaryKey='id';
    public $timestamps=false;
}
