<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;


class RolesController extends Controller
{
    public function index()
    {
        $title = "Data Role";
        $datas = Role::get();
        $Role = Role::latest();

        $title = 'Delete Role!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('roles.index', compact('datas', 'Role'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function edit(string $id)
    {
        $edit = Role::find($id);
        return view('roles.edit', compact('edit'));
    }

    public function store(Request $request)
    {
        Role::create([
            'name' => $request->name,
            'is_active' => $request->is_active ?? 1, // Default aktif jika tidak diisi
        ]);

        Alert::success('Success Title', 'Success Message');
        return redirect()->to('roles');
    }

    public function update(Request $request, string $id)
    {
        Role::where('id', $id)->update([
            'name' => $request->name,
            'is_active' => $request->is_active ?? 1,
        ]);

        Alert::success('Success Title', 'Success Message');
        return redirect()->to('roles');
    }

    public function destroy(string $id)
    {
        Role::where('id', $id)->delete();
        Alert::success('Success Title', 'Success Message');
        return redirect()->to('roles');
    }
}
