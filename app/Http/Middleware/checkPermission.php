<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class checkPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$permission=null)
    {
        //lay ra cac role cua user
        $listRoleOfUSer = User::find(auth()->id())->roles()->select('roles.id')->pluck('id')->toArray();
        //dd($listRoleOfUSer);
        //lay ra tat ca cac permission cua role
        $listPermissionOfRole = DB::table('roles')
            ->join('role_permissions','roles.id','=','role_permissions.role_id')
            ->join('permissions','role_permissions.permission_id','=','permissions.id')
            ->whereIn('roles.id',$listRoleOfUSer)
            ->select('permissions.*')
            ->get()->pluck('id')->unique();

        //lay ra ma man hinh tuong ung de check quyen
        $checkPermisson = Permission::where('name',$permission)->value('id');

        //kiem tra xem co duoc truy cap vao route
        if($listPermissionOfRole->contains($checkPermisson)){
            return $next($request);

        }
        return abort(401);
    }
}
