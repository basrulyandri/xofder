@extends('layouts.frontend.master')
@section('content')

	<h3 class="text-center">PILIH METODE PEMBAYARAN</h3>
	<hr>
<div class="col-sm-4">			
	<table id="cart" class="table table-hover table-condensed">
		<thead>
			<tr>
				<th style="width:50%">Produk</th>				
				<th style="width:8%">Qty</th>								
			</tr>
		</thead>
		<tbody>
		

			@foreach(session('cart')->items as $key => $value)
			
			<tr>
				<td data-th="Product">{{$value['item']->name}}</td>				
				<td data-th="Quantity">{{$value['qty']}}</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr class="visible-xs">
				<td class="text-center totalprice"><strong>{{toRp(session('cart')->totalPrice)}}</strong></td>
			</tr>
			<tr>				
				
				<td colspan="2" class="hidden-xs text-center totalprice">Total : <strong>{{toRp(session('cart')->totalPrice)}}</strong></td>				
			</tr>
		</tfoot>
	</table>	
</div>

<div class="col-sm-8">
	{!!Form::open(['route' =>'page.post.checkout'])!!}
	<div class="frb-group">	
	@if(\Auth::user()->isAnggota())
		<div class="frb frb-success">
			<input type="radio" id="ewallet" name="payment_method" value="eWallet" required="" @if(!isEWalletCukup()) 
			disabled
			@endif >
			<label for="ewallet">
				<span class="frb-title">eWallet</span>
				<span class="frb-description">Saldo Anda : {{toRp(\Auth::user()->saldo('eWallet'))}}</span>
			</label>
		</div>					
	@endif			
		<div class="frb frb-success">
			<input type="radio" id="transfer" name="payment_method" value="transfer" required="">
			<label for="transfer">
				<span class="frb-title">Transfer Bank</span>
				<span class="frb-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper quam nunc.</span>
			</label>
		</div>
		<button id="btnSelesai" style="display: none; margin-top:20px; " href="{{route('page.checkout')}}" class="btn btn-info btn-block">Selesai</button>
	{!!Form::close()!!}
	</div>
</div>
@stop

@section('footer')
<script>
	$(document).ready(function(){
	$('input[type="radio"]').click(function(){
		$('#btnSelesai').show();
	});	
		var _token = "{{Session::token()}}";
		$('body').on('click','.removecart',function(){
			var el = $(this);
			var item_id = el.attr('item-id');			
			$.ajax({
				url: "{{route('ajax.post.removefromcart')}}",
				type: 'POST',				
				data: {_token:_token,item_id:item_id},
			})			
			.success(function(response) {
				el.closest('tr').hide('slow',function(){
					el.remove();
				});
				$('#cartInfo').text(response['cart'].totalQty);
				$('.totalprice').html('<strong>'+toRp(response['cart'].totalPrice)+'</strong>');
				toastr.success('1 Item berhasil di hapus'); 
			});
			

		});

		function toRp(angka){
		    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
		    var rev2    = '';
		    for(var i = 0; i < rev.length; i++){
		        rev2  += rev[i];
		        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
		            rev2 += '.';
		        }
		    }
		    return 'Rp. ' + rev2.split('').reverse().join('');
		}

		$('.addQty').click(function(){
			var btn = $(this);			
			var product_id = btn.attr('product-id');
			var _token = '{{Session::token()}}';
			$.ajax({
			  type: "POST",
			  url: "{{route('ajax.post.addtocart')}}",
			  data: { product_id : product_id, _token:_token },
			}).success(function(data){
				$('#cartInfo').text(data['cart'].totalQty);								
				console.log(data['cart'].totalQty);
			});
		});
	});
</script>
@stop