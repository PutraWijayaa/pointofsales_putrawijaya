<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use App\Models\StockHistory;
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
            'stock' => $request->stock,
            'is_active' => $request->is_active,
        ];

        if ($request->hasFile('product_photo')) {
            $photo = $request->file('product_photo')->store('product', 'public');
            $data['product_photo'] = $photo;
        }

        Products::create($data);

        Alert::success('Success Title', 'Success Message');
        return redirect()->to('product');
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_description' => $request->product_description,
            'stock' => $request->stock,
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
        Alert::success('Success Title', 'Success Message');


        return redirect()->to('product');
    }

    // public function destroy(string $id)
    // {
    //     // Products::where('id', $id)->delete();
    //     $product = Products::find($id);

    //     File::delete(public_path('storage/' . $product->product_photo));

    //     $product->delete();

    //     Alert::success('Success Title', 'Success Message');
    //     return redirect()->to('product');
    // }

    public function destroy(string $id)
    {
        $product = Products::findOrFail($id);

        // Hapus semua stock histories yang berhubungan dengan produk ini
        StockHistory::where('product_id', $product->id)->delete();

        // Hapus foto produk jika ada
        if ($product->product_photo && File::exists(public_path('storage/' . $product->product_photo))) {
            File::delete(public_path('storage/' . $product->product_photo));
        }

        // Hapus produk
        $product->delete();

        Alert::success('Berhasil', 'Produk berhasil dihapus.');
        return redirect()->to('product');
    }

    public function stockProducts()
    {
        $products = Products::with('category')->get();
        return view('stock.index', compact('products'));
    }

    public function addStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        //  data produk
        $product = Products::findOrFail($request->product_id);

        //  riwayat stok
        StockHistory::create([
            'product_id' => $product->id,
            'stock_change' => $request->quantity,
            'transaction_type' => 'stock_in',
        ]);

        // Tambah stok produk
        $product->stock += $request->quantity;
        $product->save();

        Alert::success('Success Title', 'Success Message');
        return redirect()->back();
    }


    public function outStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        //  data produk
        $product = Products::findOrFail($request->product_id);

        //  riwayat stok
        StockHistory::create([
            'product_id' => $product->id,
            'stock_change' => -$request->quantity,
            'transaction_type' => 'stock_out',
        ]);

        // Tambah stok produk
        $product->stock -= $request->quantity;
        $product->save();

        Alert::success('Success Title', 'Success Message');
        return redirect()->back();
    }
}
