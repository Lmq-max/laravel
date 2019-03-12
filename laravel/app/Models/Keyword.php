<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $table = 'shop_keyword';
    public $primaryKey='id';
    public $timestamps=false;
}
