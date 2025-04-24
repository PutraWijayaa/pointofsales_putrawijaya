<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $title = "Data users";
        $datas = User::get();

        $user = User::latest();

        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('users.index', compact('datas', 'user'));
    }

    public function create()
    {
        $Role = Role::all();
        return view('users.create', compact('Role'));
    }

    public function edit(string $id)
    {
        $edit = User::findOrFail($id); // jika tidak ditemukan, error 404
        $roles = Role::all();

        $userRole = UserRole::where('user_id', $id)->first(); // ambil role dari user
        $selectedRoleId = $userRole ? $userRole->role_id : null;
        // $password = Hash::check('password');
        // if ($this->hasher->needsRehash($hash)) {
        //     $this->rehashUserPassword($users, $plain);
        // }

        return view('users.edit', compact('edit', 'roles', 'selectedRoleId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'level_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->level_id,
        ]);

        alert()->success('Create Success', 'User created successfully')->toToast();
        return redirect()->route('users.index');
    }


    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'nullable|min:6',
        'level_id' => 'required|exists:roles,id',
    ]);

    $user = User::findOrFail($id);

    // Update user
    $user->name = $request->name;
    $user->email = $request->email;

    // Jika password diisi, baru update
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    // Update user role di tabel pivot user_roles
    UserRole::updateOrCreate(
        ['user_id' => $user->id],
        ['role_id' => $request->level_id]
    );

    return redirect()->route('users.index')->with('success', 'User updated successfully!');
}


    public function destroy($id)
{
    $user = User::findOrFail($id);

    // Hapus relasi user_role terlebih dahulu
    \App\Models\UserRole::where('user_id', $user->id)->delete();

    // Baru hapus user
    $user->delete();

    alert()->success('Success', 'User deleted successfully');
    return redirect()->route('users.index');
}

}
