@extends('layouts.frontend.master')
@section('content')

<div class="col-sm-12">
	
	@if(session('cart') && !empty(session('cart')->items))				
	<h3 class="text-center">KERANJANG BELANJA</h3>
	<table id="cart" class="table table-hover table-condensed">
		<thead>
			<tr>
				<th style="width:50%">Produk</th>
				<th style="width:10%">Harga</th>
				<th style="width:8%">Qty</th>
				<th style="width:22%" class="text-center">Subtotal</th>
				<th style="width:10%"></th>
			</tr>
		</thead>
		<tbody>
		

			@foreach(session('cart')->items as $key => $value)
			
			<tr>
				<td data-th="Product">
					<div class="row">
						<div class="col-sm-2 hidden-xs"><img src="{{$value['image']}}" alt="..." class="img-responsive"/></div>
						<div class="col-sm-10">
							<h4 class="nomargin">{{$value['item']->name}}</h4>
							<p>{{$value['item']->description}}</p>
						</div>
					</div>
				</td>
				<td data-th="Price">{{toRp($value['price'])}}</td>
				<td data-th="Quantity">
					<div class="btn-group btn-group-xs" role="group" aria-label="">
					  <button type="button" product-id="{{$key}}" class="btn btn-primary substractQty">-</button>
					  <button style="cursor: text;" class="btn btn-default itemQty">{{$value['qty']}}</button>
					  <button type="button" product-id="{{$key}}" class="btn btn-primary addQty">+</button>
					</div>					
				</td>
				<td data-th="Subtotal" price="{{$value['price']}}" class="text-center subtotal">{{toRp($value['price'] * $value['qty'])}}</td>
				<td class="actions" data-th="">								
					<button class="btn btn-danger btn-sm removecart" item-id="{{$key}}"><i class="fa fa-trash-o"></i></button>								
				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr class="visible-xs">
				<td class="text-center totalprice"><strong>{{toRp(session('cart')->totalPrice)}}</strong></td>
			</tr>
			<tr>
				<td><a href="{{route('home')}}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Lanjut Belanja</a></td>
				<td colspan="2" class="hidden-xs"></td>
				<td class="hidden-xs text-center totalprice"><strong>{{toRp(session('cart')->totalPrice)}}</strong></td>
				<td><a href="{{route('page.checkout')}}" class="btn btn-success btn-block">Pembayaran <i class="fa fa-angle-right"></i></a></td>
			</tr>
		</tfoot>
	</table>				
	@else
	<div class="clearfix"></div>
	<div class="row">
		<div class="comment-list styled clearfix">
            <ol>
                <li class="comment first last">
                    <div class="comment-body boxed">
                        <div class="comment-arrow"></div>
                        <div class="comment-avatar">
                            <div class="avatar"><img src="{{url('assets/frontend')}}/images/empty-shopping-cart.jpg" alt=""></div>
                        </div>
                        <div class="comment-text">
                            <div class="comment-author clearfix">
                                <a href="#" class="link-author" hidefocus="true" style="outline: none;">KOSONG</a>
                            </div>
                            <div class="comment-entry">
                                Keranjang Belanja anda saat ini masih kosong. <a href="{{route('home')}}" class="btn btn-warning pull-right">Lanjut Belanja 	<i class="fa fa-angle-right"></i></a>

                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </li>
            </ol>
        </div>
	</div>
	@endif

</div>	
@include('layouts.frontend.footer')
@stop

@section('footer')
<script>
	$(document).ready(function(){		
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
			var price = btn.parent().parent().siblings('.subtotal').attr('price');			
			var itemQty = btn.siblings('.itemQty').text();
			var product_id = btn.attr('product-id');
			var _token = '{{Session::token()}}';
			$.ajax({
			  type: "POST",
			  url: "{{route('ajax.post.addtocart')}}",
			  data: { product_id : product_id, _token:_token },
			}).success(function(data){
				$('#cartInfo').text(data['cart'].totalQty);
				var currentQty = parseInt(itemQty) + 1;
				var currentSubTotal = parseInt(price) * currentQty;
				btn.siblings('.itemQty').text(currentQty);
				btn.parent().parent().siblings('.subtotal').attr('subtotal',currentSubTotal);
				btn.parent().parent().siblings('.subtotal').text(toRp(currentSubTotal));
				$('.totalprice').html('<strong>'+toRp(data['cart'].totalPrice)+'</strong>');
			});
		});

		$('.substractQty').click(function(){
			var btn = $(this);
			var price = btn.parent().parent().siblings('.subtotal').attr('price');			
			var itemQty = btn.siblings('.itemQty').text();
			var _token = '{{Session::token()}}';
			if(itemQty > 1){				
				var product_id = btn.attr('product-id');
				$.ajax({
				  type: "POST",
				  url: "{{route('ajax.post.substractqty')}}",
				  data: { product_id : product_id, _token:_token },
				}).success(function(data){
					$('#cartInfo').text(data['cart'].totalQty);
					var currentQty = parseInt(itemQty) - 1;
					var currentSubTotal = parseInt(price) * currentQty;
					btn.siblings('.itemQty').text(currentQty);
					btn.parent().parent().siblings('.subtotal').attr('subtotal',currentSubTotal);
					btn.parent().parent().siblings('.subtotal').text(toRp(currentSubTotal));
					$('.totalprice').html('<strong>'+toRp(data['cart'].totalPrice)+'</strong>');
				});
			}else{			
				var el = $(this);
				var item_id = el.attr('product-id');			
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
			}
		});
	});
</script>
@stop