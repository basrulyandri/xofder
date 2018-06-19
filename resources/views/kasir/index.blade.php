@extends('layouts.kasir.master')
@section('header')
	
@stop
@section('content')

	<div class="row">
		<div class="col-md-3 col-sm-12">
			<a href="#">
				<div class="widget navy-bg p-lg text-center">
	                <div class="m-b-md">
	                    <a href="{{route('kasir.quick')}}"><i style="color:#fff;" class="fa fa-shopping-cart fa-5x"></i></a>
	                    <h1 class="m-xs">Jual Cepat</h1>	                    
	                    <small>Untuk customer yang bertransaksi secara cepat</small>
	                </div>
	            </div>
	        </a>
		</div>

		<div class="col-md-3 col-sm-12">
			<a href="#">
				<div class="widget navy-bg p-lg text-center">
	                <div class="m-b-md">
	                    <a href="{{route('kasir.to.customer')}}"><i style="color:#fff;" class="fa fa-edit fa-5x"></i></a>
	                    <h1 class="m-xs">Jual ke langganan</h1>	                    
	                    <small>Penjualan dengan hutang, kirim dll</small>
	                </div>
	            </div>
	        </a>
		</div>
		<div class="col-md-3 col-sm-12">
			<a href="#">
				<div class="widget navy-bg p-lg text-center">
	                <div class="m-b-md">
	                    <a href="{{route('kasir.tostore')}}"><i style="color:#fff;" class="fa fa-external-link-square fa-5x"></i></a>
	                    <h1 class="m-xs">Antar Toko</h1>	                    
	                    <small>Transaksi antar toko</small>
	                </div>
	            </div>
	        </a>
		</div>
		
		@if(getSetting('toko_penerima_stock') == auth()->user()->store_id)
		<div class="col-md-3 col-sm-12">
			<a href="#">
				<div class="widget navy-bg p-lg text-center">
	                <div class="m-b-md">
	                    <a href="{{route('kasir.stocks.index')}}"><i style="color:#fff;" class="fa fa-check fa-5x"></i></a>
	                    <h1 class="m-xs">Tambah Stock</h1>	                    
	                    <small>Input barang masuk</small>
	                </div>
	            </div>
	        </a>
		</div>
		@endif

	</div>				
@stop

@section('footer')

</script>
@stop