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

