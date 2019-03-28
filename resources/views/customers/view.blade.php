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
            <h2>Detail customer {{$customer->name}}</h2>
            
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
                            
                            </tbody>
                        </table>  
                        @if($customer->id == 1)
                              {{$orders->links()}}
                            @endif                     
                    </div>
                </div>
            </div>
        </div>
	</div>

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
