@extends('layouts.backend.master')
@section('header')
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
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
                    <a class="btn btn-success" href="{{route('orders.edit.tanggal')}}">Edit Penjualan</a>
               
            </div>
        </div> 
    </div>   
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
        <div class="col-lg-12">
                <div class="ibox float-e-margins">                    
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">                                
                                <div class="col-md-4">
                                    {!!Form::open(['route' =>'orders.index','method' => 'GET','id'=> 'storeFilterForm'])!!}
                                    <div class="input-group">
                                        {!!Form::select('store_id',\App\Store::pluck('name','id')->prepend('Semua Toko',''),old('store_id'),['class' => 'input-sm form-control','id' => 'store'])!!}
                                    {!!Form::close()!!}
                                        </span>
                                    </div>
                                </div>
                            </div>
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
                                    <a href="{{route('order.view',$order)}}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> Lihat</a>
                                    <a href="#" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Ubah</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{$orders->links()}}
                    </div>
                </div>
            </div>
        </div>
	</div>
@stop

@section('footer')   

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
        });        
    </script>
@endsection
