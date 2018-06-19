@extends('layouts.frontend.master')
@section('header')
<link rel="stylesheet" href="{{url('assets/frontend')}}/css/etalage.css" type="text/css" media="all" />
@stop
@section('content')
<div class=" single_top">
	      <div class="single_grid">
				<div class="grid images_3_of_2">
						<ul id="etalage">						
							@if(!$product->images->isEmpty())
								@foreach($product->images as $image)
								<li>
									<a href="#">
										<img class="etalage_thumb_image" src="{{url('uploads/produk')}}/{{$image->title}}" class="img-responsive" />
										<img class="etalage_source_image" src="{{url('uploads/produk')}}/{{$image->title}}" class="img-responsive" title="" />
									</a>
								</li>	
								@endforeach
							@else
								<li>
									<a href="#">
										<img class="etalage_thumb_image" src="{{url('assets/frontend').'/images/no-image.jpg'}}" class="img-responsive" />
										<img class="etalage_source_image" src="{{url('assets/frontend').'/images/no-image.jpg'}}" class="img-responsive" title="" />
									</a>
								</li>
							@endif

						</ul>
						 <div class="clearfix"> </div>		
				  </div> 
				  <div class="desc1 span_3_of_2">
				  
					
					<h4>{{$product->name}}</h4>
				<div class="cart-b">
					<div class="left-n ">{{toRp($product->price)}}</div>				    
				    <a class="now-get get-cart-in" product-id="{{$product->id}}" style="cursor: pointer;">BELI</a> 
				    <div class="clearfix"></div>
				 </div>
				 
			   	<p>{{$product->description}}</p>
			   	<div class="share">
							<h5>Share Product :</h5>
							<ul class="share_nav">
								<li><a href="#"><img src="{{url('assets/frontend')}}/images/facebook.png" title="facebook"></a></li>
								<li><a href="#"><img src="{{url('assets/frontend')}}/images/twitter.png" title="Twiiter"></a></li>
								<li><a href="#"><img src="{{url('assets/frontend')}}/images/rss.png" title="Rss"></a></li>
								<li><a href="#"><img src="{{url('assets/frontend')}}/images/gpluse.png" title="Google+"></a></li>
				    		</ul>
						</div>
			   
				
				</div>
          	    <div class="clearfix"> </div>
          	   </div>
          	    	<div class="toogle">
				     	<h3 class="m_3">DESKRIPSI</h3>
				     	<p class="m_text">{{$product->description}}</p>
				     </div>	
          	   </div>
          	@include('layouts.frontend.sidebar')
          	@include('layouts.frontend.footer')
          	@stop
@section('footer')
<script type="text/javascript" src="{{url('assets/frontend')}}/js/jquery.flexisel.js"></script>
<script src="{{url('assets/frontend')}}/js/jquery.etalage.min.js"></script>
<script>
			$(document).ready(function($){

				$('#etalage').etalage({
					thumb_image_width: 300,
					thumb_image_height: 400,
					source_image_width: 900,
					source_image_height: 1200,
					show_hint: true,
					click_callback: function(image_anchor, instance_id){
						alert('Callback example:\nYou clicked on an image with the anchor: "'+image_anchor+'"\n(in Etalage instance: "'+instance_id+'")');
					}
				});

				$("#flexiselDemo1").flexisel({
				visibleItems: 5,
				animationSpeed: 1000,
				autoPlay: true,
				autoPlaySpeed: 3000,    		
				pauseOnHover: true,
				enableResponsiveBreakpoints: true,
		    	responsiveBreakpoints: { 
		    		portrait: { 
		    			changePoint:480,
		    			visibleItems: 1
		    		}, 
		    		landscape: { 
		    			changePoint:640,
		    			visibleItems: 2
		    		},
		    		tablet: { 
		    			changePoint:768,
		    			visibleItems: 3
		    		}
		    	}
		    });

				$('.get-cart-in').click(function(){
					var btn = $(this);
					btn.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
					var product_id = btn.attr('product-id');
					var _token = '{{Session::token()}}';
					$.ajax({
					  type: "POST",
					  url: "{{route('ajax.post.addtocart')}}",
					  data: { product_id : product_id, _token:_token },
					}).success(function(data){
						$('#cartInfo').text(data['cart'].totalQty)
						btn.html('BELI');
						toastr.success('Berhasil','Produk berhasil dimasukkan ke keranjang');
						console.log(data['cart'].totalQty);
					});
				});

			});
		</script>
@stop