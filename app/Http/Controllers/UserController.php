<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function index($search) {
        // return response()->json(str_replace('-', '_', $search), 200);
        $filterSearch = str_replace('-', '_', $search);
        $roles = Role::where('role', $filterSearch)->first();
        $users = User::where('roles', $roles->id)->get();
        foreach ($users as $key => $value) {
            $value->role_name = $roles->role;
        }
        return response()->json($users, 200);
    }

    public function store(Request $request) {
        $this->validate($request,[
            'name' => 'required|max:255',
            'email' => 'required|email',
            'roles' => 'required',
            'password' => 'required',
        ]);

        try {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);

            $role = Role::find($user->roles);
            $user->role_name = $role->role;

            $msg = [
                'status' => true,
                'type' => 'success',
                'data' => $user
            ];

            return response()->json($msg, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
    }

    public function update(Request $request, $id) {
        // $this->validate($request,[
        //     'name' => 'required|max:255',
        //     'email' => 'required|email',
        //     'roles' => 'required',
        // ]);

        try {
            $data = $request->all();
            // $data['password'] = bcrypt($data['password']);

            $user = User::find($id);
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->roles = $data['roles'];
            if($data['password'] != null) {
                $data['password'] = bcrypt($data['password']);
                $user->password = $data['password'];
            }
            $user->update();

            $role = Role::find($user->roles);
            $user->role_name = $role->role;

            return response()->json($user, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findorFail($id);
            $user->delete();

            return response()->json($id, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
    }
}
