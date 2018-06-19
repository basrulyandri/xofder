@extends('layouts.kasir.master')
@section('header')
	<link rel="stylesheet" href="{{asset('assets/backend/css/plugins/datapicker/datepicker3.css')}}">
@stop
@section('content')
<div class="row">
            <div class="alert alert-warning">              
              <strong>Catatan ! </strong> Stock ini otomatis akan dimasukkan ke dalam stock Toko Blok F
            </div>
            <div class="col-lg-12">
            {!!Form::open(['route' =>'post.product.addstock', 'class' => 'form-horizontal'])!!}
            <input type="hidden" name="product_id" value="{{$product->id}}">

            <div class='form-group{{$errors->has('tanggal') ? ' has-error' : ''}}'>
              {!!Form::label('tanggal','Tanggal',['class' => 'col-sm-2 control-label'])!!}
              <div class="col-sm-10">
                {!!Form::text('tanggal',\Carbon\carbon::now()->format('Y-m-d'),['class' => 'form-control','placeholder' => 'Tanggal','required' => 'true','id' => 'tanggal'])!!}
                @if($errors->has('tanggal'))
                  <span class="help-block">{{$errors->first('tanggal')}}</span>
                @endif
              </div>
            </div>
            <div class='form-group{{$errors->has('stock_in') ? ' has-error' : ''}}'>
              {!!Form::label('stock_in','Jumlah Stock Masuk',['class' => 'col-sm-2 control-label'])!!}
              <div class="col-sm-10">
                {!!Form::input('number','stock_in',old('stock_in'),['class' => 'form-control','placeholder' => 'Jumlah Stock Masuk','required' => 'true'])!!}
                @if($errors->has('stock_in'))
                  <span class="help-block">{{$errors->first('stock_in')}}</span>
                @endif
              </div>
            </div>
            <div class='form-group{{$errors->has('supplier_id') ? ' has-error' : ''}}'>
              {!!Form::label('stock_from_id','Supplier',['class' => 'col-sm-2 control-label'])!!}
              <div class="col-sm-10">
                <select name="stock_from_id" id="suppliers" class="form-control" style="width:100%;">
                    @foreach($suppliers as $key => $supplier)
                    <option value="{{ $key }}">{{ $supplier }}</option>
                    @endforeach
                </select>
                @if($errors->has('supplier_id'))
                  <span class="help-block">{{$errors->first('supplier_id')}}</span>
                @endif
              </div>
            </div>   

            <div class='form-group{{$errors->has('description') ? ' has-error' : ''}}'>
                       {!!Form::label('description','Catatan',['class' => 'col-sm-2 control-label'])!!}
                       <div class="col-sm-10">
                         {!!Form::textarea('description',old('description'),['class' => 'form-control','placeholder' => 'Catatan'])!!}
                         @if($errors->has('description'))
                           <span class="help-block">{{$errors->first('description')}}</span>
                         @endif
                       </div>
                     </div>         
            <input type="submit" class="btn btn-info" value="Simpan">
            {!!Form::close()!!}    
            </div>
        </div>
@stop

@section('footer')
<script src="{{asset('assets/backend/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('cashier/js')}}//select2.min.js"></script>
<script>
    $(document).ready(function(){
          $('#suppliers').select2();
          $('#tanggal').datepicker({
                format : 'yyyy-mm-dd',                
                todayBtn: "linked",                
                autoclose: true
            });
    });
</script>
@endsection
