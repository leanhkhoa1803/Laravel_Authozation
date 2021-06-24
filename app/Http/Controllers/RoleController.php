<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct(Role $role,Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listRole = $this->role->all();
        return view('role.index',compact('listRole'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permission->all();
        return view('role.add',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            //Insert table role
            $roleCreate = $this->role->create([
                'name'=>$request->name,
                'display_name'=>$request->display_name,
            ]);

            //Insert table role_permissions
            $roleCreate->permission()->attach($request->permissions);
            DB::commit();
            return redirect()->route('role.index');
        }catch (\Exception $exception){
            DB::rollBack();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permissions = $this->permission->all();
        $roles = $this->role->findOrFail($id);
        $permissionOfRole = DB::table('role_permissions')
            ->where('role_id',$id)->pluck('permission_id');
        return view('role.edit',compact('permissions','roles','permissionOfRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            //update table role
            $roleUpdate = $this->role->where('id',$id)->update([
                'name'=>$request->name,
                'display_name'=>$request->display_name,
            ]);

            //update table roles_permission
            DB::table('role_permissions')->where('role_id',$id)->delete();
            $roleUpdate = $this->role->find($id);
            $roleUpdate->permission()->attach($request->permissions);

            DB::commit();
            return redirect()->route('role.index');
        }catch (\Exception $exception){
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            //delete role
            $role=$this->role->find($id);
            $role->delete();

            //delete permission of role
            $role->permission()->detach();

            DB::commit();
            return redirect()->route('role.index');
        }catch (\Exception $exception){
            DB::rollBack();
        }
    }
}
