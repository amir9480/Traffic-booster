<?php

namespace Test;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $table='likes';
    protected $fillable=['user_id','website_id'];
    protected $primary='id';
    public $timestamps=false;
    
    public  function website()
    {
        return $this->belongsTo('Test\Websites','website_id','id');
    }
    
    public function user()
    {
        return $this->belongsTo('Test\UserManagment','user_id','id');
    }
    
}
