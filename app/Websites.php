<?php

namespace Test;

use Illuminate\Database\Eloquent\Model;

class Websites extends Model
{
    protected $table='websites';
    protected $primary='id';

    protected $fillable = array('user_id','title','url','pointpervisit','views');
    public $timestamps=true;

    public function user()
    {
        return $this->belongsTo('Test\UserManagment','user_id','id');
    }

    public function views()
    {
        return $this->hasMany('Test\WebsiteViews','website_id','id');
    }
    
    
    public function likes()
    {
        return $this->hasMany('Test\Likes','website_id','id');
    }
    
}
