<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StaffTransaction extends Model
{
    protected $table = 'tbl_staff_transction';
    protected $primaryKey = 'st_id';
    public function staff()
    {
        return $this->belongsTo('App\Model\Staff', 's_id');
    }
    
}
