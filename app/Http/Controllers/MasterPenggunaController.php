<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use \Config;

use Request;
use Response;
use Validator;
use DB;

use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;

class MasterPenggunaController extends Controller {
    
    public function __construct() {
        $this->middleware('auth', ['except' => 'login']);
        $this->middleware('role:admin', ['except' => ['show']]);
    }

    public function getIndex($key='list', $role='admin'){
        $data['breadcrumbs'] = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "javascript:void(0)", 'name' => "Kelola Pengguna"],
        ];
        $data['m_admin_master_pengguna'] = 'active';
        $data['m_admin_kelola_pengguna'] = 'menu-open';
        $request = Request::all();
        
        $list = null;
        $list = RoleUser::whereHas('role', function($q) use($role){
            $q->where('name', $role);
        });

        $searchtext = isset($request['searchtext']) ? $request['searchtext'] : null;
        if($searchtext != null){
            $list = $list->whereHas('user', function($q) use ($searchtext){
                $q->where('id', 'LIKE', '%'.$searchtext.'%')
                ->orWhere('name', 'LIKE', '%'.$searchtext.'%');
            });
        }
        $data['searchtext'] = $searchtext;
        $data['roles'] = Role::orderBy('display_name')->get();
        $data['active_tab'] = $role;
        $data['list'] = $list->paginate(20)->appends(request()->query());

        return view('admin.master.pengguna.index')->with($data);
    }

    public function getCreate(){
        $data['breadcrumbs'] = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/admin/master-pengguna", 'name' => "Kelola Pengguna"],
            ['link' => "javascript:void(0)", 'name' => "Buat Baru"],
        ];
        $data['m_admin_master_pengguna'] = 'active';
        $data['m_admin_kelola_pengguna'] = 'menu-open';

        $data['roles'] = Role::pluck('display_name', 'id')->toArray();

        return view('admin.master.pengguna.create')->with($data);
    }

    public function postSave(){
        $request = Request::all();
        $validator = Validator::make($request, User::rules());
        if($validator->passes()){
            $foto = Request::file('foto');
            $filename = null;
            if($foto){
                $disk = Storage::disk('public');
                if(!$disk->exists(storage_path('avatar'))) {
                    $disk->makeDirectory('avatar',0776, true, true);
                }
                
                $filename = 'avatar-'.$request['id'].'.'.$foto->getClientOriginalExtension();
                $filepath = Config::get('values.avatar_dir').'/'. $filename;
                $disk->put($filepath, file_get_contents($foto->getRealPath()));
            }

            $request['foto'] = $filename;
            $request['password'] = bcrypt($request['password']);
            $user = User::create($request);

            foreach ($request['roles'] as $key => $value) {
                $user->attachRole($value);
            }

            return redirect('/admin/master-pengguna')->with('status', 'Data telah disimpan');
        }else{
            return redirect('/admin/master-pengguna/create')->withInput()->withErrors($validator);
        }
    }

    public function getEdit($id){
        $data['breadcrumbs'] = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/admin/master-pengguna", 'name' => "Kelola Pengguna"],
            ['link' => "javascript:void(0)", 'name' => "Edit Data"],
        ];
        $data['m_admin_master_pengguna'] = 'active';
        $data['m_admin_kelola_pengguna'] = 'menu-open';

        $data['item'] = User::findorfail($id);
        $data['disabled'] = true;
        $data['roles'] = Role::pluck('display_name', 'id')->toArray();

        return view('admin.master.pengguna.edit')->with($data);
    }

    public function postUpdate($id){
        $request = Request::all();
        $validator = Validator::make($request, User::rules($id));
        if($validator->passes()){
            $user = User::findorfail($id);

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

            if($request['password'] != null){
                $request['password'] = bcrypt($request['password']);
            } else {
                unset($request['password']);
            }

            $user->update($request);
            $user->detachAllRoles();
            foreach ($request['roles'] as $key => $value) {
                $user->attachRole($value);
            }
            return redirect('/admin/master-pengguna')->with('status', 'Data telah disimpan');
        }else{
            return redirect('/admin/master-pengguna/edit/'.$id)->withInput()->withErrors($validator);
        }
    }

    public function getDelete($id){
        $user = User::findorfail($id);
        $user->detachAllRoles();
        if($user->foto){
            $disk = Storage::disk('public');
            $dir = Config::get('values.avatar_dir');
            $disk->delete($dir.'/'.$user->foto);
        }
        $user->delete();
        return redirect('/admin/master-pengguna')->with('status', 'Data telah dihapus');
    }

    public function postDeletebatch(){
        $request = Request::all();
        foreach ($request['data'] as $key => $value) {
            $user = User::findorfail($value);
            $user->detachAllRoles();
            if($user->foto){
                $disk = Storage::disk('public');
                $dir = Config::get('values.avatar_dir');
                $disk->delete($dir.'/'.$user->foto);
            }
            $user->delete();
        }
        return redirect('/admin/master-pengguna')->with('status', 'Data telah dihapus');
    }

    public function getResetpassword($id){
        if(Request::ajax()){  
            $user = User::findOrFail($id);
            $plain_password = Str::random(8);
            $crypted_password = bcrypt($plain_password);
            $user->password = $crypted_password;
            $user->save();
            return json_encode([
                'status' => 1,
                'msg' => 'Sukses',
                'user' => [
                    'user_id' => $id,
                    'password' => $plain_password
                ]
            ]);
        }else{
             return json_encode([
                'status'=>'0',
                'msg'=>'Gagal'
             ]);
        }
    }
}
