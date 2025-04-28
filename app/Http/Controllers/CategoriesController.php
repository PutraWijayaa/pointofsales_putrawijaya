<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $title = "Data Categories";
        $datas = Categories::get();
        $cat = Categories::latest();

        // $users = User::latest()->paginate(10);

        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        // return view('users.index', compact('users'));

        return view('Categories.index', compact('datas', 'cat'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function edit(string $id)
    {
        $edit = Categories::find($id);

        return view('categories.edit', compact('edit'));
    }

    public function store(Request $request)
    {
        Categories::create([
            'category_name' => $request->category_name
        ]);

        Alert::success('Success Title', 'Success Message');
        return redirect()->to('categories');
    }

    public function update(Request $request, string $id)
    {
        Categories::where('id', $id)->update([
            'category_name' => $request->category_name
        ]);

        // opsi lain
        // $category = Categories::find($id);
        // $category->category_name = $request->category_name;
        // $category->save();

        Alert::success('Success Title', 'Success Message');
        return redirect()->to('categories');
    }

    public function destroy(string $id)
    {
        Categories::where('id', $id)->delete();

        // opsi lain
        // $category = Categories::find($id);
        // $category->delete();

        Alert::success('Success Title', 'Success Message');
        return redirect()->to('categories');
    }
}
