<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denuncias extends Model 
{
    
    protected $table = 'denuncias';
    
	public $timestamps = false;
	
	public function user()
    {
        return $this->belongsTo('App\Models\Usuario', 'users_id');
    }
	
}
