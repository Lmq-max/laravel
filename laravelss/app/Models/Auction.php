<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $table = 'auction';
    public $primaryKey='g_id';
    public $timestamps=false;
}
