<?php

use App\Models\ConfigApp;

if(!function_exists('get_avatar_path')){
    function get_avatar_path($user) {
        $dir = Config::get('values.avatar_dir');
        if($user->foto){
            return asset('storage/'.$dir.'/'.$user->foto);
        } else {
            return asset('storage/'.$dir.'/default-avatar.png');
        }
    }
}

if(!function_exists('get_config_app')){
    function get_config_app() {
        $dir = Config::get('values.config_dir');
        $config = ConfigApp::first();
        if($config){
            return [
                'title' => $config->title != null ? $config->title : 'APLIKASI',
                'logo' => $config->logo != null ? asset('storage/'.$dir.'/'.$config->logo) : asset('/lte/dist/img/default-logo.png')
            ];
        } else {
            return [
                'title' => 'APLIKASI',
                'logo' => asset('/lte/dist/img/default-logo.png')
            ];
        }
    }
}