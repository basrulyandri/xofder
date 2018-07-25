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
                <a class="btn btn-success" data-toggle="modal" href='#modalPilihTanggal'><i class="fa fa-calendar"></i> Tanggal</a>               
            </div>
        </div> 
    </div>   
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="alert alert-info" role="alert">
            @if(\Request::has('start_date') && \Request::has('end_date'))
                Riwayat barang dari tanggal <span class="label label-warning">{{\Carbon\Carbon::parse(\Request::input('start_date'))->format('d M Y')}} s.d {{\Carbon\Carbon::parse(\Request::input('end_date'))->format('d M Y')}}</span>
            @else
                Riwayat Barang pada <span class="label label-warning">7 hari Terakhir</span>. 
            @endif

            Untuk rentang waktu lain klik tombol <a class="btn btn-xs btn-success" data-toggle="modal" href='#modalPilihTanggal'><i class="fa fa-calendar"></i> Tanggal</a> 

            @if(\Request::has('start_date') && \Request::has('end_date'))
                <a href="{{route('product.view',$product)}}" class="btn btn-xs btn-warning">Reset</a>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-7">
               <div class="ibox float-e-margins">  
                  <div class="ibox-title">
                    <h5>Riwayat Stock</h5>
                    <div class="ibox-tools">                
                        <h5>Stock Tersedia : {{$product->available_stocks}} pcs</h5>
                    </div>
                  </div>                  
                    <div class="ibox-content">
                        <table class="table table-striped" id="datatables">
                            <thead>
                           <tr>
                                <th>NO</th>
                                <th>TANGGAL</th>
                                <th>STOCK MASUK</th>  
                                <th>STOCK KELUAR</th>                              
                                <th>USER</th>                                                              
                                <th>DARI/KE</th>                                
                                <th>CATATAN</th>                                 
                            </tr>
                            </thead>
                            <tbody>                           
                                <?php $i = 1 ?>
                                @foreach($stocks as $stock)
                                <tr>
                                   <td>{{$i}}</td>
                                    <td>{{$stock->tanggal->format('d M Y')}}</td>
                                    <td>{{$stock->stock_in}}</td>
                                    <td>{{$stock->stock_out}}</td>                                
                                    <td>{{$stock->user->username}}</td>
                                    <td>{{$stock->supplier->name}}</td>
                                    <td>{{$stock->description}}</td>  
                                </tr>
                                <?php $i++;?>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL</strong></td>                                    
                                    <td><strong>{{$totalStockIn}}</strong></td>
                                    <td><strong>{{$totalStockOut}}</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>                            
                            </tbody>
                            <tfoot>
                                
                                <tr></tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-lg-5">
               <div class="ibox float-e-margins">  
                  <div class="ibox-title">
                    <h5>Riwayat Penjualan {{strtoupper($product->name)}}</h5>                    
                  </div>                  
                    <div class="ibox-content">

                        <table class="table table-striped" id="datatables">
                            <thead>
                            <tr>
                                <th>NO</th>
                                <th>TANGGAL</th>
                                <th>NO ORDER</th>                                
                                <th>QTY</th>                                                              
                                <th>CUSTOMER</th>  
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1 ?>

                            @foreach($productSoldLog as $item)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$item->created_at->format('d M Y')}}</td>
                                <td><a class="openModalDetailOrder" data-url="{{route('ajax.order.view',$item->order_id)}}"> {{$item->order_id}}</a>
                                </td>                                
                                <td>{{$item->qty}}</td>
                                <td>{{$item->order->customer->name}}</td>                               
                            </tr>
                            <?php $i++;?>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td><strong>TOTAL</strong></td>
                                <td><strong>{{$totalProductSold}}</strong></td>
                                <td></td>
                            </tr>
                            </tbody>                           
                        </table>                        
                    </div>
                    
                </div>
            </div>

        </div>
	</div>

<!-- Modal pilih tanggal -->
<div class="modal fade" id="modalPilihTanggal" tabindex="-1" role="dialog" aria-labelledby="modalPilihTanggalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPilihTanggalLabel">Pilih rentang waktu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="row">            
            <div class="col-lg-12">
            {!!Form::open(['method'=>'GET', 'class' => 'form-horizontal'])!!}

                <div class='form-group{{$errors->has('start_date') ? ' has-error' : ''}}'>
                  {!!Form::label('start_date','Tanggal Mulai',['class' => 'col-sm-2 control-label'])!!}
                  <div class="col-sm-10">
                    {!!Form::text('start_date',old('start_date'),['class' => 'form-control tanggal','placeholder' => 'Tanggal','required' => 'true'])!!}
                    @if($errors->has('start_date'))
                      <span class="help-block">{{$errors->first('start_date')}}</span>
                    @endif
                  </div>
                </div>

                <div class='form-group{{$errors->has('end_date') ? ' has-error' : ''}}'>
                  {!!Form::label('end_date','Tanggal Akhir',['class' => 'col-sm-2 control-label'])!!}
                  <div class="col-sm-10">
                    {!!Form::text('end_date',old('end_date'),['class' => 'form-control tanggal','placeholder' => 'Tanggal','required' => 'true'])!!}
                    @if($errors->has('end_date'))
                      <span class="help-block">{{$errors->first('end_date')}}</span>
                    @endif
                  </div>
                </div>           
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-success" value="OK">
        {{Form::close()}}
      </div>
    </div>
  </div>
</div>
<!-- End Modal pilih tanggal -->


    
<!-- Modal Detail penjualan -->
    <div class="modal fade" id="modalDetailOrder" tabindex="-1" role="dialog" aria-labelledby="modalDetailOrderLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 90%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Penjualan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bodyDetailOrder">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        
      </div>
    </div>
  </div>
</div>
<!-- End modal detail penjualan -->
@stop

@section('footer')
<script src="{{asset('assets/backend/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('cashier/js')}}//select2.min.js"></script>
<script>
    $(document).ready(function(){
          $('#suppliers').select2();
          $('.tanggal').datepicker({
                format : 'yyyy-mm-dd',                
                todayBtn: "linked",                
                autoclose: true
            });
          $('.openModalDetailOrder').click(function(){
                var url = $(this).attr('data-url'); 
                console.log(url) 
                $('.bodyDetailOrder').load(url,function(){                    
                    $('#modalDetailOrder').modal({show:true});
                });              
                
            });
          
    });
</script>
@endsection
