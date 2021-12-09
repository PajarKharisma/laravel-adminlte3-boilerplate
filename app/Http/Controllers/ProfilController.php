<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use \Config;

use Auth;
use Request;
use Response;
use Validator;

use App\Models\User;


class ProfilController extends Controller {

    public function __construct() {
        $this->middleware('auth', ['except' => 'login']);
    }

    public function getIndex(){
        $data['breadcrumbs'] = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "javascript:void(0)", 'name' => "Profil"],
        ];

        $data['item'] = Auth::user();
        $data['disabled'] = true;

        return view('profil.index')->with($data);
    }

    public function postUpdate(){
        $request = Request::all();
        $user = Auth::user();
        $validator = Validator::make($request, User::rules($user->id));
        if($validator->passes()){
            $foto = Request::file('foto');
            $filename = null;
            if($foto){
                $disk = Storage::disk('public');
                $dir = Config::get('values.avatar_dir');
                if(!$disk->exists(storage_path($dir))) {
                    $disk->makeDirectory($dir,0776, true, true);
                }
                
                $filename = 'avatar-'.$request['id'].'.'.$foto->getClientOriginalExtension();
                $filepath = $dir.'/'. $filename;
                $disk->delete($dir.'/'.$user->foto);
                $disk->put($filepath, file_get_contents($foto->getRealPath()));  
            }
            $request['foto'] = $filename;

            $is_pass_changed = false;
            if($request['password'] != null){
                $is_pass_changed = true;
                $request['password'] = bcrypt($request['password']);
            } else {
                unset($request['password']);
            }

            $user->update($request);

            if($is_pass_changed){
                Auth::logout();
                return redirect('/login')->with('status', 'Data tersimpan. Silahkan login kembali dengan password baru.');
            }
            return redirect('/profil')->with('status', 'Data tersimpan.');
        }else{
            return redirect('/profil')->withInput()->withErrors($validator);
        }
    }
}
