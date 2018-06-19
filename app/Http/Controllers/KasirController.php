<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\Customer;
use App\Store;
use App\Stock;
use App\Supplier;

class KasirController extends Controller
{
	public function index()
	{
		return view('kasir.index');
	}
    public function quick()
    {        
        session()->forget('cart');
    	$products = Product::all();
    	return view('kasir.quick',compact('products'));
    }

    public function tostore()
    {
        session()->forget('cart');
        $products = Product::all();
        $stores = Store::whereNotIn('id',[auth()->user()->store_id])->pluck('name','id')->prepend('Pilih Toko','')->toArray();        

        return view('kasir.tostore',compact('products','stores'));
    }

    public function tocustomer()
    {
        session()->forget('cart');
        $products = Product::all();
        return view('kasir.tocustomer',compact('products'));
    }

    public function finish()
    {        
        //dd(session('cart'));
        if(session()->has('cart') && !empty(session('cart')->items)){ 
            $order = new Order;
            $order->user_id = auth()->user()->id;
            $order->store_id = auth()->user()->store_id;            
            $order->payment_method = 'tunai';
            $order->status = 'lunas';
            $order->tgl_dibayar = \Carbon\Carbon::now();
            $order->cart_items = serialize(session('cart'));
            $order->total_qty = session('cart')->totalQty;
            $order->total_price = session('cart')->totalPrice;    
            $order->customer_id = 1;    
    		$order->save();

    		foreach(session('cart')->items as $key => $item){
    			\App\Item::create([
    					'order_id' => $order->id,
    					'product_id' => $key,
    					'qty' => $item['qty'],
    					'price' => $item['price']
    				]);
    		}

            \App\Pembayaran::create([
                    'order_id' => $order->id,
                    'nominal' => $order->total_price,
                ]);

            session()->forget('cart');

        } else {
            return redirect()->back()->with('error','Item barang harus diisi dulu');
        }        

    	return redirect()->route('penjualan.detail',$order);
    }

    public function save(Request $request)
    {
        if(!$request->has('order_id')){            
            if(session()->has('cart')){
                if(property_exists(session('cart'),'customer')){
                    return 'true';
                } 

                $order = new Order;
                $order->user_id = auth()->user()->id;
                $order->store_id = auth()->user()->store_id;
                $order->customer_id = 1;
                $order->payment_method = 'tunai';
                $order->status = 'draft';
                $order->tgl_dibayar = \Carbon\Carbon::now();
                $order->cart_items = serialize(session('cart'));
                $order->total_qty = session('cart')->totalQty;
                $order->total_price = session('cart')->totalPrice;
                $order->save();

                
                
                session()->forget('cart');
            }
        }else{
            $order = Order::find($request->order_id);
            $order->status = 'draft';
            $order->tgl_dibayar = \Carbon\Carbon::now();
            $order->cart_items = serialize(session('cart'));
            $order->total_qty = session('cart')->totalQty;
            $order->total_price = session('cart')->totalPrice;
            $order->save();
        }

        return redirect()->route('penjualan.hari.ini',['status' => 'draft']);
    }

    public function savetocustomer(Request $request)
    {
        //dd($request->all());
        if(!$request->has('order_id')){            
            if(session()->has('cart')){

                $customer = Customer::where('name','LIKE','%'.$request->customer.'%')->first();

                
                $order = new Order;
                $order->user_id = auth()->user()->id;
                $order->store_id = auth()->user()->store_id;

                //Cek apakah nama customer sudah ada di database
                if($customer){
                    $order->customer_id = $customer->id;
                }else{

                    //cek apakah nama customer yg diinput tidak kosong
                    if($request->customer == ''){
                        $order->customer_id = 1;                        
                    } else {

                        //JIka tidak kosong dan belum ada di database, Input customer baru
                        $new_customer = new Customer;
                        $new_customer->name = $request->customer;
                        $new_customer->save();
                        $order->customer_id = $new_customer->id;  
                    }
                }

                $order->payment_method = 'tunai';
                $order->status = 'draft';
                $order->tgl_dibayar = \Carbon\Carbon::now();
                $order->cart_items = serialize(session('cart'));
                $order->total_qty = session('cart')->totalQty;
                $order->total_price = session('cart')->totalPrice;
                $order->save();
                
                session()->forget('cart');
            }
        }else{
            $order = Order::find($request->order_id);
            $order->status = 'draft';
            $order->tgl_dibayar = \Carbon\Carbon::now();
            $order->cart_items = serialize(session('cart'));
            $order->total_qty = session('cart')->totalQty;
            $order->total_price = session('cart')->totalPrice;
            $order->save();
        }

        return redirect()->route('penjualan.hari.ini',['status' => 'draft']);
    }

