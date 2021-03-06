<?php
function toRp($angka)
{
 	$jadi = "Rp. " . number_format($angka,0,',','.');
	return $jadi;
}

function getSetting($key)
{
	return \App\Setting::whereSettingKey($key)->first()->setting_value;
}

function stockFrom($stock){
	if($stock->stock_from == 'supplier'){
		return $stock->supplier->name;
	}
}

function totalProductsHasMinimunStock()
{
	$amount = 0;
	foreach(\App\Product::all() as $product){
		if($product->available_stocks < 100 ){
			$amount++;
		}
	}

	return $amount;
}

function amountOfProductsHasMinimunStock()
{
	$amount = 0;
	foreach(\App\Product::all() as $product){
		if($product->storeAvailableStocks() < 100 ){
			$amount++;
		}
	}

	return $amount;
}

function amountOfDraftOrders()
{
	return \App\Order::whereStatus('draft')->count();
}

function amountOfSuccessOrders(){
	return \App\Order::whereIn('status',['hutang','lunas'])->count();	
}

function amountOfTotalStocks(){
	$total = 0;
	foreach(\App\Product::all() as $product){
		$total += $product->available_stocks;
	}

	return $total;
}

function updateProductsAvailableStocks($products = null)
{

	if(!$products){
		$products = \App\Product::all();				
	}

	if($products instanceof Illuminate\Database\Eloquent\Collection){
		foreach($products as $product){
			$product->available_stocks = $product->storeAvailableStocks();
			$product->save();
		}
	}else{
		$products->available_stocks = $products->storeAvailableStocks();
		$products->save();
	}
}

function checkBlockApp()
{
	$block = \App\Setting::whereSettingKey('kasir_is_blocked')->first();
	if(!$block->updated_at->isToday()){
        $block->setting_value = '0';
        $block->save();
    }
}

