<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    //get list of all users
    public function getUsers()
    {
        $users = User::where('user_role_id', 3)->get();
        $number = count($users);
        return response()->json([
            'message' => 'success',
            'number' => $number,
            'data' => $users
        ], 200);
    }


    //get list of admins and staff with their roles
    public function getAdmins()
    {
        $staffs = User::where('user_role_id', '!=', 3)->get();
        $number = count($staffs);
        $roleName = '';

        foreach ($staffs as $staff) {
            if ($staff->user_role_id === 1) {
                $roleName = 'super admin';
            } elseif ($staff->user_role_id === 2) {
                $roleName = 'staff';
            }

            if ($staff->is_suspended === 1) {
                $status = 'suspend';
            } elseif ($staff->is_suspended === 0) {
                $status = 'active';
            }

            // Add a new property 'role' to each staff object
            $staff->role = $roleName;
            $staff->status = $status;
        }

        return response()->json([
            'message' => 'success',
            'number' => $number,
            'data' => $staffs
            ], 200);
    }


    //suspend admin
    public function suspendAdmin(Request $request)
    {
        $user = User::find($request->user_id);
        if($user->is_suspended == true){
            $user->is_suspended = false;
        }else{
            $user->is_suspended = true;
        }
        $user->save();

        return response()->json([
            'message' => 'success',
            'data' => $user
        ], 200);
    }


    //delete suspended admin
    public function deleteAdmin(Request $request)
    {
        $user = User::find($request->id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        if ($user->is_suspended == true) {
            return response()->json([
                'message' => 'Cannot delete an active admin.',
            ], 400);
        }

        $user->delete();

        return response()->json([
            'message' => 'Admin deleted successfully.',
            'data' => $user
        ], 200);
    }

}
