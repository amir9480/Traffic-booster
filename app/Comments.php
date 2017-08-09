<?php

namespace Test;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments';
    protected $primary = 'id';
    protected $fillable = ['user_id','website_id','content'];
    
    public function website()
    {
        return $this->belongsTo('Test\Websites','id','website_id');
    }
    
    
    public function user()
    {
        return $this->belongsTo('Test\UserManagment','user_id','id');
    }
    
}
