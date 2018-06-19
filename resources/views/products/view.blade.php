@extends('layouts.backend.master')
@section('header')
    <link rel="stylesheet" href="{{asset('cashier/css')}}/select2.min.css">
    <link rel="stylesheet" href="{{asset('assets/backend/css/plugins/datapicker/datepicker3.css')}}">
@endsection
@section('title')
  Detail Barang {{$product->name}}
@stop

@section('content')  
    <div class="row wrapper border-bottom white-bg page-heading">	
        <div class="col-sm-4">
            <h2>Detail Barang <b>{{$product->name}}</b></h2>
            <ol class="breadcrumb">
                <li class="active">
                    <a href="{{route('products.index')}}">Barang</a>
                </li>                
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">                        
                <a class="btn btn-success" data-toggle="modal" href='#tambahStock'><i class="fa fa-plus"></i> Tambah Stock</a>               
            </div>
        </div> 
    </div>   
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
               <div class="ibox float-e-margins">  
                  <div class="ibox-title">
                    <h5>Riwayat Stock</h5>
                    <div class="ibox-tools">                
                        <h5>Stock Tersedia : {{$product->availableStocks()}} pcs</h5>
                    </div>
                  </div>                  
                    <div class="ibox-content">

                        <table class="table table-striped" id="datatables">
                            <thead>
                            <tr>
                                <th>NO</th>
                                <th>TANGGAL</th>
                                <th>STOCK MASUK</th>                                
                                <th>USER</th>                                                              
                                <th>DARI</th>                                
                                <th>CATATAN</th> 
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = ($stocks->currentPage() - 1) * $stocks->perPage() + 1; ?>
                            @foreach($stocks as $stock)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$stock->tanggal->format('d M Y')}}</td>
                                <td>{{$stock->stock_in}}</td>                                
                                <td>{{$stock->user->username}}</td>
                                <td>{{stockFrom($stock)}}</td>
                                <td>{{$stock->description}}</td>                                
                                <td class="text-navy">
                                    <a href="{{route('product.edit.stock',$stock)}}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{route('stock.delete',$stock->id)}}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                                    <!-- <button id="" class='btn btn-danger'>Delete</button> -->
                                </td>
                            </tr>
                            <?php $i++;?>
                            @endforeach
                            </tbody>
                        </table>

                        {{$stocks->links()}}
                    </div>
                </div>
            </div>
        </div>
	</div>


    <div class="modal fade" id="tambahStock">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Tambah Stock {{$product->name}}</h4>
                </div>
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">                                
                    <input type="submit" class="btn btn-primary">
                    {!!Form::close()!!}    
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
