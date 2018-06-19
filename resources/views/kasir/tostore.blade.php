@extends('layouts.kasir.master')
@section('header')
	<link rel="stylesheet" href="{{asset('cashier')}}/bootstrap3-editable/css/bootstrap-editable.css">
	
@stop
@section('content')

	<div class="row">
				<!-- button-states -->
					<div class="col-sm-9 col-md-9">
					  			<h3>Transaksi Antar Toko ({{auth()->user()->store->name}})</h3>
					  			<hr>
						<div class="row">
							<div class="col-sm-12">								
							{!!Form::open(['route' =>'kasir.finish.to.store', 'class' => 'form-horizontal'])!!}
								<div class='form-group{{$errors->has('store_id') ? ' has-error' : ''}}'>
								  {!!Form::label('store_id','Pilih ke Toko',['class' => 'col-sm-2 control-label'])!!}
								  <div class="col-sm-10">
								    {!!Form::select('store_id',$stores,old('store_id'),['class' => 'form-control','id' => 'stores','required' => 'true'])!!}
								    @if($errors->has('store_id'))
								      <span class="help-block">{{$errors->first('store_id')}}</span>
								    @endif
								  </div>
								</div>
					  			
							</div>						
						</div>

						<hr>						
					<div id="list-penjualan">
						<div class="row">
						  <table class="table table-striped table-resposive">
							  <thead>
							    <tr>
								<th>NO</th>
								<th>BARANG</th>
								<th style="max-width:40px;">QTY</th>
								<th>HARGA SATUAN</th>
								<th>SUBTOTAL</th>
								<th>AKSI</th>
							  </tr>
							  </thead>
							  <tbody id="list-barang">							    
								<?php $no = 1;?>
							    @if(session()->has('cart'))
							    	@foreach(session('cart')->items as $key => $cart)
							    	
									<tr>
								      	<td>1</td>
										<td>{{$cart['item']->name}} <br><small>stock:{{$cart['stocks']}}</small></td>
										<td><a href="#btn-{{$key}}" id="btn-{{$key}}" class="qty" data-type="text" data-pk="{{$key}}" data-url="{{route('ajax.qty.edit')}}" data-title="Masukkan jumlah">{{$cart['qty']}}</a></td>										
										<td>
											<button product_id="{{$key}}" class="btn btn-sm bg-danger btn-hapus"><i class="fa fa-times"></i> Hapus</button>
										</td>
								    </tr>
								    <?php $no++;?>
							    	@endforeach
								@endif

							  </tbody>
							</table>
						</div>

						<div class="row">

							<div class="col-sm-6 col-sm-offset-6 text-right">
								<div class="row">
									<div class="col-sm-6">
										TOTAL BARANG
									</div>

									<div class="col-sm-6">
										{{(session()->has('cart')) ? session('cart')->totalQty : '0'}} PCS
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6">
										<b>TOTAL HARGA</b>
									</div>

									<div class="col-sm-6">
										<b>{{(session()->has('cart')) ? toRp(session('cart')->totalPrice) : '0'}}</b>
									</div>
								</div>							
							</div>
						</div>
						<br>
						<br>						
					</div>
					<br><br>
						<div class="row">
							<div class="col-sm-4 col-sm-offset-8 text-right">							
								<input type="submit" class="btn btn-lg btn-success bg-info" value="Simpan">
								{!!Form::close()!!}
							</div>							
						</div>
					</div>
					<!-- //button-states -->
					<!-- button-sizes -->
					<div class="col-sm-3 col-md-3">
						<div class="panel button-sizes">
							<div class="panel-heading">
								<div class="panel-title pn">
									<h3 class="mtn mb10 fw400">BARANG</h3>
								</div>
							</div>
							<div class="panel-body mtn" id="list-data-barang">
								<div class="bs-component mb20">									
									@if(session()->has('cart'))
										@foreach($products as $product)
											@if(!array_key_exists($product->id,session('cart')->items))
												@if($product->isStoreHasStocksAvailable())
													<button product_id="{{$product->id}}" type="button" class="btn btn-primary btn-block btn-add-data-barang" style="font-size: 11px;">{{$product->name}} ({{$product->storeAvailableStocks()}})</button>
												@else
													<button product_id="{{$product->id}}" type="button" class="btn btn-dark btn-block disabled" style="font-size: 11px;">{{$product->name}} ({{$product->storeAvailableStocks()}})</button>
												@endif
											@endif
										@endforeach
									@else
										@foreach($products as $product)			
											@if($product->isStoreHasStocksAvailable())								
												<button product_id="{{$product->id}}" type="button" class="btn btn-primary btn-block btn-add-data-barang" style="font-size: 11px;">{{$product->name}} ({{$product->storeAvailableStocks()}})</button>
											@else
												<button product_id="{{$product->id}}" type="button" class="btn btn-dark btn-block disabled" style="font-size: 11px;">{{$product->name}} ({{$product->storeAvailableStocks()}})</button>
											@endif
										@endforeach
									@endif
								</div>								
							</div>
						</div>
					</div>
					<div class="clearfix"> </div>
				
			</div>
@stop

@section('footer')
<script src="{{asset('cashier')}}/bootstrap3-editable/js/bootstrap-editable.js"></script>
<script src="{{asset('cashier/js/select2.min.js')}}"></script>
<script>
	$(document).ready(function(){
		$.fn.editable.defaults.mode = 'popup';
		$.fn.editable.defaults.params = function (params) {
                params._token = '{{Session::token()}}';
                return params;
            };
		$('body').on('click','button.btn-add-data-barang', function(){
			var el = $(this);
			var product_id = $(this).attr('product_id');
			var _token = '{{Session::token()}}';
			$.ajax({
			  type: "POST",
			  url: "{{route('ajax.post.addtocart')}}",
			  data: { product_id : product_id, _token:_token },
			}).success(function(data){
				console.log(data.cart);
				$('#list-data-barang').html(data.viewlistbarang);				
				$('#list-penjualan').html(data.viewlistpenjualan);				
			});			
		});

		$('body').on('click','button.btn-hapus', function(){
			var product_id = $(this).attr('product_id');
			var _token = '{{Session::token()}}';
			$.ajax({
			  type: "POST",
			  url: "{{route('ajax.post.removeitem')}}",
			  data: { product_id : product_id, _token:_token },
			}).success(function(data){
				console.log(data);
				$('#list-data-barang').html(data.viewlistbarang);				
				$('#list-penjualan').html(data.viewlistpenjualan);				
			});			
		});

		$('#list-penjualan').editable({
			selector:'.qty',
			success: function(response, newValue) {
				console.log(response);
		        $('#list-penjualan').html(response.viewlistpenjualan);
		    }
		});

		$('#stores').select2();		
	});
</script>
@stop