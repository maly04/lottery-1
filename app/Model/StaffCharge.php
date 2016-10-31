<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StaffCharge extends Model
{
    protected $table = 'tbl_staff_charge';

    public function staff()
    {
        return $this->belongsTo('App\Model\Staff', 's_id');
    }
    
}
