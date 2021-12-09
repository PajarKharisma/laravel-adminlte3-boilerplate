<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model {

    use HasFactory;
    protected $table = 'role_user';
	protected $fillable = [
        'role_id',
        'user_id',
    ];

	public $incrementing = false;
	public $timestamps = false;

	public function role(){
		return $this->belongsTo(Role::class,'role_id','id');
	}

	public function user(){
		return $this->belongsTo(User::class,'user_id','id');
	}
}
