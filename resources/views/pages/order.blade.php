@extends('layouts.frontend.master')
@section('content')

	<div class="row profile">
		<div class="col-md-3">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<img src="{{url('assets/frontend/images')}}/avatar.png" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						{{\Auth::user()->getNameOrEmail()}}
					</div>
					<div class="profile-usertitle-job">
						@if(\Auth::user()->anggota) 
							Anggota Koperasi
						@else
							Non-Anggota Koperasi
						@endif
					</div>
					@if(\Auth::user()->anggota)
					<h4>Saldo eWallet : {{toRp(\Auth::user()->anggota->saldo_ewallet)}}</h4>
					@endif
				</div>
				<!-- END SIDEBAR USER TITLE -->				
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li>
							<a href="{{route('page.myaccount')}}">
							<i class="glyphicon glyphicon-home"></i>
							Profil </a>
						</li>
						<li class="active">
							<a href="{{route('page.myaccount.orders')}}">
							<i class="glyphicon glyphicon-user"></i>
							Order </a>
						</li>						
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>
		<div class="col-md-9">
            <div class="profile-content">
            <div class="row">
            	<div class="col-xs-12">
            		<h3 style="margin: 10px 0 20px 0;padding-bottom: 9px;border-bottom: 1px solid #eee;">
            		<i class="fa fa-shopping-cart"></i> Order No.{{$order->id}} 
            		<small><span class="label label-{{$order->status()}}">{{$order->status()}}</span></small>
            		<small class="pull-right">{{$order->created_at->format('d M Y')}}</small>
            		</h3>
            	</div>
            </div>          
				<table class="table table-hover">
					<thead>
						<tr>
							<th>PRODUCT</th>
							<th>HARGA</th>
							<th>QTY</th>
							<th>SUBTOTAL</th>
						</tr>
					</thead>
					<tbody>						
			   			@foreach($order->cart->items as $key => $item)
							<tr>
								<td>{{$item['item']->name}}</td>
								<td>{{toRp($item['item']->price)}}</td>
								<td>{{$item['qty']}}</td>
								<td>{{toRp($item['item']->price * $item['qty'])}}</td>
							</tr>
			   			@endforeach
					</tbody>
				</table>	
				<div class="row">
					<div class="col-xs-12">
						<h3 class="pull-right">Total : {{toRp($order->cart->totalPrice)}}</h3>
					</div>
				</div>
            </div>
		</div>
	</div>
@include('layouts.frontend.footer')
@stop

@section('footer')
<script>
	$(document).ready(function(){	
		
	});
</script>
@stop