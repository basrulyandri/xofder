@if(isset($alert))
	@if($alert)
	<div class="alert alert-warning">	
		<i class="fa fa-exclamation-triangle"></i> <strong>Stok Tidak cukup. Perhatikan stock yang tersedia di bawah nama barang.</strong>
	</div>
	@endif
@endif

@if(isset($alert_harga))
	@if($alert_harga)
	<div class="alert alert-warning">	
		<i class="fa fa-exclamation-triangle"></i> <strong>Harga tidak boleh dibawah harga jual yang di tetapkan.</strong>
	</div>
	@endif
@endif

<div class="row">
  <table class="table table-striped table-resposive">
	  <thead>
	    <tr>
		<th>NO</th>
		<th>BARANG</th>
		<th>QTY</th>
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
				<td><a href="#" class="qty" data-type="text" data-pk="{{$key}}" data-url="{{route('ajax.qty.edit')}}" data-title="Masukkan jumlah">{{$cart['qty']}}</a></td>
				<td><a href="#btnHarga-{{$key}}" id="btnHarga-{{$key}}" class="harga" data-type="text" data-pk="{{$key}}" data-url="{{route('ajax.harga.edit')}}" data-title="Masukkan jumlah">{{$cart['price']}}</a></td>

				<td>{{toRp($cart['price'] * $cart['qty'])}}</td>
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