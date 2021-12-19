<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
   protected $table = 'tbl_events';
    protected $fillable = [
        'id','event_name','start_date','end_date','status','created_by','updated_by','created_at','updated_at'
    ];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
	
	public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
