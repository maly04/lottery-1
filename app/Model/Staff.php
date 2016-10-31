<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'tbl_staff';
    protected $primaryKey = 's_id';
    
    public function staffCharges()
    {
        return $this->hasMany('App\Model\StaffCharge', 's_id');
    }

    public function staffTransactions()
    {
        return $this->hasMany('App\Model\StaffTransaction', 's_id');
    }

    public function summaryLotterys()
    {
        return $this->hasMany('App\Model\SummaryLottery', 's_id');
    }


}
