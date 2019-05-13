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
    public function index(Request $request)
    {

    	$tanggalSeries = [];
    	$tanggal = [];
    	$seriesDataPenjualan = [];
    	$seriesDataPembayaran = [];
        
        if(!$request->has('period') || $request->period == 7){
            for ($i=6; $i > -1; $i--) { 
                if($i == 0){
                    $tanggalSeries[] = Carbon::now()->format('d M');    
                    $tanggal[] = Carbon::now()->format('Y-m-d');
                } else{
                    $tanggalSeries[] = Carbon::now()->subDays($i)->format('d M');   
                    $tanggal[] = Carbon::now()->subDays($i)->format('Y-m-d');           
                }
            }
            foreach($tanggal as $tgl){
                $seriesDataPenjualan['name'] = 'Penjualan';
                $seriesDataPenjualan['data'][] = intval(Order::whereDate('created_at',$tgl)->whereIn('status',['hutang','lunas'])->sum('total_price'));
            }
        	foreach($tanggal as $tgl){
        		$seriesDataPembayaran['name'] = 'Pembayaran';
        		$seriesDataPembayaran['data'][] = intval(Pembayaran::whereDate('created_at',$tgl)->sum('nominal'));
        	}            
        } elseif($request->period == 28) {
            for ($i=27; $i > -1; $i--) { 
                if($i == 0){
                    $tanggalSeries[] = Carbon::now()->format('d M');    
                    $tanggal[] = Carbon::now()->format('Y-m-d');
                } else{
                    $tanggalSeries[] = Carbon::now()->subDays($i)->format('d M');   
                    $tanggal[] = Carbon::now()->subDays($i)->format('Y-m-d');           
                }
            }
            foreach($tanggal as $tgl){
                $seriesDataPenjualan['name'] = 'Penjualan';
                $seriesDataPenjualan['data'][] = intval(Order::whereDate('created_at',$tgl)->whereIn('status',['hutang','lunas'])->sum('total_price'));
            }
            foreach($tanggal as $tgl){
                $seriesDataPembayaran['name'] = 'Pembayaran';
                $seriesDataPembayaran['data'][] = intval(Pembayaran::whereDate('created_at',$tgl)->sum('nominal'));
            }
        }


    	$series = [$seriesDataPenjualan,$seriesDataPembayaran];
    	$penjualanChart = new Chart;
    	$penjualanChart->chart('area')
    			->title('Laporan Nilai Penjualan '.((!$request->has('period') || $request->period == 7) ? '7 Hari Terakhir' : '28 Hari Terakhir'))
    			->xAxis('Nilai',$tanggalSeries)
    			->yAxis('Penjualan')
                ->legend('Klik untuk sembunyikan.')
                ->plotOptions([
                    'enabled' =>  true,
                    'borderRadius'=> 2,
                    'y'=> -10,
                    'shape' => 'callout'])
    			->series($series);

    	$products = Product::all();
    	$piePenjualanProductSeries = [];
    	foreach($products as $product){

            //dd($product->ordersItem()->whereBetween('created_at',[Carbon::now()->subDays((!$request->has('period') || $request->period == 7) ? 7 : 28)->toDateString(),Carbon::now()->toDateString()])->sum('qty'));

    		if($product->ordersItem()->whereBetween('created_at',[Carbon::now()->subDays((!$request->has('period') || $request->period == 7) ? 7 : 28)->toDateString(),Carbon::now()->toDateString()])->sum('qty') > 0){
	    		$piePenjualanProductSeries[] = [
	    			'name' => $product->name,
	    			'data' => intval($product->ordersItem()->whereBetween('created_at',[Carbon::now()->subDays((!$request->has('period') || $request->period == 7) ? 7 : 28)->toDateString(),Carbon::now()->toDateString()])->sum('qty'))
	    		];	    		  			
    		}
    	}

    	$piePenjualanProduct = new Chart('pie');
    	$piePenjualanProduct->title('Penjualan berdasarkan Barang '.((!$request->has('period') || $request->period == 7) ? '7 Hari Terakhir' : '28 Hari Terakhir'))
                             ->plotOptions([
                                'enabled' =>  true,
                                'borderRadius'=> 2,
                                'y'=> -10,
                                'shape' => 'callout'])
    						->series($piePenjualanProductSeries);
                            
    	if(auth()->user()->isKasir()){
            return view('kasir.report',compact(['penjualanChart','piePenjualanProduct']));
        } else {
    	   return view('reports.index',compact(['penjualanChart','piePenjualanProduct']));
        }
    }


    public function daterange(Request $request)
    {
        if(!$request->has('rentang')){
            return view('reports.daterange');
        }
        //dd($request->rentang);
        $tanggal = explode(' - ', $request->rentang) ;
        $start_date = \Carbon\Carbon::parse($tanggal[0]);
        $end_date = \Carbon\Carbon::parse($tanggal[1]);



        $orders = Order::whereStoreId(getSetting('main_store'))->whereIn('status',['lunas','hutang'])->whereBetween('created_at',[$start_date,$end_date])->orderBy('created_at','desc')->with(['pembayaran','items'])->get();

        $products = Product::all();
        $columnPenjualanProductSeries = [];
        $productSold = [];        
        foreach($products as $product){            
            $productOrderItems = $product->ordersItem()->whereBetween('created_at',[$start_date,$end_date])->sum('qty');
            if($productOrderItems > 0){   
                $productSold[] = $product;              
                $columnPenjualanProductSeries[] = [
                    'name' => $product->name,
                    'data' => [intval($productOrderItems)]
                ];                          
            }
        }          

        $columnPenjualanProduct = new Chart('column');
        $columnPenjualanProduct->title('Penjualan berdasarkan barang '.$request->rentang)
                                ->xAxis('',[$request->rentang])
                                ->plotOptions([
                                    'enabled' =>  true,
                                    'borderRadius'=> 2,
                                    'y'=> -10,
                                    'shape' => 'callout',
                                    ])
                                ->series($columnPenjualanProductSeries);


        
        $totaluang = 0;
        $totalmodal = 0;
        foreach($orders as $order){
            //dd($order->pembayaran);
            $pembayarans = $order->pembayaran()->whereBetween('created_at',[$start_date,$end_date])->get();
            foreach($pembayarans as $pembayaran){
                $totaluang = $totaluang + $pembayaran->nominal;                
            }

            foreach($order->items as $item){
                $totalmodal = $totalmodal + ($item->buy_price * $item->qty );
            }
            
            
        }
        // dd($orders->sum('total_qty'));
        $totalprofit = $orders->sum('total_price') - $totalmodal;
        
        return view('reports.daterange',compact(['orders','totaluang','columnPenjualanProduct','productSold','productStockIn','start_date','end_date','totalprofit']));
    }
}
