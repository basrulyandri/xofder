<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Store;

class Product extends Model
{
	

    protected $fillable = ['code','name','slug','category_id','sell_price','buy_price'];

    protected $dates = ['tanggal'];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function ordersItem()
    {
        return $this->hasMany(Item::class,'product_id');
    }

    //Global Stocks
    public function availableStocks()
    {        
        return $this->stocks()->where('stock_out','=','0')->whereStockFrom('supplier')->sum('stock_in') - $this->ordersItem->sum('qty');
    }

    public function isStocksAvailable()
    {
        if($this->availableStocks() >= 1){
            return true;
        }

        return false;
    }

    // End Global Stocks

    // Store Stocks

    public function storeAvailableStocks()
    {
        if(auth()->user()->isKasir()){
            $userStore = auth()->user()->store;
        } else{
            $userStore = Store::find(getSetting('main_store'));
        }
        
        $user = auth()->user();

        $stock_in = $this->stocks()->whereStoreId($userStore->id)->where('stock_in','!=','0')->sum('stock_in');

        // MEngambil jumlah jumlah penjualan dari sebuah barang berdasarkan toko user yang yang sedang login
        $jumlahPenjualanToko = 0;
        foreach($this->ordersItem as $item){
            if($item->order->store_id == $userStore->id){
                $jumlahPenjualanToko += $item->qty;
            }
        }

        // Stock keluar adalah stock yang keluar dari penjualan ditambah antar toko
        $stock_out = $jumlahPenjualanToko + $this->stocks()->whereStoreId($userStore->id)->where('stock_out','!=','0')->sum('stock_out');

        $available_stock = $stock_in - $stock_out;
        return $available_stock;
        
    }

    public function isStoreHasStocksAvailable()
    {
        if($this->storeAvailableStocks() >= 1){
            return true;
        }

        return false;
    }

    // End Store Stocks


}
