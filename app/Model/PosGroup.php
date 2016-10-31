<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PosGroup extends Model
{
    protected $table = 'tbl_pos_group';
    protected $primaryKey = 'pg_id';

    public function poss()
    {
        return $this->belongsTo('App\Model\Pos');
    }

    public function groups()
    {
        return $this->belongsTo('App\Model\Group');
    }

    public $timestamps = false;

}
