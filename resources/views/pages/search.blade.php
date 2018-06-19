@extends('layouts.frontend.master')
@section('content')
<div class="shoes-grid">
<div class="products">
	<h5 class="latest-product">CARI PRODUK : {{$request->input('q')}}</h5>		
</div>
<div class="product-left">
	@foreach($products as $product)
	<div class="col-md-4 chain-grid @if($loop->iteration%3 == 0) grid-top-chain @endif">
		<a href="{{route('page.single',['slug' => $product->slug])}}"><img class="img-responsive chain" src="{{$product->cover()}}" alt=" " /></a>
		<span class="star"> </span>
		<div class="grid-chain-bottom">
			<h6><a href="{{route('page.single',['slug' => $product->slug])}}">{{$product->name}}</a></h6>
			<div class="star-price">
				<div class="dolor-grid"> 
				<span class="actual">{{toRp($product->price)}}</span>
					<span class="reducedfrom"></span>
					<span class="rating">
						<!-- <input type="radio" class="rating-input" id="rating-input-1-5" name="rating-input-1">
						<label for="rating-input-1-5" class="rating-star1"> </label>
						<input type="radio" class="rating-input" id="rating-input-1-4" name="rating-input-1">
						<label for="rating-input-1-4" class="rating-star1"> </label>
						<input type="radio" class="rating-input" id="rating-input-1-3" name="rating-input-1">
						<label for="rating-input-1-3" class="rating-star"> </label>
						<input type="radio" class="rating-input" id="rating-input-1-2" name="rating-input-1">
						<label for="rating-input-1-2" class="rating-star"> </label>
						<input type="radio" class="rating-input" id="rating-input-1-1" name="rating-input-1">
						<label for="rating-input-1-1" class="rating-star"> </label> -->
					</span>
				</div>
				<a class="now-get get-cart" product-id="{{$product->id}}" style="cursor: pointer;">BELI</a> 
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	@endforeach   		     	   		     	
	<div class="clearfix"> </div>
</div>
{{$products->appends(['q' => $request->q])->links()}}

<div class="clearfix"> </div>
</div> 


@include('layouts.frontend.sidebar')
@include('layouts.frontend.footer')
@stop

@section('footer')
<script>
	$(document).ready(function(){
		$('.get-cart').click(function(){
			var btn = $(this);
			btn.html('<i class="fa fa-circle-o-notch fa-spin"></i> ...proses');
			var product_id = btn.attr('product-id');
			var _token = '{{Session::token()}}';
			$.ajax({
			  type: "POST",
			  url: "{{route('ajax.post.addtocart')}}",
			  data: { product_id : product_id, _token:_token },
			}).success(function(data){
				$('#cartInfo').text(data['cart'].totalQty);
				btn.html('BELI');
				toastr.success('Berhasil','Produk berhasil dimasukkan ke keranjang');
				console.log(data['cart'].totalQty);
			});
		});


	});
</script>
@stop