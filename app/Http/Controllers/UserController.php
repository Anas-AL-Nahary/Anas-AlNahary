<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(25);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view("users.create", compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'roles' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' .$request->id],
            "image" => [$request->id > 0 ? "nullable" : "required", "image", "max:51120"]
        ]);



        if($request->id>0)
            $user = User::findOrFail($request->id);
        $bath = "";
        if($request->id>0)
        {
            $bath= $user->image;
        }
        if ($request->hasFile('image'))
            $bath = $request->file('image')->store('users');

        $user = User::updateOrCreate(
            [
                'id' => $request->id,
            ]
            , [
            'name' => $request->name,
            'email' => $request->email,
            'image' => $bath,
            'password' => Hash::make($request->password),
            "status" => isset($request->status)
        ]);

        $user->assignRole($request->roles);

        if ($request->id > 0)
            toastr()->success('تم الأضافة بنجاح');
        else
            toastr()->success('تم التعديل بنجاح');
        return redirect(route('users.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $users = User::all();
        $roles = Role::all();
        return view('users.create')->with('roles', $roles);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        toastr()->success('تم الحذف بنجاح');
        return redirect(route('users.index'));
    }
}
