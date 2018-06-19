<div class="sub-cate">
		<div class=" top-nav rsidebar span_1_of_left">
			<h3 class="cate">KATEGORI PRODUK</h3>
			<ul class="menu">
			@foreach(categories() as $parent)
			
				<li class="item1" >
					<a href="#">{{$parent->nama}} <span style="float: right;"><i style="margin-right: 5px;" class="fa fa-sort-down"></i></span></a>
					<ul class="cute" @if(isCategoryPage())
					@if(isActiveCategory($kategori->slug,$parent->slug)) style="display:block;" @endif
				@endif>
						@foreach(categories('child',$parent->id) as $child)
							<li class="subitem1"><a href="{{route('page.category',['slug' => $child->slug])}}">{{$child->nama}}</a></li>						
						@endforeach
					</ul>	
				</li>
			@endforeach			
		</div>
		<!--initiate accordion-->
		<script type="text/javascript">
			$(function() {
				var menu_ul = $('.menu > li > ul'),
				menu_a  = $('.menu > li > a');
				menu_ul.hide();
				menu_a.click(function(e) {
					e.preventDefault();
					if(!$(this).hasClass('active')) {
						menu_a.removeClass('active');
						menu_ul.filter(':visible').slideUp('normal');
						$(this).addClass('active').next().stop(true,true).slideDown('normal');
					} else {
						$(this).removeClass('active');
						$(this).next().stop(true,true).slideUp('normal');
					}
				});

			});
		</script>
		<div class=" chain-grid menu-chain">
			<a href="{{route('home')}}"><img class="img-responsive" style="width: 100%" src="{{url('assets/frontend')}}/images/wat.jpg" alt=" " /></a>	   		     		
			<!-- <div class="grid-chain-bottom chain-watch">
				<span class="actual dolor-left-grid">300$</span>
				<span class="reducedfrom">500$</span>  
				<h6><a href="single.html">Lorem ipsum dolor</a></h6>  		     			   		     										
			</div> -->
		</div>		
	</div>