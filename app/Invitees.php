<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitees extends Model
{
    protected $table = 'tbl_invitees';
    protected $fillable = [
        'id','email','eventId','invited_on','status','created_by','updated_by','created_at','updated_at'
    ];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
