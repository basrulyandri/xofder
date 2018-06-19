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
				<table class="table table-hover">
					<thead>
						<tr>
							<th>NO</th>
							<th>TGL</th>
							<th>QTY</th>
							<th>TOTAL HARGA</th>
							<th>PEMBAYARAN</th>
							<th>STATUS</th>
							<th>ACTION</th>
						</tr>
					</thead>
					<tbody>
			   			@foreach($orders as $order)
						<tr>
							<td>{{$order->id}}</td>
							<td>{{$order->created_at->format('d M Y')}}</td>
							<td>{{$order->cart->totalQty}}</td>
							<td>{{toRp($order->cart->totalPrice)}}</td>
							<td>{{$order->payment_method}}</td>
							<td><span class="label label-{{$order->status()}}">{{$order->status()}}</span></td>
							<td>
								<a href="{{route('page.order.view',['order' => $order])}}" class="btn btn-xs btn-info">Lihat</a>
								@if($order->status == 'dipesan')
								<a data-toggle="modal" href='#konfirmasiPembayaran' class="btn btn-xs btn-info konfirmasiPembayaran" order_id="{{$order->id}}" total-price="{{$order->cart->totalPrice}}">Konfirmasi pembayaran</a>
								@endif
							</td>
						</tr>
			   			@endforeach
					</tbody>
				</table>	
				{{$orders->links()}}
            </div>
		</div>
	</div>	
	<div class="modal fade" id="konfirmasiPembayaran">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Konfirmasi Pembayaran</h4>
				</div>
				<div class="modal-body">
					{!!Form::open(['class' => 'form-horizontal','route' => 'post.konfirmasi.pembayaran','enctype' => 'multipart/form-data'])!!}
					<input type="hidden" name="order_id" value="">
					<div class='form-group{{$errors->has('tanggal') ? ' has-error' : ''}}'>
					  {!!Form::label('tanggal','Tanggal Bayar',['class' => 'col-sm-2 control-label'])!!}
					  <div class="col-sm-10">
					    {!!Form::input('date','tanggal',old('tanggal'),['class' => 'form-control','placeholder' => 'Tanggal Bayar','required' => 'true','pattern' => '[0-9]{4}-[0-9]{2}-[0-9]{2}'])!!}
					    @if($errors->has('tanggal'))
					      <span class="help-block">{{$errors->first('tanggal')}}</span>
					    @endif
					  </div>
					</div>

					<div class='form-group{{$errors->has('rekening') ? ' has-error' : ''}}'>
					  {!!Form::label('rekening_id','Rekening Tujuan',['class' => 'col-sm-2 control-label'])!!}
					  <div class="col-sm-10">
					    {!!Form::select('rekening_id',['1' => 'BSM 7790000077 a.n Koperasi Maslahat Untuk Negeri'],old('rekening_id'),['class' => 'form-control'])!!}
					    @if($errors->has('rekening_id'))
					      <span class="help-block">{{$errors->first('rekening_id')}}</span>
					    @endif
					  </div>
					</div>

					<div class='form-group{{$errors->has('nominal') ? ' has-error' : ''}}'>
					  {!!Form::label('nominal','Nominal',['class' => 'col-sm-2 control-label'])!!}
					  <div class="col-sm-10">
					    {!!Form::input('number','nominal',old('nominal'),['class' => 'form-control','placeholder' => 'Nominal','required' => 'true'])!!}
					    @if($errors->has('nominal'))
					      <span class="help-block">{{$errors->first('nominal')}}</span>
					    @endif
					  </div>
					</div>
					<div class='form-group{{$errors->has('bank_pengirim') ? ' has-error' : ''}}'>
					  {!!Form::label('bank_pengirim','Bank Pengirim',['class' => 'col-sm-2 control-label'])!!}
					  <div class="col-sm-10">
					    {!!Form::text('bank_pengirim',old('bank_pengirim'),['class' => 'form-control','placeholder' => 'Dari Bank','required' => 'true'])!!}
					    @if($errors->has('bank_pengirim'))
					      <span class="help-block">{{$errors->first('bank_pengirim')}}</span>
					    @endif
					  </div>
					</div>
					<div class='form-group{{$errors->has('no_rekening_pengirim') ? ' has-error' : ''}}'>
					  {!!Form::label('no_rekening_pengirim','No.Rekening Pengirim',['class' => 'col-sm-2 control-label'])!!}
					  <div class="col-sm-10">
					    {!!Form::text('no_rekening_pengirim',old('no_rekening_pengirim'),['class' => 'form-control','placeholder' => 'No.Rekening','required' => 'true'])!!}
					    @if($errors->has('no_rekening_pengirim'))
					      <span class="help-block">{{$errors->first('no_rekening_pengirim')}}</span>
					    @endif
					  </div>
					</div>

					<div class='form-group{{$errors->has('nama_pengirim') ? ' has-error' : ''}}'>
					  {!!Form::label('nama_pengirim','Nama Pemilik Rekening',['class' => 'col-sm-2 control-label'])!!}
					  <div class="col-sm-10">
					    {!!Form::text('nama_pengirim',old('nama_pengirim'),['class' => 'form-control','placeholder' => 'Nama Pemilik Rekening','required' => 'true'])!!}
					    @if($errors->has('nama_pengirim'))
					      <span class="help-block">{{$errors->first('nama_pengirim')}}</span>
					    @endif
					  </div>
					</div>
					<div class='form-group{{$errors->has('file') ? ' has-error' : ''}}'>
					  {!!Form::label('file','Bukti Pembayaran',['class' => 'col-sm-2 control-label'])!!}
					  <div class="col-sm-10">
					    {!!Form::input('file','file',old('file'),['class' => 'form-control','placeholder' => 'Bukti Pembayaran','required' => 'true'])!!}
					    @if($errors->has('file'))
					      <span class="help-block">{{$errors->first('file')}}</span>
					    @endif
					  </div>
					</div>
				</div>
				<div class="modal-footer">					
					<input type="submit" class="btn btn-primary">
					{!!Form::close()!!}
				</div>
			</div>
		</div>
	</div>
@include('layouts.frontend.footer')
@stop

@section('footer')
<script src="{{url('assets/frontend/js')}}/bootstrap.js"></script>
<script>
	$(document).ready(function(){	
		$('.konfirmasiPembayaran').click(function(){
			$('input[name="order_id"]').val($(this).attr('order_id'));			
			$('input[name="nominal"]').val($(this).attr('total-price'));			
		});		
	});
</script>
@stop