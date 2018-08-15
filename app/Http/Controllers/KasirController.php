<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\Customer;
use App\Store;
use App\Stock;
use App\Supplier;
use App\Chart;
use App\Pembayaran;
use Carbon\Carbon;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class KasirController extends Controller
{
	public function index()
	{
		return view('kasir.index');
	}
    public function quick()
    {        
        session()->forget('cart');
        $availableProducts = \App\Product::where('available_stocks','>',0)->pluck('name','id')->prepend('Pilih Barang','')->toArray();
        return view('kasir.quick_new',compact('availableProducts'));
    }

    public function tostore()
    {
        session()->forget('cart');
        $availableProducts = \App\Product::where('available_stocks','>',0)->pluck('name','id')->prepend('Pilih Barang','')->toArray();
        $stores = Store::whereNotIn('id',[auth()->user()->store_id])->pluck('name','id')->prepend('Pilih Toko','')->toArray();        

        return view('kasir.tostore',compact('availableProducts','stores'));
    }

    public function tocustomer()
    {
        session()->forget('cart');
         $availableProducts = \App\Product::where('available_stocks','>',0)->pluck('name','id')->prepend('Pilih Barang','')->toArray();
        return view('kasir.tocustomer',compact('products','availableProducts'));
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

            updateProductsAvailableStocks($order->products());
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
                $order->total_qty = session('cart')->totalQty;
                $order->total_price = session('cart')->totalPrice;
                $order->save();

                foreach(session('cart')->items as $key => $item){
                \App\Item::create([
                        'order_id' => $order->id,
                        'product_id' => $key,
                        'qty' => $item['qty'],
                        'price' => $item['price']
                    ]);
                }
                
                
                session()->forget('cart');
            } else{
                return redirect()->back()->with('error','Item barang harus diisi dulu');
            }
        }else{
            $order = Order::find($request->order_id);
            $order->status = 'draft';
            $order->tgl_dibayar = \Carbon\Carbon::now();
            $order->total_qty = session('cart')->totalQty;
            $order->total_price = session('cart')->totalPrice;
            $order->save();

            $order->items()->delete();
            foreach(session('cart')->items as $key => $item){
                \App\Item::create([
                        'order_id' => $order->id,
                        'product_id' => $key,
                        'qty' => $item['qty'],
                        'price' => $item['price']
                    ]);
                }
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
                $order->total_qty = session('cart')->totalQty;
                $order->total_price = session('cart')->totalPrice;
                $order->save();

                foreach(session('cart')->items as $key => $item){
                \App\Item::create([
                        'order_id' => $order->id,
                        'product_id' => $key,
                        'qty' => $item['qty'],
                        'price' => $item['price']
                    ]);
                }
                
                session()->forget('cart');
            }
        }else{
            $order = Order::find($request->order_id);
            $order->status = 'draft';
            $order->tgl_dibayar = \Carbon\Carbon::now();
            $order->total_qty = session('cart')->totalQty;
            $order->total_price = session('cart')->totalPrice;
            $order->save();

            $order->items()->delete();
            foreach(session('cart')->items as $key => $item){
                \App\Item::create([
                        'order_id' => $order->id,
                        'product_id' => $key,
                        'qty' => $item['qty'],
                        'price' => $item['price']
                    ]);
                }
        }

        return redirect()->route('penjualan.hari.ini',['status' => 'draft']);
    }

    public function finishtocustomer(Request $request)
    {        
        //dd(session('cart')->orderId);
        if(session()->has('cart')){
 
            if(!session('cart')->orderId){
                $customer = Customer::where('name','LIKE','%'.$request->customer_name.'%')->first();
                $order = new Order;
                $order->user_id = auth()->user()->id;
                $order->store_id = auth()->user()->store_id;            
                $order->payment_method = 'tunai';
                $order->status = 'pending';
                $order->tgl_dibayar = \Carbon\Carbon::now();           
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
                //dd($order->customer);

            } else {
                $order = Order::find(session('cart')->orderId);
            }
            
        } else {
            return redirect()->back()->with('error','Item barang harus diisi dulu');
        }

        return view('kasir.pembayarantocustomer',compact(['order']));
    }

    public function finishfinaltocustomer(Request $request)
    {
        // Jika input nominal tidak diisi
        if($request->nominal == ""){
            $nominal = 0;
        } else {
            $nominal = $request->nominal;
        }
        //dd($nominal);
        if($request->has('order')){
            $order = json_decode($request->order);
            //dd(session('cart'));
            $order_baru = new Order;
            $order_baru->user_id = auth()->user()->id;
            $order_baru->store_id = auth()->user()->store_id;            
            $order_baru->payment_method = 'tunai';
            $order_baru->tgl_dibayar = \Carbon\Carbon::now();
            $order_baru->total_qty = $order->total_qty;
            $order_baru->total_price = $order->total_price;  
            $order_baru->customer_id = $order->customer_id;
            $order_baru->status = $request->pembayaran;                    
            $order_baru->save();

            foreach(session('cart')->items as $key => $item){
                \App\Item::create([
                        'order_id' => $order_baru->id,
                        'product_id' => $key,
                        'qty' => $item['qty'],
                        'price' => $item['price']
                    ]);
            }

            \App\Pembayaran::create([
                    'order_id' => $order_baru->id,
                    'nominal' => ($request->pembayaran == 'hutang') ? $nominal : $order_baru->total_price,
                ]);
            session()->forget('cart');
            updateProductsAvailableStocks($order_baru->products());
            return redirect()->route('penjualan.detail',$order_baru);
            
        } elseif($request->has('order_id')) {
            $order = Order::find($request->order_id);
            $order->payment_method = 'tunai';
            $order->status = $request->pembayaran;
            $order->save();

            $order->items()->delete();
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
                    'nominal' => ($request->pembayaran == 'hutang') ? $nominal : $order->total_price,
                ]);      
            updateProductsAvailableStocks($order->products());
           
        return redirect()->route('penjualan.detail',$order);
        }
        
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
        updateProductsAvailableStocks();

        return redirect()->back()->with('success','Berhasil memindahkan stock antar Toko');
    }
    


    public function penjualanhariini(Request $request)
    {
        if(!$request->has('status')){
            $orders = Order::whereStoreId(auth()->user()->store->id)->whereIn('status',['lunas','hutang'])->whereDate('created_at','=', \Carbon\Carbon::today())->orderBy('created_at','desc')->get();
        } else if($request->status == 'draft'){
            $orders = Order::whereStoreId(auth()->user()->store->id)->whereStatus('draft')->whereDate('created_at', \Carbon\Carbon::today())->orderBy('created_at','desc')->get();
        }

        $products = Product::all();
        $columnPenjualanProductSeries = [];
        $productSold = [];
        $productCategories = [\Carbon\Carbon::today()->format('d M Y')];
        foreach($products as $product){
            if($product->ordersItem()->whereDate('created_at','=',\Carbon\Carbon::today())->sum('qty') > 0){             
                $productSold[] = $product;   
                $columnPenjualanProductSeries[] = [
                    'name' => $product->name,
                    'data' => [intval($product->ordersItem()->whereDate('created_at','=',\Carbon\Carbon::today())->sum('qty'))]
                ];                          
            }
        }  

        //dd(\Carbon\Carbon::today()); 

        $columnPenjualanProduct = new Chart('column');
        $columnPenjualanProduct->title('Penjualan berdasarkan barang hari ini')
                                ->xAxis('',$productCategories)
                                ->plotOptions([
                                    'enabled' =>  true,
                                    'borderRadius'=> 2,
                                    'y'=> -10,
                                    'shape' => 'callout'])
                                ->series($columnPenjualanProductSeries);


        //dd($orders);
        $totaluang = 0;
        foreach($orders as $order){
            //dd($order->pembayaran);
            foreach($order->pembayaran()->whereDate('created_at', \DB::raw('CURDATE()'))->get() as $pembayaran){
                $totaluang = $totaluang + $pembayaran->nominal;                
            }
        }


        return view('kasir.penjualanhariini',compact(['orders','totaluang','columnPenjualanProduct','productSold']));
    }

    public function penjualanharitertentu(Request $request)
    {
        if(!$request->has('tanggal')){
            return view('kasir.penjualanharitertentu');
        }



        $orders = Order::whereStoreId(auth()->user()->store->id)->whereIn('status',['lunas','hutang'])->whereDate('created_at','=', \Carbon\Carbon::parse($request->tanggal))->orderBy('created_at','desc')->get();

        $products = Product::all();
        $columnPenjualanProductSeries = [];
        $productSold = [];
        $productStockIn= [];
        $productCategories = [\Carbon\Carbon::parse($request->tanggal)->format('d M Y')];
        foreach($products as $product){
            $productHasStockInToday = $product->stocks()->whereDate('created_at','=',\Carbon\Carbon::parse($request->tanggal))->where('stock_from','=','supplier')->sum('stock_in');
            if($productHasStockInToday > 0) {
                $productStockIn[] = ['product' => $product,'stock_in' => $productHasStockInToday];
            }

            if($product->ordersItem()->whereDate('created_at','=',\Carbon\Carbon::parse($request->tanggal))->sum('qty') > 0){   
                $productSold[] = $product;              
                $columnPenjualanProductSeries[] = [
                    'name' => $product->name,
                    'data' => [intval($product->ordersItem()->whereDate('created_at','=',\Carbon\Carbon::parse($request->tanggal))->sum('qty'))]
                ];                          
            }
        }  

        //dd($productStockIn); 

        $columnPenjualanProduct = new Chart('column');
        $columnPenjualanProduct->title('Penjualan berdasarkan barang '.\Carbon\Carbon::parse(\Request::input('tanggal'))->format('d M Y'))
                                ->xAxis('',$productCategories)
                                ->plotOptions([
                                    'enabled' =>  true,
                                    'borderRadius'=> 2,
                                    'y'=> -10,
                                    'shape' => 'callout',
                                    ])
                                ->series($columnPenjualanProductSeries);


        //dd($orders);
        $totaluang = 0;
        foreach($orders as $order){
            //dd($order->pembayaran);
            foreach($order->pembayaran()->whereDate('created_at', \Carbon\Carbon::parse($request->tanggal))->get() as $pembayaran){
                $totaluang = $totaluang + $pembayaran->nominal;                
            }
        }

        if($request->has('print')){
            $this->printAll($request,$productSold,$orders,$productStockIn);
        }
        return view('kasir.penjualanharitertentu',compact(['orders','totaluang','columnPenjualanProduct','productSold','productStockIn']));
        
    }

    public function penjualansemua(Request $request)
    {
        //dd($request->all());
        if($request->has('order_id')){
            if($request->has('start') && $request->has('end')){
                $orders = Order::whereStoreId(auth()->user()->store->id)
                            ->whereId($request->order_id)
                            ->whereBetween('created_at',[\Carbon\Carbon::createFromFormat('Y-m-d',$request->start),\Carbon\Carbon::createFromFormat('Y-m-d',$request->end)]);
            } else {
                $orders = Order::whereStoreId(auth()->user()->store->id)
                            ->whereId($request->order_id);                           
            }
        } else {
            if($request->has('start') && $request->has('end')){
               $orders = Order::whereStoreId(auth()->user()->store->id)
                            ->whereBetween('created_at',[\Carbon\Carbon::createFromFormat('Y-m-d',$request->start),\Carbon\Carbon::createFromFormat('Y-m-d',$request->end)]);
            } else {
                $orders = Order::whereStoreId(auth()->user()->store->id);
            }
        }

        $orders = $orders->orderBy('created_at','desc')->paginate(30);

        return view('kasir.penjualansemua',compact(['orders']));
    }

    public function editpenjualan(Order $order)
    {
        if($order->status == 'lunas'){
            return redirect()->back()->with('error','Penjualan yang sudah selesai tidak bisa di edit lagi');
        }

        session(['cart' => new \App\Cart(null)]); 
        session('cart')->totalQty = $order->total_qty;
        session('cart')->totalPrice = $order->total_price;
        session('cart')->orderId = $order->id;
        foreach($order->items as $item){
            session('cart')->items[$item->product_id]['qty'] = $item->qty;
            session('cart')->items[$item->product_id]['price'] = $item->price;
            session('cart')->items[$item->product_id]['item'] = $item->product;
            session('cart')->items[$item->product_id]['stocks'] = $item->product->storeAvailableStocks();
        }
        //dd(session('cart'));      
        $availableProducts = \App\Product::where('available_stocks','>',0)->pluck('name','id')->prepend('Pilih Barang','')->toArray();
        return view('kasir.editpenjualan',compact(['order','availableProducts']));
    }

    public function updatepenjualan(Request $request)
    {
        $order = Order::find($request->id);
        $order->status = 'lunas';
        $order->tgl_dibayar = \Carbon\Carbon::now();
        $order->total_qty = session('cart')->totalQty;
        $order->total_price = session('cart')->totalPrice;
        $order->save();
        $order->items()->delete();
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
        if(!$order->created_at->isToday()){
            return redirect()->back()->with('error','Penjualan tidak bisa dihapus lagi.'); 
        }
        $order->items()->delete();
        $order->pembayaran()->delete();
        $order->delete();
        return redirect()->back()->with('success','Data Penjualan berhasil dihapus.');
    }

    public function stocks()
    {
        //updateProductsAvailableStocks();
        $products = Product::get();
        return view('kasir.products',compact(['products']));
    }

    public function productview(Product $product,Request $request)
    {
        //$stocks = $product->stocks()->whereStockFrom('supplier')->orderBy('tanggal','desc')->orderBy('created_at','desc')->paginate(20);        
        
        $stocks = $product->stocks()->whereStoreId(auth()->user()->store_id)->orderBy('tanggal','desc')->orderBy('created_at','desc')->get();
        return view('kasir.productview',compact('product','stocks'));
    }

    public function addproductstock(Product $product)
    {
        $suppliers = Supplier::pluck('name','id')->prepend('Pilih Supplier','')->toArray();
        return view('kasir.productaddstock',compact('product','suppliers'));
    }

    public function insertproductstock(Request $request)
    {
        $this->validate($request,[
                'tanggal' => 'required',
                'stock_in' => 'required|numeric',
                'stock_from_id' => 'required|numeric',              
            ]);
        $request->request->add(['user_id' => auth()->user()->id]);
        $request->request->add(['store_id'=> auth()->user()->store->id]);
        $request->request->add(['stock_from'=>'supplier']);     
        //dd($request->all());
        Stock::create($request->all());
        updateProductsAvailableStocks(Product::find($request->product_id));
        return redirect()->route('kasir.stock.product.view',$request->product_id)->with('success','Stock berhasil ditambahkan');
    }

    public function bayarhutangpenjualan(Order $order)
    {
        return view('kasir.bayarhutangpenjualan',compact(['order']));
    }

    public function postbayarhutangpenjualan(Request $request)
    {
        $order = Order::find($request->order_id);
        $pembayaran = $order->pembayaran()->create([
                'nominal' => $request->nominal,
            ]);

        if($order->total_price <= $order->pembayaran->sum('nominal')){
            $order->status = 'lunas';
            $order->save();
        }

        return redirect()->route('penjualan.detail',$order);
    }

    public function ubahpassword()
    {
        return view('kasir.ubahpassword');
    }

    public function postubahpassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',            
            'new_password' => 'required|confirmed|min:8',
        ],
        [
            'confirmed' => '2 Kolom Password baru harus sama.',
            'min' => 'Password minimal 8 karakter'
        ]);

        if (!\Hash::check($request->old_password, auth()->user()->password))
        {
            return redirect()->back()->with('error','Password Lama salah atau tidak cocok !');
        }

        $user = auth()->user();
        $user->password = bcrypt($request->new_password);
        $user->save();
        auth()->logout();
        return redirect()->route('auth.login')->with('message-success','Password Berhasil diubah, silahkan login lagi.');
    }

    public function deletestock(Stock $stock)
    {
        $stock->delete();
        return redirect()->back()->with('success','Stock Berhasil dihapus.');
    }

    public function stocksbydate(Request $request)
    {

        if(!$request->has('tanggal')){
            $stocks = Stock::whereStoreId(auth()->user()->store->id)->orderBy('tanggal','desc')->paginate(30);
        } else{
            $stocks = Stock::whereTanggal($request->tanggal)->whereStoreId(auth()->user()->store->id)->orderBy('tanggal','desc')->paginate(30);
        }

        //dd($stocks);
        return view('kasir.stocksbydate',compact(['stocks']));
    }


    public function printAll($request,$productSold,$orders,$productStockIn)
    {
        //dd($productStockIn);
        $no = 1;
        $noMasuk = 1;

        //dd($order->store->name);
        $connector = new WindowsPrintConnector("ZJ-58");        
        $printer = new Printer($connector);
        $printer -> initialize();

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2,1);
        $printer->text(getSetting('company_name')."\n");
        $printer->setTextSize(1,1);
        $printer->text(\App\Store::find(getSetting('main_store'))->name."\n\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Tanggal: ".\Carbon\Carbon::parse($request->tanggal)->format('d M Y')."\n");

        $printer->text("==========BARANG TERJUAL=============\n");

        foreach ($productSold as $product) {
                $ps = $product->ordersItem()->whereDate('created_at','=',\Carbon\Carbon::parse($request->input('tanggal')));
                 $printer->text($no." ".$product->name." ".$ps->sum('qty')."\n");
                $no++;
        }


        $printer->text("\n==========BARANG MASUK=============\n");
        $totalMasuk = 0;
        foreach ($productStockIn as $psi) {
                $totalMasuk = $totalMasuk + $psi['stock_in'];
                 $printer->text($noMasuk." ".$psi['product']->name." ".$psi['stock_in']."\n");
                $noMasuk++;
        }
        // foreach($orders as $order){
        //     foreach($order->items as $item){
        //         $printer->text($no." ".$item->product->name."(".$item->qty.") ".toRp($item->price * $item->qty)."\n");
        //         $no++;
        //     }
        // }

        $printer->text("===============================\n\n");
        $printer->text("TOTAL KELUAR: ".$orders->sum('total_qty')." PCS \n");
        $printer->text("TOTAL MASUK: ".$totalMasuk." PCS \n\n\n\n\n");
        $printer->text("TOTAL HARGA: ".toRp($orders->sum('total_price'))."\n\n\n\n");
        $printer->cut();
        
        /* Close printer */
        $printer -> close();
        $block = \App\Setting::whereSettingKey('kasir_is_blocked')->first();
        $block->setting_value = '1';
        $block->save();
        return redirect()->back();
    }

    public function blocked()
    {
        return view('kasir.blocked');
    }

}
