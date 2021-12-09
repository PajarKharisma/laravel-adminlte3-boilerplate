<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class ConfigApp extends Model {
    use HasFactory;

    protected $table = 'config_app';
    protected $primaryKey = 'id';
	public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'logo',
    ];

    public static function rules($ignore_id=0){
        return [
            'id' => [
                Rule::unique('config_app','id')->ignore($ignore_id, 'id')
            ],
            'title' => [
                'required'
            ],
            'foto' => [
                'nullable',
                'mimes:jpeg,jpg,png,JPG,PNG'
            ],
        ];
    }
}
