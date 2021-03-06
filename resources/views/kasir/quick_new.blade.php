@extends('layouts.kasir.master')
@section('header')
	<link rel="stylesheet" href="{{asset('cashier')}}/bootstrap3-editable/css/bootstrap-editable.css">
	<link rel="stylesheet" href="{{asset('cashier/css')}}/select2.min.css">
@stop
@section('content')

	<div class="row">
					<div class="col-sm-9 col-md-9">
						<div class="row">
							<div class="col-sm-12">								
					  			<h3>PENJUALAN CEPAT ({{auth()->user()->store->name}})</h3>
							</div>						
						</div>						
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
								      	<td>{{$no}}</td>
										<td>{{$cart['item']->name}} <br><small>stock:{{$cart['stocks']}}</small></td>
										<td><a href="#btn-{{$key}}" id="btn-{{$key}}" class="qty" data-type="text" data-pk="{{$key}}" data-url="{{route('ajax.qty.edit')}}" data-title="Masukkan jumlah">{{$cart['qty']}}</a></td>

										<td><a href="#btnHarga-{{$key}}" id="btnHarga-{{$key}}" class="harga" data-type="text" data-pk="{{$key}}" data-url="{{route('ajax.harga.edit')}}" data-title="Masukkan jumlah">{{$cart['item']->sell_price}}</a></td>

										
										<td>{{toRp($cart['item']->sell_price * $cart['qty'])}}</td>
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
								<a href="{{route('kasir.save')}}" class="btn btn-lg btn-warning bg-info">Simpan <i class="fa fa-save"></i></a>
						    	<a href="{{route('kasir.finish')}}" class="btn btn-lg btn-primary bg-info">Selesai <i class="fa fa-check"></i></a>
							</div>							
						</div>
					</div>
					<!-- //button-states -->
					<!-- button-sizes -->
					<div class="col-sm-3 col-md-3">
						<div class="panel button-sizes">
							<div class="panel-heading">
								<div class="panel-title pn">
									<h3 class="mtn mb10 fw400">LIST BARANG</h3>
									<small>Barang yang ada list bawah ini adalah barang yang stoknya tersedia.</small>
								</div>
							</div>

							<div class='form-group{{$errors->has('supplier_id') ? ' has-error' : ''}}' style="    padding: 0 10px;">
				                <select name="stock_from_id" id="listBarang" class="form-control" style="width:100%;">
				                    @foreach($availableProducts as $key => $product)
				                    	<option value="{{ $key }}">{{ $product }}</option>
				                    @endforeach
				                </select>
				                @if($errors->has('supplier_id'))
				                  <span class="help-block">{{$errors->first('supplier_id')}}</span>
				                @endif				              	
				              </div>
				              
				            </div> 
							
						</div>
					</div>
					<div class="clearfix"> </div>
				
				<!-- //buttons -->
			</div>
@stop

@section('footer')
<script src="{{asset('cashier')}}/bootstrap3-editable/js/bootstrap-editable.js"></script>
<script src="{{asset('cashier/js')}}//select2.min.js"></script>
<script>
	$(document).ready(function(){
		$.fn.editable.defaults.mode = 'popup';
		$.fn.editable.defaults.params = function (params) {
                params._token = '{{Session::token()}}';
                return params;
            };

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
			savenochange:true,
			success: function(response, newValue) {				
		        $('#list-penjualan').html(response.viewlistpenjualan);
		        $('#listBarang').select2('open');
		    }
		});

		$('#list-penjualan').editable({
			selector:'.harga',
			success: function(response, newValue) {				
		        $('#list-penjualan').html(response.viewlistpenjualan);
		        console.log(newValue);
		    }
		});

		$('#listBarang').select2();
		$('#listBarang').select2('open');


		$('#listBarang').on('select2:select', function (e) { 
			var el = $(this);
			var product_id = $(this).val();

			var _token = '{{Session::token()}}';
			$.ajax({
			  type: "POST",
			  url: "{{route('ajax.post.addtocart')}}",
			  data: { product_id : product_id, _token:_token },
			}).success(function(data){				
				$('#list-penjualan').html(data.viewlistpenjualan);	
				//$(".qty[data-pk='"+product_id+"']").editable('show');

				$( "body" ).on( "click",".qty[data-pk='"+product_id+"']", function() {
					$(this).on('shown', function(e, editable) {				           
				             setTimeout(function() {
				                 editable.input.$input.select();
				                 //console.log('paused here');
				             }, 500);				         
				      });
				});
				$( ".qty[data-pk='"+product_id+"']" ).trigger( "click" );
			});
		});

	});
</script>
@stop