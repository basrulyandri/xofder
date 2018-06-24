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
    			->series($series);

    	$products = Product::all();
    	$piePenjualanProductSeries = [];
    	foreach($products as $product){
    		if($product->ordersItem()->whereBetween('created_at',[Carbon::now()->subDays((!$request->has('period') || $request->period == 7) ? 7 : 28)->toDateString(),Carbon::now()->toDateString()])->sum('qty') > 0){
	    		$piePenjualanProductSeries[] = [
	    			'name' => $product->name,
	    			'data' => $product->ordersItem->sum('qty')
	    		];	    		  			
    		}
    	}

    	$piePenjualanProduct = new Chart('pie');
    	$piePenjualanProduct->title('Penjualan berdasarkan Barang '.((!$request->has('period') || $request->period == 7) ? '7 Hari Terakhir' : '28 Hari Terakhir'))
    						->series($piePenjualanProductSeries);
    	
    	return view('reports.index',compact(['penjualanChart','piePenjualanProduct']));
    }
}
