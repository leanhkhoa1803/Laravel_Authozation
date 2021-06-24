<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct(User $user,Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index(){
        $listUser = $this->user->all();

        return view('user.index',compact('listUser'));
    }

    public function create(){
        $listRole = $this->role->all();
        return view('user.add',compact('listRole'));
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $user = $this->user->create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
            ]);

            $roles = $request->roles;
            $user->roles()->attach($roles);
            DB::commit();
            return redirect()->route('user.index');
        }catch (\Exception $exception){
            DB::rollBack();
        }
    }

    public function edit($id){
        $listRole = $this->role->all();
        $user= $this->user->findOrfail($id);
        $listRoleOfUser = DB::table('roles_user')->where('user_id',$id)->pluck('role_id');
        return view('user.edit',compact('listRole','user','listRoleOfUser'));
    }

    public function update(Request $request,$id){
        //update table user
        try {
            DB::beginTransaction();
            $this->user->where('id',$id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
            ]);

            //update table roles_user
            //B1:xoa tat ca cac role cua user do
            DB::table('roles_user')->where('user_id',$id)->delete();
            //B2:insert role moi
            $userCreate = $this->user->find($id);
            $userCreate->roles()->attach($request->roles);
            DB::commit();
            return redirect()->route('user.index');
        }catch (\Exception $exception){
            DB::rollBack();
        }
    }

    public function delete(Request $request,$id){
        try {
            DB::beginTransaction();
            //delete user
            $user=$this->user->find($id);
            $user->delete();

            //delete role of user
            $user->roles()->detach();
            DB::commit();
            return redirect()->route('user.index');
        }catch (\Exception $exception){
            DB::rollBack();
        }

    }
}
