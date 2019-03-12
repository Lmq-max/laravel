<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'shop_content_msg';
    public $primaryKey='id';
    public $timestamps=false;
}
