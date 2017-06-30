<?php

namespace Test;

use Illuminate\Database\Eloquent\Model;

class WebsiteViews extends Model
{
    protected $table='website_views';
    protected $primary='id';

    protected $fillable = array('user_id','website_id','view_token','last_view');
    public $timestamps=false;
    
    
    public function website()
    {
        return $this->belongsTo('Test\Websites','website_id','id');
    }
    
    public function user()
    {
        return $this->belongsTo('Test\UserManagment','user_id','id');
    }
}
