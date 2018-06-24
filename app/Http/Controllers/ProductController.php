<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Supplier;
use App\Stock;

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
    	$request->request->add(['store_id'=> auth()->user()->store->id]);
    	$request->request->add(['stock_from'=>'supplier']);    	
        //dd($request->all());
    	Stock::create($request->all());
    	return redirect()->route('product.view',$request->product_id)->with('success','Stock berhasil ditambahkan');
    }

    public function view(Product $product)
    {
        $suppliers = Supplier::pluck('name','id')->prepend('Pilih Supplier','')->toArray();
    	$stocks = $product->stocks()->whereStockFrom('supplier')->orderBy('tanggal','desc')->orderBy('created_at','desc')->paginate(20);    	
    	return view('products.view',compact('product','stocks','suppliers'));
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
