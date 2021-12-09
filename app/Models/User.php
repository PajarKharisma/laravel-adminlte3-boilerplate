<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Shanmuga\LaravelEntrust\Traits\LaravelEntrustUserTrait;
use Illuminate\Validation\Rule;

use DB;

class User extends Authenticatable {
    
    use LaravelEntrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
	public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'email',
        'foto',
        'password',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function rules($ignore_id=0){
        return [
            'id' => [
                'required',
                Rule::unique('users','id')->ignore($ignore_id, 'id')
            ],
            'password' =>  [
                'nullable',
                'min:6'
            ],
            'email' => [
                'required'
            ],
            'foto' => [
                'nullable',
                'mimes:jpeg,jpg,png,JPG,PNG'
            ],
        ];
    }

    public function roleUser(){
		return $this->hasMany(RoleUser::class,'user_id','id');
	}

    public function detachAllRoles(){
		DB::table('role_user')->where('user_id', $this->id)->delete();
		return $this;
 	}
}
