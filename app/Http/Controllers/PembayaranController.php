<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use App\Pembayaran;
use App\Order;

class PembayaranController extends Controller
{
	public function print(Pembayaran $pembayaran,Order $order)
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
        $printer->text("Tanggal Bayar: ".$pembayaran->created_at->format('d M Y')."\n");
        $printer->text("No Order: ".$order->id."\n");
        $printer->text("Dibayar: ".toRp($pembayaran->nominal)."\n");
        $printer->text("Customer: ".$order->customer->name."\n\n");

         $printer->text("TOTAL HARGA: ".toRp($order->total_price)."\n");
         $printer->text("TOTAL TERBAYAR: ".toRp($order->pembayaran->sum('nominal'))."\n");

		if($order->status == 'hutang'){
			$printer->text("SISA HUTANG: ".toRp($order->total_price - $order->pembayaran->sum('nominal'))."\n");			
		} elseif($order->status == 'lunas'){
			$printer->text("STATUS : ".$order->status."\n");
		}
        $printer->text('KASIR: '.$order->kasir->username."\n\n");

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2,1);
        $printer->text("RINCIAN CICILAN \n\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setTextSize(1,1);
        foreach($order->pembayaran()->orderBy('created_at','desc')->get() as $bayar){
        	$printer->text($no.". ".$bayar->created_at->format("d M Y")." ".toRp($bayar->nominal)."\n\n");
        	$no++;
        }

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
}