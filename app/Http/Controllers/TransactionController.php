<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Categories;
use App\Models\Products;
use App\Models\Orders;
use App\Models\StockHistory;
use App\Models\orderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;


class TransactionController extends Controller
{
    public function index()
    {
        $title = "Orders";
        // ORM Object Relation Mapp
        $datas = Orders::orderBy('id', 'desc')->get();

        // return $datas;
        return view('pos.index', compact('datas'));
    }
    public function create()
    {
        $Products = Products::where('is_active', 1)->orderBy('id', 'desc')->get()->map(function ($res) {
            return [
                "id" => $res->id,
                "name" => $res->product_name,
                "price" => (int)$res->product_price,
                "image" => asset('storage/' . $res->product_photo),
                "option" => null,
            ];
        });

        $title = "Create Order";

        // Alert::success('Success Title', 'Success Message');
        return view('pos.create', compact('Products', 'title'));
    }

    public function edit(string $id)
    {
        $edit = Orders::find($id);
        $categories  = Orders::Categories('id', 'desc')->get();

        return view('pos.edit', compact('edit', 'categories'));
    }

    // public function store(Request $request)
    // {

    //     $qOrderCode = Orders::max('id');
    //     $qOrderCode++;
    //     $orderCode = "ORD" . date("dmY") . sprintf("%03d", $qOrderCode);

    //     $data = [
    //         'order_code' => $orderCode,
    //         'order_date' => date("Y-m-d"),
    //         'order_amount' => $request->grandtotal,
    //         'order_change' => 1,
    //         'order_status' => 1,
    //     ];

    //     $order = Orders::create($data);

    //     $qty = $request->qty;

    //     foreach ($qty as $key => $data) {
    //         orderDetails::create([
    //             'order_id' => $order->id,
    //             'product_id' => $request->product_id[$key],
    //             'qty' => $request->qty[$key],
    //             'order_price' => $request->order_price[$key],
    //             'order_subtotal' => $request->order_subtotal[$key],
    //         ]);
    //     }

    //     alert()->success('Create Success', 'Successfully')->toToast();
    //     return redirect()->to('pos');
    // }


    // anak anak
    // public function store(Request $request)
    // {

    //     $request->validate([
    //         'cart' => 'required',
    //         'cash' => 'required|numeric|min:0',
    //         'total' => 'required|numeric|min:0',
    //         'change' => 'required|numeric|min:0',
    //     ]);

    //     $data = json_decode($request->cart, true);


    //     $latestIdOrder = Order::max('id') + 1;
    //     $order = Order::create([
    //         'order_code' => $this->generateOrderCode($latestIdOrder),
    //         'order_date' => now(),
    //         'order_amount' => $request->total,
    //         'order_change' =>  $request->change,
    //         'order_status' =>  1,
    //         'customer_name' => "John Doe",
    //     ]);

    //     foreach ($data as $item) {
    //         OrderDetail::create([
    //             'order_id' => $order->id,
    //             'product_id' => $item['productId'],
    //             'qty' => $item['qty'],
    //             'order_price' => $item['price'],
    //             'order_subtotal' => $item['qty'] * $item['price'],
    //         ]);
    //     }
    //     // return $request;

    //     return redirect('pos')->with('success', 'Order created successfully');

    // }

    // public function store(Request $request)
    // {
    //     // return $request;
    //     // Begin transaction to ensure data integrity
    //     DB::beginTransaction();

    //     try {
    //         // Decode cart JSON data
    //         $cartItems = json_decode($request->cart, true);
    //         $cash = $request->cash;
    //         $total = $request->total;
    //         $change = $request->change;

    //         // Create order record
    //         $order = new Orders();
    //         $order->order_code = 'TWPOS-KS-' . time(); // Same format as in the JS
    //         $order->order_date = now();
    //         $order->order_amount = $total;
    //         $order->order_change = $change;
    //         $order->order_status = 1; // Completed
    //         $order->save();

    //         // Process each item in the cart
    //         foreach ($cartItems as $item) {
    //             $orderDetail = new OrderDetails();
    //             $orderDetail->order_id = $order->id;
    //             $orderDetail->product_id = $item['productId'];
    //             $orderDetail->qty = $item['qty'];
    //             $orderDetail->order_price = $item['price'];
    //             $orderDetail->order_subtotal = $item['price'] * $item['qty'];
    //             $orderDetail->save();
    //         }

    //         DB::commit();

    //         // return response()->json([
    //         //     'status' => 'success',
    //         //     'message' => 'Order processed successfully',
    //         //     'order_id' => $order->id
    //         // ]);
    //         return redirect()->to('pos');
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Failed to process order: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'cart' => 'required|json',
    //         'cash' => 'required|numeric|min:0',
    //         'total' => 'required|numeric|min:0',
    //         'change' => 'required|numeric|min:0',
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         $cartItems = json_decode($request->cart, true);
    //         $cash = $request->cash;
    //         $total = $request->total;
    //         $change = $request->change;

