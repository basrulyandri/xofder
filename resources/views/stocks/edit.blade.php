@extends('layouts.backend.master')
@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('assets/backend/css/plugins/datapicker/datepicker3.css')}}">

@endsection
@section('title')
  Edit Stock {{$stock->product->name}}
@stop

@section('content')  
    <div class="row wrapper border-bottom white-bg page-heading">	
        <div class="col-sm-4">
            <h2>Edit Stock <b>{{$stock->product->name}}</b></h2>
            <ol class="breadcrumb">
                <li class="active">
                    <a href="{{route('products.index')}}">Barang</a>
                </li>                
            </ol>
        </div>
        <div class="col-sm-8">
            
        </div> 
    </div>   
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
               <div class="ibox float-e-margins">                    
                    <div class="ibox-content">
					{!!Form::open(['route' =>['product.update.stock',$stock], 'class' => 'form-horizontal',])!!}

                        <div class='form-group{{$errors->has('tanggal') ? ' has-error' : ''}}'>
                          {!!Form::label('tanggal','tanggal',['class' => 'col-sm-2 control-label'])!!}
                          <div class="col-sm-10">
                            {!!Form::text('tanggal',$stock->tanggal->format('Y-m-d'),['class' => 'form-control','placeholder' => 'tanggal','required' => 'true'])!!}
                            @if($errors->has('tanggal'))
                              <span class="help-block">{{$errors->first('tanggal')}}</span>
                            @endif
                          </div>
                        </div>
						<div class='form-group{{$errors->has('stock_in') ? ' has-error' : ''}}'>
						  {!!Form::label('stock_in','Jumlah stock Masuk',['class' => 'col-sm-2 control-label'])!!}
						  <div class="col-sm-10">
						    {!!Form::input('number','stock_in',$stock->stock_in,['class' => 'form-control','placeholder' => 'Jumlah stock Masuk','required' => 'true'])!!}
						    @if($errors->has('stock_in'))
						      <span class="help-block">{{$errors->first('stock_in')}}</span>
						    @endif
						  </div>
						</div>

                        <div class='form-group{{$errors->has('supplier_id') ? ' has-error' : ''}}'>
                          {!!Form::label('stock_from_id','Supplier',['class' => 'col-sm-2 control-label'])!!}
                          <div class="col-sm-10">
                            <select name="stock_from_id" id="suppliers" class="form-control">
                                @foreach($suppliers as $key => $supplier)
                                <option value="{{ $key }}"  {{$key == $stock->stock_from_id ? 'selected': ''}}>{{ $supplier }}</option>
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
            </div>
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
