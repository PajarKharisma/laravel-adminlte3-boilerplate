<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use Request;
use Response;
use Validator;
use DB;

use App\Models\Role;

class MasterRoleController extends Controller {
    
    public function __construct() {
        $this->middleware('auth', ['except' => 'login']);
        $this->middleware('role:admin', ['except' => ['show']]);
    }

    public function getIndex(){
        $data['breadcrumbs'] = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "javascript:void(0)", 'name' => "Kelola Hak Akses"],
        ];
        $data['m_admin_master_roles'] = 'active';
        $data['m_admin_kelola_pengguna'] = 'menu-open';

        $data['m_roles'] = 'active';
        $request = Request::all();
        
        $data['searchtext'] = isset($request['searchtext']) ? $request['searchtext'] : null;
        if($data['searchtext'] != null){
            $list = Role::where('name', 'LIKE', '%'.$data['searchtext'].'%')
                ->orWhere('display_name', 'LIKE', '%'.$data['searchtext'].'%')
                ->orderBy('name')
                ->paginate(20)
                ->appends(request()
                ->query());
        } else {
            $list = Role::orderBy('name')->paginate(20)->appends(request()->query());
        }
        $data['list'] = $list;

        // dd($data);
        return view('admin.master.roles.index')->with($data);
    }

    public function getCreate(){
        $data['breadcrumbs'] = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/admin/master-roles", 'name' => "Kelola Hak Akses"],
            ['link' => "javascript:void(0)", 'name' => "Buat Baru"],
        ];
        $data['m_admin_master_roles'] = 'active';
        $data['m_admin_kelola_pengguna'] = 'menu-open';

        return view('admin.master.roles.create')->with($data);
    }

    public function postSave(){
        $request = Request::all();
        $request['id'] = (string) Str::uuid();
        $validator = Validator::make($request, Role::rules());
        if($validator->passes()){
            Role::create($request);
            return redirect('/admin/master-roles')->with('status', 'Data telah disimpan');
        }else{
            return redirect('/admin/master-roles/create')->withInput()->withErrors($validator);
        }
    }

    public function getEdit($id){
        $data['breadcrumbs'] = [
            ['link' => "/", 'name' => "Home"],
            ['link' => "/admin/master-roles", 'name' => "Kelola Hak Akses"],
            ['link' => "javascript:void(0)", 'name' => "Edit Data"],
        ];
        $data['m_admin_master_roles'] = 'active';
        $data['m_admin_kelola_pengguna'] = 'menu-open';

        $data['item'] = Role::findorfail($id);
        return view('admin.master.roles.edit')->with($data);
    }

    public function postUpdate($id){
        $request = Request::all();

        $validator = Validator::make($request, Role::rules($id));
        if($validator->passes()){
            Role::findorfail($id)->update($request);
            return redirect('/admin/master-roles')->with('status', 'Data telah disimpan');
        }else{
            return redirect('/admin/master-roles/edit/'.$id)->withInput()->withErrors($validator);
        }
    }

    public function getDelete($id){
        Role::findorfail($id)->delete();
        return redirect('/admin/master-roles')->with('status', 'Data telah dihapus');
    }

    public function postDeletebatch(){
        $request = Request::all();
        foreach ($request['data'] as $key => $value) {
            Role::findorfail($value)->delete();
        }
        return redirect('/admin/master-roles')->with('status', 'Data telah dihapus');
    }
}
