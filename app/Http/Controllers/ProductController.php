<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Supplier;
use App\Stock;
use Carbon\Carbon;
class ProductController extends Controller
{
    public function index()
    {
    	$products = Product::all();
    	return view('products.index',compact(['products']));
    }

    public function add()
    {
    	return view('products.add');
    }

    public function addstocks(Product $product)
    {    	
    	$suppliers = Supplier::pluck('name','id')->prepend('Pilih Supplier','')->toArray();
    	return view('products.addstocks',compact('product','suppliers'));
    }

    public function postaddstock(Request $request)
    {
    	$this->validate($request,[
                'tanggal' => 'required',
    			'stock_in' => 'required|numeric',
    			'stock_from_id' => 'required|numeric',    			
    		]);
    	$request->request->add(['user_id' => auth()->user()->id]);
    	$request->request->add(['store_id'=> getSetting('main_store')]);
    	$request->request->add(['stock_from'=>'supplier']);    	
        //dd($request->all());
    	Stock::create($request->all());
    	return redirect()->route('product.view',$request->product_id)->with('success','Stock berhasil ditambahkan');
    }

    public function view(Product $product,Request $request)
    {
        if($request->has('start_date') && $request->has('end_date')){

            $dateRangeArray = [Carbon::parse($request->start_date)->startOfDay(),Carbon::parse($request->end_date)->endOfDay()];
        }else{
            $dateRangeArray = [Carbon::now()->subDays(7)->startOfDay(),Carbon::now()->endOfDay()];
        }
        $queryStocks = $product->stocks()->whereStoreId(getSetting('main_store'))->whereBetween('tanggal',$dateRangeArray);
        $totalStockOut = $queryStocks->sum('stock_out');
        $totalStockIn = $queryStocks->sum('stock_in');
        $stocks = $queryStocks->orderBy('tanggal','desc')->get();
        //dd($stocks);
        $queryProductSoldLog = $product->ordersItem()->whereBetween('created_at',$dateRangeArray);
        $totalProductSold = $queryProductSoldLog->sum('qty');
        $productSoldLog = $queryProductSoldLog->orderBy('created_at','desc')->get();


        //dd($productSoldLog);
    	return view('products.view',compact('product','stocks','suppliers','productSoldLog','totalStockOut','totalStockIn','totalProductSold'));
    }

    public function postadd(Request $request)
    {
        //dd($request->all());
    	$this->validate($request,[
    			'code' => 'required|unique:products,code',
    			'name' => 'required',
    			'category_id' => 'required|numeric',
    			'sell_price' => 'required|numeric'
    		]);

        // $product = new Product;
        // $product->code = $request->code;
        // $product->name = $request->name;
        // $product->category_id = $request->category_id;
        // $product->sell_price = $request->sell_price;
        // $product->description = $request->description;
        // //dd($product);
        // $product->save();

    	Product::create($request->all());
    	return redirect()->back()->with('success','Data barang baru berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    public function update(Product $product,Request $request)
    {

        //dd($request->all());
        $this->validate($request,[                
                'name' => 'required',
                'category_id' => 'required|numeric',
                'sell_price' => 'required|numeric'
            ]);
        $product->update($request->all());
        return redirect()->route('products.index')->with('success','Data barang berhasil diubah');
    }

    public function editstock(Stock $stock)
    {
        $suppliers = Supplier::pluck('name','id')->prepend('Pilih Supplier','')->toArray();
        return view('stocks.edit',compact('stock','suppliers'));
    }

    public function updatestock(Request $request, Stock $stock)
    {
        $this->validate($request,[
            'tanggal' => 'required',
            'stock_in' => 'required|numeric',
            'stock_from_id' => 'required|numeric',              
        ]);

        $stock->update($request->all());
        return redirect()->route('product.view',$stock->product_id)->with('success','Stock berhasil diubah');
    }
}
