<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use \Config;

use Request;
use Response;
use Validator;

use App\Models\ConfigApp;

class ConfigAppController extends Controller {
    
    public function __construct() {
        $this->middleware('auth', ['except' => 'login']);
        $this->middleware('role:admin', ['except' => ['show']]);
    }

    public function getIndex(){
        $data['breadcrumbs'] = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "javascript:void(0)", 'name' => "Konfigurasi Aplikasi"],
        ];

        $data['item'] = ConfigApp::first();
        $data['m_admin_config_app'] = 'active';

        return view('admin.config-app.index')->with($data);
    }

    public function postUpdate(){
        $request = Request::all();
        $config = ConfigApp::first();
        $id = isset($config->id) ? $config->id : 0;
        $validator = Validator::make($request, ConfigApp::rules($id));
        if($validator->passes()){
            $logo = Request::file('logo');
            $filename = null;
            if($logo){
                $disk = Storage::disk('public');
                $dir = Config::get('values.config_dir');
                if(!$disk->exists(storage_path($dir))) {
                    $disk->makeDirectory($dir,0776, true, true);
                }
                
                $filename = 'app-logo.'.$logo->getClientOriginalExtension();
                $filepath = $dir.'/'. $filename;
                if($config){
                    $disk->delete($dir.'/'.$config->logo);
                }
                $disk->put($filepath, file_get_contents($logo->getRealPath()));  
            }
            $request['logo'] = $filename;

            if($config){
                $config->update($request);
            } else {
                $request['id'] = Str::uuid()->toString();
                ConfigApp::create($request);
            }
            return redirect('/admin/config-app')->with('status', 'Data telah disimpan');
        }else{
            return redirect('/admin/config-app')->withInput()->withErrors($validator);
        }
    }

    public function getReset(){
        $config = ConfigApp::first();
        if($config){
            $disk = Storage::disk('public');
            $dir = Config::get('values.config_dir');
            $disk->delete($dir.'/'.$config->logo);
        }
        ConfigApp::truncate();
        return redirect('/admin/config-app')->with('status', 'Data telah disimpan');
    }
}
