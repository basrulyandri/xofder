<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Product;
use App\Pembayaran;
use Carbon\Carbon;
use App\Chart;

class ReportController extends Controller
{
    public function index()
    {
    	$tanggalSeries = [];
    	$tanggal = [];
    	for ($i=6; $i > -1; $i--) { 
    		if($i == 0){
    			$tanggalSeries[] = Carbon::now()->format('d M');	
    			$tanggal[] = Carbon::now()->format('Y-m-d');
    		} else{
    			$tanggalSeries[] = Carbon::now()->subDays($i)->format('d M');   
    			$tanggal[] = Carbon::now()->subDays($i)->format('Y-m-d'); 			
    		}
    	}
    	$seriesDataPenjualan = [];
    	foreach($tanggal as $tgl){
    		$seriesDataPenjualan['name'] = 'Penjualan';
    		$seriesDataPenjualan['data'][] = intval(Order::whereDate('created_at',$tgl)->whereIn('status',['hutang','lunas'])->sum('total_price'));
    	}
    	$seriesDataPembayaran = [];
    	foreach($tanggal as $tgl){
    		$seriesDataPembayaran['name'] = 'Pembayaran';
    		$seriesDataPembayaran['data'][] = intval(Pembayaran::whereDate('created_at',$tgl)->sum('nominal'));
    	}
    	$series = [$seriesDataPenjualan,$seriesDataPembayaran];
    	$penjualanChart = new Chart;
    	$penjualanChart->chart('area')
    			->title('Penjualan')
    			->xAxis('Nilai',$tanggalSeries)
    			->yAxis('Penjualan')
    			->series($series);

    	$products = Product::all();
    	$piePenjualanProductSeries = [];
    	foreach($products as $product){
    		if($product->ordersItem()->whereBetween('created_at',[Carbon::now()->subDays(7)->toDateString(),Carbon::now()->toDateString()])->sum('qty') > 0){
	    		$piePenjualanProductSeries[] = [
	    			'name' => $product->name,
	    			'data' => $product->ordersItem->sum('qty')
	    		];	    		  			
    		}
    	}

    	$piePenjualanProduct = new Chart('pie');
    	$piePenjualanProduct->title('Penjualan berdasarkan Barang')
    						->series($piePenjualanProductSeries);
    	

    	
    	// $orders = Order::whereBetween('created_at',[Carbon::now()->subDays(7)->toDateString(),Carbon::now()->toDateString()])->get();

    	// //dd($orders);
    	return view('reports.index',compact(['penjualanChart','piePenjualanProduct']));
    }
}
