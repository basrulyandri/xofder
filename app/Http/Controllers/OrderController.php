<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Store;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class OrderController extends Controller
{
	public function index(Request $request)
	{
		if($request->store_id == ''){
			$orders = Order::orderBy('created_at','desc')->paginate(20);			
		} else {
			$store = Store::find($request->store_id);
			$orders = $store->orders()->orderBy('created_at','desc')->paginate(20);
		}
		return view('orders.index',compact('orders'));
	}

	public function view(Order $order)
	{
		return view('orders.view',compact('order'));
	}

	public function cetak(Order $order)
	{		
		//dd($order);
		$no = 1;

		// dd($order->store->name);
		$connector = new WindowsPrintConnector("ZJ-58");	    
	    $printer = new Printer($connector);
	    $printer -> initialize();

	    $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2,1);
        $printer->text(getSetting('company_name')."\n");
        $printer->setTextSize(1,1);
        $printer->text($order->store->name."\n\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Tanggal: ".$order->created_at->format('d M Y')."\n");
        $printer->text("No Order: ".$order->id."\n");
        $printer->text("Customer: ".$order->customer->name."\n\n");

        $printer->text("===============================\n");
		foreach($order->items as $item){
			$printer->text($no." ".$item->product->name."(".$item->qty.") ".toRp($item->price * $item->qty)."\n");
			$no++;
		}

		$printer->text("===============================\n\n");
		$printer->text("TOTAL QTY: ".$order->total_qty." PCS \n");
		$printer->text("TOTAL HARGA: ".toRp($order->total_price)."\n");
		$printer->text("\n");
		$printer->text("BAYAR: ".toRp($order->pembayaran->sum('nominal'))."\n");				
		if($order->status == 'hutang'){
			$printer->text("HUTANG: ".toRp($order->total_price - $order->pembayaran->sum('nominal'))."\n");			
		} elseif($order->status == 'lunas'){
			$printer->text("STATUS : ".$order->status."\n");
		}
        $printer->text('KASIR: '.$order->kasir->username."\n\n");

		$printer->setJustification(Printer::JUSTIFY_CENTER);					
		$printer->text("Terima kasih telah berbelanja di".getSetting('company_name')."\n");
		$printer->text("\n");
		$printer->text("Supported By rolloic.com");
		$printer->text("\n");
		$printer->text("\n");
		$printer->text("\n");
		$printer->text("\n");
	    $printer->cut();
	    
	    /* Close printer */
	    $printer -> close();

	    return redirect()->back();
	}

	public function edittanggal()
	{
		return view('orders.edittanggal');
	}

	public function updatetanggal(Request $request)
	{
		//dd($request->tanggal);
		$orders = explode(',',$request->orders);
		foreach($orders as $idOrder){
			$check = Order::find($idOrder);
			if(!$check){
				return redirect()->back()->with('error','Ada no penjualan yang salah');
			}
		}

		foreach($orders as $order){
			$order = Order::find($order);
			$order->tgl_dibayar = $request->tanggal;
			$order->created_at = $request->tanggal;
			$order->save();

			foreach($order->items as $item){
				$item->created_at = $request->tanggal;
				$item->save();
			}

			foreach($order->pembayaran as $pembayaran){
				$pembayaran->created_at = $request->tanggal;
				$pembayaran->save();
			}
		}

		return redirect()->back()->with('success','Data penjualan berhasil diubah.');
	}

	// Function khusus untuk judul printer
	function title(Printer $printer, $text)
	{
	    $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
	    $printer -> text("\n-------- " . $text." --------\n");
	    $printer -> selectPrintMode(); // Reset
	}


}
