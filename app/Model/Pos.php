<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Support\Decorators\Database\RelationMaker;
class Pos extends Model
{
    protected $table = 'tbl_pos';
    protected $primaryKey = 'pos_id';
    

    public function getId() {
    	return $this->pos_id;
    }

    public function groups()
    {
    	return new RelationMaker($this->belongsToMany('App\Model\Group','tbl_pos_group','g_id','pos_id'), $this);

    }
    public $timestamps = false;
    
}
