<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    
    protected $table = 'users';
    
	public $timestamps = false;
	
	protected $hidden = ['password'];
	
}
