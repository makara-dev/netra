<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Staff extends Model
{
    protected $table = 'staffs';
    
    protected $primaryKey = 'staff_id';

    protected $fillable = [
        'avatar'
    ];

    protected $guarded =[
        'is_admin'
    ];
    
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    //one to one relationship
    public function user(){
        return $this->belongsTo(User::class,'user_id','user_id');
    }
}
