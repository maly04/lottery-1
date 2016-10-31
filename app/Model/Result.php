<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'tbl_result';
    protected $dates = ['re_date'];
    protected $fillable = ['re_id','re_date','re_num_result','pos_id','created_at','updated_at'];

}