    //         // Create order
    //         $order = new Orders();
    //         $order->order_code = 'TWPOS-KS-' . time();
    //         $order->order_date = now();
    //         $order->order_amount = $total;
    //         $order->order_change = $change;
    //         $order->order_status = 1;
    //         $order->save();

    //         // Process each item
    //         foreach ($cartItems as $item) {
    //             $orderDetail = new OrderDetails();
    //             $orderDetail->order_id = $order->id;
    //             $orderDetail->product_id = $item['productId'];
    //             $orderDetail->qty = $item['qty'];
    //             $orderDetail->order_price = $item['price'];
    //             $orderDetail->order_subtotal = $item['price'] * $item['qty'];
    //             $orderDetail->save();

    //             // Update product stock
    //             $product = Products::find($item['productId']);

    //             if ($product) {
    //                 if ($product->stock >= $item['qty']) {
    //                     $product->stock -= $item['qty'];
    //                     $product->save();
    //                 } else {
    //                     // Gagal jika stok kurang dari qty yang diminta
    //                     throw new \Exception("Stok produk '{$product->product_name}' tidak mencukupi.");
    //                 }
    //             } else {
    //                 throw new \Exception("Produk dengan ID {$item['productId']} tidak ditemukan.");
    //             }
    //         }

    //         DB::commit();
    //         Alert::success('Success', 'Transaction has been successfully processed.');
    //         return redirect()->with('success', 'Order created successfully');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Failed to process order: ' . $e->getMessage());
    //     }
    // }



    public function store(Request $request)
{
    // Validasi dan ambil data dari request
    $cartItems = json_decode($request->cart, true);
    $cash = $request->cash;
    $total = $request->total;
    $change = $request->change;

    DB::beginTransaction();

    try {
        // Simpan data order
        $order = new Orders();
        $order->order_code = 'TWPOS-KS-' . time();
        $order->order_date = now();
        $order->order_amount = $total;
        $order->order_change = $change;
        $order->order_status = 1; // Completed
        $order->save();

        // Proses setiap item dalam cart
        foreach ($cartItems as $item) {
            $product = Products::findOrFail($item['productId']);

            // Cek apakah stok cukup
            if ($product->stock < $item['qty']) {
                return back()->with('error', 'Stok produk ' . $product->product_name . ' tidak cukup.');
            }

            // Update stok produk
            $product->stock -= $item['qty'];
            $product->save();

            // Simpan riwayat stok
            StockHistory::create([
                'product_id' => $product->id,
                'stock_change' => -$item['qty'], // Mengurangi stok
                'transaction_type' => 'sale', // Tipe transaksi: penjualan
            ]);

            // Simpan detail order
            $orderDetail = new OrderDetails();
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $item['productId'];
            $orderDetail->qty = $item['qty'];
            $orderDetail->order_price = $item['price'];
            $orderDetail->order_subtotal = $item['price'] * $item['qty'];
            $orderDetail->save();
        }

        DB::commit();

        Alert::success('Success Title', 'Success Message');
        return redirect()->with('success', 'Order berhasil diproses');
    } catch (\Exception $e) {
        DB::rollBack();

        Alert::error('Error Title', 'Error Message');
        return back()->with('error', 'Gagal memproses order: ' . $e->getMessage());
    }
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
            // jika gambar sudah ada dan mau diubah maka gambar lama kita hapus di ganti oleh gambar baru
            if ($product->product_photo) {
                File::delete(public_path('storage/' . $product->photo));
            }

            $photo = $request->file('product_photo')->store('product', 'public');
            $data['product_photo'] = $photo;
        }

        $product->update($data);

        Alert::success('Success Title', 'Success Message');
        return redirect()->to('product');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::find($id);
        File::delete(public_path('storage/' . $product->product_photo));
        $product->delete();
        Alert::success('Success Title', 'Success Message');

        return redirect()->to('product');
    }

    public function getProduct($category_id)
    {
        $products = Products::where('category_id', $category_id)->get();
        $response = ['status' => 'success', 'Message' => 'Fetch product success', 'data' => $products];
        return response()->json($response, 200);
    }

    public function print($id)
    {
        $order = Orders::findOrFail($id);
        $orderDetails = OrderDetails::with('product')->where('order_id', $id)->get();
        return view('pos.print-struk', compact('order', 'orderDetails'));
    }

    public function show($id)
    {
        //order
        $order = Orders::findOrFail($id);
        $orderDetails = orderDetails::with('product')->where('order_id', $id)->get();
        $title = "Order Details Of " . $order->order_code;
        return view('pos.show', compact('order', 'orderDetails', 'title'));
    }
}
