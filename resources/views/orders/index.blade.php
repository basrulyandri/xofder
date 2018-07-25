@extends('layouts.backend.master')
@section('header')
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/backend/css/plugins/datapicker/datepicker3.css')}}">
@endsection
@section('title')
  Daftar Penjualan
@stop

@section('content')  
    <div class="row wrapper border-bottom white-bg page-heading">	
        <div class="col-sm-4">
            <h2>Penjualan</h2>
            <ol class="breadcrumb">
                <li class="active">
                    <a href="{{route('orders.index')}}">Penjualan</a>
                </li>                
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">                  
                    <a class="btn btn-warning" href="{{route('orders.edit.tanggal')}}">Edit Penjualan</a>
                    <a class="btn btn-success" data-toggle="modal" href='#modalPilihTanggal'><i class="fa fa-calendar"></i> Tanggal</a>
                     <a href="{{route('orders.index')}}" class="btn btn-info"><i class="fa fa-refresh"></i> Reset</a>
            </div>
        </div> 
    </div>   
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
        <div class="col-lg-12">
                <div class="ibox float-e-margins">                    
                    <div class="ibox-content">
                        
                        <table class="table table-striped" id="datatables">
                            <thead>
                            <tr>
                                <th>NO</th>
                                <th>TANGGAL</th>
                                <th>QTY</th>                                                                
                                <th>HARGA</th>                                                              
                                <th>PEMBAYARAN</th> 
                                <th>STATUS</th>                                
                                <th>KASIR</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>                            
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->created_at->format('d M Y')}}</td>          
                                <td>{{$order->total_qty}}</td>                           
                                <td>{{toRp($order->total_price)}}</td>
                                <td>{{$order->payment_method}}</td>
                                <td><span class="label @if($order->status == 'lunas') label-primary @else label-danger @endif">{{strtoupper($order->status)}}</span></td>                                
                                <td>{{$order->kasir->username}} <small>({{$order->kasir->store->name}})</small> </td>                                
                                <td class="text-navy">                                    
                                    <button type="button" class="btn btn-xs btn-info openModalDetailOrder" orderId="{{$order->id}}" data-url="{{route('ajax.order.view',$order)}}">
                                      Lihat
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            @if(\Request::has('start_date') && \Request::has('end_date'))
                            <tr>
                                <td></td>
                                <td></td>
                                <td><strong>{{$totalQty}}</strong></td>
                                <td><strong>{{toRp($totalPrice)}}</strong></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            </tbody>
                        </table>
                        @if(!\Request::has('start_date') && !\Request::has('end_date'))
                        {{$orders->links()}}
                        @endif
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

    <!-- Modal -->
<div class="modal fade" id="modalDetailOrder" tabindex="-1" role="dialog" aria-labelledby="modalDetailOrderLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 90%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Penjualan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body order-modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        
      </div>
    </div>
  </div>
</div>
@stop

@section('footer')   
<script src="{{asset('assets/backend/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script>
        $(document).ready(function() {
            $("#store" ).change(function() {
              $('#storeFilterForm').submit();
            });
            $('body').on('click','.btn-danger',function(){
                //alert('test');
                var id = $(this).attr('id');
                swal({
                  title:'SURE ?',
                   text: "Want to delete this permission ?",
                   type: "warning",
                   showCancelButton: true,
                   confirmButtonColor: "#DD6B55",
                   confirmButtonText: "Yes, delete it!",
                   closeOnConfirm: true,
                },function(isConfirm){
                  if (isConfirm) {
                    window.location = "permission/"+id+"/delete";
                  }
                });
              });

            $('.openModalDetailOrder').click(function(){
                var url = $(this).attr('data-url'); 
                console.log(url) 
                $('.order-modal-body').load(url,function(){                    
                    $('#modalDetailOrder').modal({show:true});
                });              
                
            });   
            $('.tanggal').datepicker({
                format : 'yyyy-mm-dd',                
                todayBtn: "linked",                
                autoclose: true
            });
        });        
    </script>
@endsection
