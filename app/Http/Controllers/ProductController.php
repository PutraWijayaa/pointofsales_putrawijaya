<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facedes\File;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Resource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Finder;

use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public function index()
    {
        $title = "Data Products";
        // ORM Object Relation Mapp
        $datas = Products::with('category')->get();

        $prod = Products::latest();

        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        // return $datas;
        return view('product.index', compact('datas', 'prod'));
    }

    public function create()
    {
        $categories = Categories::orderBy('id', 'desc')->get();
        return view('product.create', compact('categories'));
    }

    public function edit(string $id)
    {
        $edit = Products::find($id);
        $categories = Categories::orderBy('id', 'desc')->get();


        return view('product.edit', compact('edit', 'categories'));
    }

    public function store(Request $request)
    {
        $data = [
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_description' => $request->product_description,
            'is_active' => $request->is_active,
        ];

        if ($request->hasFile('product_photo')) {
            $photo = $request->file('product_photo')->store('product', 'public');
            $data['product_photo'] = $photo;
        }

        Products::create($data);

        alert()->success('Create Success', 'Successfully')->toToast();
        return redirect()->to('product');
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_description' => $request->product_description,
            'is_active' => $request->is_active,
        ];


        $product = Products::find($id);
        if ($request->hasFile('product_photo')) {
            // jika gambar sudah ada dan mau diubah maka gambar lama kita hapus di ganti dengan gambar yang baru
            if ($request->hasFile('product_photo')) {
                File::delete(public_path('storage/' . $product->photo));
            }
            $photo = $request->file('product_photo')->store('product', 'public');
            $data['product_photo'] = $photo;
        }

        // Categories::where('id', $id)->update([
        //     'category_name' => $request->category_name
        // ]);


        $product->update($data);
        // Alert::alert('Success', 'Success', 'Type');
        // toast('Your Post as been submited!', 'success');
        // toast('Post Updated', 'success', 'top-right')->hideCloseButton();
        alert()->success('Update Success', 'Successfully')->toToast();

        return redirect()->to('product');
    }

    public function destroy(string $id)
    {
        // Products::where('id', $id)->delete();
        $product = Products::find($id);

        File::delete(public_path('storage/' . $product->product_photo));

        $product->delete();

        // alert()->success('Delete Success', 'Successfully')->toToast();
        return redirect()->to('product');
    }
}