    public function finishtocustomer(Request $request)
    {        
        if(session()->has('cart')){

            $customer = Customer::where('name','LIKE','%'.$request->customer_name.'%')->first();

            $order = new Order;
            $order->user_id = auth()->user()->id;
            $order->store_id = auth()->user()->store_id;            
            $order->payment_method = 'tunai';
            $order->status = 'pending';
            $order->tgl_dibayar = \Carbon\Carbon::now();
            $order->cart_items = serialize(session('cart'));
            $order->total_qty = session('cart')->totalQty;
            $order->total_price = session('cart')->totalPrice;  
            if($customer){
                    $order->customer_id = $customer->id;
                }else{

                    //cek apakah nama customer yg diinput tidak kosong
                    if($request->customer_name == ''){
                        $order->customer_id = 1;                        
                    } else {

                        //JIka tidak kosong dan belum ada di database, Input customer baru
                        $new_customer = new Customer;
                        $new_customer->name = $request->customer_name;
                        $new_customer->save();
                        $order->customer_id = $new_customer->id;  
                    }
                }  
            
            //$order->save();

            // foreach(session('cart')->items as $key => $item){
            //     \App\Item::create([
            //             'order_id' => $order->id,
            //             'product_id' => $key,
            //             'qty' => $item['qty'],
            //             'price' => $item['price']
            //         ]);
            // }

            //session()->forget('cart');
        } else {
            return redirect()->back()->with('error','Item barang harus diisi dulu');
        }

        return view('kasir.pembayarantocustomer',compact(['order']));
    }

    public function finishfinaltocustomer(Request $request)
    {
        //dd($request->all());
        $order = json_decode($request->order);
        //dd($order);
        $order_baru = new Order;
        $order_baru->user_id = auth()->user()->id;
        $order_baru->store_id = auth()->user()->store_id;            
        $order_baru->payment_method = 'tunai';
        $order_baru->tgl_dibayar = \Carbon\Carbon::now();
        $order_baru->cart_items = $order->cart_items;
        $order_baru->total_qty = $order->total_qty;
        $order_baru->total_price = $order->total_price;  
        $order_baru->customer_id = $order->customer_id;
        $order_baru->status = $request->pembayaran;                    
        $order_baru->save();

        foreach(unserialize($order->cart_items)->items as $key => $item){
            \App\Item::create([
                    'order_id' => $order_baru->id,
                    'product_id' => $key,
                    'qty' => $item['qty'],
                    'price' => $item['price']
                ]);
        }

        \App\Pembayaran::create([
                'order_id' => $order_baru->id,
                'nominal' => ($request->pembayaran == 'hutang') ? $request->nominal : $order_baru->total_price,
            ]);
        session()->forget('cart');
        return redirect()->route('penjualan.detail',$order_baru);
    }

