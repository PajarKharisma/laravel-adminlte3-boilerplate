<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Shanmuga\LaravelEntrust\Models\EntrustRole;
use Illuminate\Validation\Rule;

class Role extends EntrustRole
{
    use HasFactory;

    protected $table = 'roles';
    public $primaryKeys = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'display_name',
        'description'
    ];

	public static function rules($id=0){
        return [
            'name' => [
                'required',
                Rule::unique('roles','name')->ignore($id, 'id')
            ],
            'display_name' => 'required|min:1',
			'description' => 'required|min:1',
        ];
    }

	public function roleUser(){
		return $this->hasMany(RoleUser::class,'role_id','id');
	}
}
