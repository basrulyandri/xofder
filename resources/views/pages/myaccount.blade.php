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
							Umum
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
						<li class="active">
							<a href="{{route('page.myaccount')}}">
							<i class="glyphicon glyphicon-home"></i>
							Profil </a>
						</li>
						<li>
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