    public function finishtostore(Request $request)
    {
        if(session()->has('cart')){
            //dd(session('cart')->items);

            $user = auth()->user();
            foreach(session('cart')->items as $id => $item){
                $stock_out = Stock::create([
                    'tanggal' => \Carbon\Carbon::now(),
                    'product_id' => $id,
                    'user_id' => $user->id,
                    'store_id' => $user->store_id,
                    'stock_from' => 'store',
                    'stock_from_id' => $request->store_id,
                    'stock_out' => $item["qty"]
                    ]);

                $stock_in = Stock::create([
                    'tanggal' => \Carbon\Carbon::now(),
                    'product_id' => $id,
                    'user_id' => $user->id,
                    'stock_in' => $item["qty"],
                    'store_id' => $request->store_id,
                    'stock_from' => 'store',
                    'stock_from_id' => $user->store_id,
                    ]);
            }
        }

        return redirect()->back()->with('success','Berhasil memindahkan stock antar Toko');
    }
    


    public function penjualanhariini(Request $request)
    {
        if(!$request->has('status')){
            $orders = Order::whereStoreId(auth()->user()->store->id)->whereStatus('lunas')->orWhere('status','=','hutang')->whereDate('created_at', \DB::raw('CURDATE()'))->orderBy('created_at','desc')->get();
        } else if($request->status == 'draft'){
            $orders = Order::whereStoreId(auth()->user()->store->id)->whereStatus('draft')->whereDate('created_at', \DB::raw('CURDATE()'))->orderBy('created_at','desc')->get();
        }        

        $totaluang = 0;
        foreach($orders as $order){
            //dd($order->pembayaran);
            foreach($order->pembayaran()->whereDate('created_at', \DB::raw('CURDATE()'))->get() as $pembayaran){
                $totaluang = $totaluang + $pembayaran->nominal;                
            }
        }


        return view('kasir.penjualanhariini',compact(['orders','totaluang']));
    }

    public function penjualansemua()
    {
        $orders = Order::whereStoreId(auth()->user()->store->id)->paginate(30);
        return view('kasir.penjualansemua',compact(['orders']));
    }

    public function editpenjualan(Order $order)
    {
        if($order->status == 'lunas'){
            return redirect()->back()->with('error','Penjualan yang sudah selesai tidak bisa di edit lagi');
        }
        session(['cart' => unserialize($order->cart_items)]);        
        $products = Product::all();
        return view('kasir.editpenjualan',compact(['order','products']));
    }

    public function updatepenjualan(Request $request)
    {
        $order = Order::find($request->id);
        $order->status = 'lunas';
        $order->tgl_dibayar = \Carbon\Carbon::now();
        $order->cart_items = serialize(session('cart'));
        $order->total_qty = session('cart')->totalQty;
        $order->total_price = session('cart')->totalPrice;
        $order->save();

        return redirect()->route('penjualan.detail',$order);
        
    }

    public function penjualandetail(Order $order)
    {
        return view('kasir.penjualandetail',compact(['order']));
    }

    public function getCustomerNameAutocomplete(Request $request)
    {
        $term = $request->term;
    
        $results = array();
        
        $queries = \DB::table('customers')
            ->where('name', 'LIKE', '%'.$term.'%')            
            ->get();
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->name];
        }
    return response()->json($results);
    }

    public function deleteorder(Order $order)
    {
        $order->items()->delete();
        $order->delete();
        return redirect()->back()->with('success','Data Penjualan berhasil dihapus.');
    }

    public function stocks()
    {
        $products = Product::paginate(30);
        return view('kasir.products',compact(['products']));
    }

    public function stockproductview(Product $product)
    {
        //$stocks = $product->stocks()->whereStockFrom('supplier')->orderBy('tanggal','desc')->orderBy('created_at','desc')->paginate(20);        
        $stocks = $product->stocks()->whereStoreId(auth()->user()->store_id)->where('stock_in','!=',0)->orderBy('tanggal','desc')->orderBy('created_at','desc')->paginate(20);        
        return view('kasir.productview',compact('product','stocks'));
    }

    public function addproductstock(Product $product)
    {
        $suppliers = Supplier::pluck('name','id')->prepend('Pilih Supplier','')->toArray();
        return view('kasir.productaddstock',compact('product','suppliers'));
    }
}
