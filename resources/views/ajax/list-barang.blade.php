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