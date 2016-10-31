<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Support\Decorators\Database\RelationMaker;
class Group extends Model
{
    protected $table = 'tbl_group';
    protected $primaryKey = 'g_id';
    protected $guarded = ['g_id','g_name', 'g_info'];

	public function getId() {
    	return $this->g_id;
    }
    
    public function poss()
    {
    	return new RelationMaker($this->belongsToMany('App\Model\Pos','tbl_pos_group','g_id','pos_id'), $this);
    }
    
    public $timestamps = false;

}
