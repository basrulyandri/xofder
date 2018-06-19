@extends('layouts.backend.master')
@section('header')
    
@endsection
@section('title')
  Tambah Data Barang
@stop

@section('content')  
    <div class="row wrapper border-bottom white-bg page-heading">	
        <div class="col-sm-4">
            <h2>Ubah Data Barang</h2>
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
                {!!Form::open(['route' =>['post.product.update',$product], 'class' => 'form-horizontal'])!!}
                    <div class='form-group{{$errors->has('code') ? ' has-error' : ''}}'>
                      {!!Form::label('code','Kode',['class' => 'col-sm-2 control-label'])!!}
                      <div class="col-sm-10">
                        {!!Form::text('code',$product->code,['class' => 'form-control','placeholder' => 'Kode','required' => 'true','autofocus'])!!}
                        @if($errors->has('code'))
                          <span class="help-block">{{$errors->first('code')}}</span>
                        @endif
                      </div>
                    </div>

                    <div class='form-group{{$errors->has('name') ? ' has-error' : ''}}'>
                      {!!Form::label('name','Nama Barang',['class' => 'col-sm-2 control-label'])!!}
                      <div class="col-sm-10">
                        {!!Form::text('name',$product->name,['class' => 'form-control','placeholder' => 'Nama Barang','required' => 'true'])!!}
                        @if($errors->has('name'))
                          <span class="help-block">{{$errors->first('name')}}</span>
                        @endif
                      </div>
                    </div>

                    <div class='form-group{{$errors->has('category_id') ? ' has-error' : ''}}'>
                      {!!Form::label('category_id','Kategori',['class' => 'col-sm-2 control-label'])!!}
                      <div class="col-sm-10">
                        {!!Form::select('category_id',\App\Category::pluck('name','id')->prepend('Pilih kategori',''),$product->category_id,['class' => 'form-control'])!!}
                        @if($errors->has('category_id'))
                          <span class="help-block">{{$errors->first('category_id')}}</span>
                        @endif
                      </div>
                    </div>

                    <div class='form-group{{$errors->has('sell_price') ? ' has-error' : ''}}'>
                      {!!Form::label('sell_price','Harga Jual',['class' => 'col-sm-2 control-label'])!!}
                      <div class="col-sm-10">
                        {!!Form::text('sell_price',$product->sell_price,['class' => 'form-control uang','placeholder' => 'Harga Jual','required' => 'true'])!!}
                        @if($errors->has('sell_price'))
                          <span class="help-block">{{$errors->first('sell_price')}}</span>
                        @endif
                      </div>
                    </div>

                    <div class='form-group{{$errors->has('description') ? ' has-error' : ''}}'>
                      {!!Form::label('description','Deskripsi',['class' => 'col-sm-2 control-label'])!!}
                      <div class="col-sm-10">
                        {!!Form::text('description',$product->description,['class' => 'form-control','placeholder' => 'Deskripsi'])!!}
                        @if($errors->has('description'))
                          <span class="help-block">{{$errors->first('description')}}</span>
                        @endif
                      </div>
                    </div>

                    <div class="form-group text-right">
                    <div class="col-sm-12">
                        <input type="submit" class="btn btn-info" value="Simpan">
                    </div>
                    </div>
                {!!Form::close()!!}
            </div>
        </div>
	</div>
@stop

@section('footer')
   <script src="{{url('assets/backend')}}/js/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
   <script>
    $(document).ready(function() {    
        $('.uang').inputmask({
                  'alias': 'numeric', 
                  'radixPoint': ',',
                  'groupSeparator': '.',
                  'autoGroup': true,
                  'digits': 0,
                  'digitsOptional': false,
                  'prefix': 'Rp ',
                  'placeholder': '0',
                  'removeMaskOnSubmit':true,
                  'rightAlign': false
                });
        $('#lanjut-ke-step2').click(function(){     
            $('#step1').slideUp();
            $('#step2').slideDown();
        });
    });
</script>
@endsection
