<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SummaryLottery extends Model
{
    protected $table = 'tbl_summary_lottery';
    public function staff()
    {
        return $this->belongsTo('App\Model\Staff', 's_id');
    }
    
}
