@extends('layouts.kasir.master')
@section('header')
    
@stop
@section('content')
<div class="row">
            <div class="col-lg-7">
               <div class="ibox float-e-margins">  
                  <div class="ibox-title">
                    <h5>Riwayat Stock {{strtoupper($product->name)}}</h5>
                    <div class="ibox-tools">                
                        <h5>Stock Tersedia : {{$product->storeAvailableStocks()}} pcs</h5>
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
                                <th>ACTION</th>
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
                                <td class="text-navy">
                                    @if($stock->created_at->isToday())                                    
                                        <button id="{{$stock->id}}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                    @endif
                                    <!-- <button id="" class='btn btn-danger'>Delete</button> -->
                                </td>
                            </tr>
                            <?php $i++;?>
                            @endforeach
                            </tbody>                           
                        </table>                        
                        <a href="#" class="btn btn-primary btn-block m-t"><i class="fa fa-arrow-down"></i> Lihat semua riwayat stock</a>
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

                            @foreach($product->ordersItem()->limit(20)->get() as $item)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$item->created_at->format('d M Y')}}</td>
                                <td>{{$item->order_id}}</td>                                
                                <td>{{$item->qty}}</td>
                                <td>{{$item->order->customer->name}}</td>                               
                            </tr>
                            <?php $i++;?>
                            @endforeach
                            </tbody>                           
                        </table>                        
                        <a href="#" class="btn btn-primary btn-block m-t"><i class="fa fa-arrow-down"></i> Lihat semua penjualan {{strtoupper($product->name)}}</a>
                    </div>
                    
                </div>
            </div>
        </div>
@stop

@section('footer')
    <script>
    $(document).ready(function(){
        $('body').on('click','.btn-danger',function(){
                //alert('test');
                var id = $(this).attr('id');
                swal({
                  title:'Yakin ?',
                   text: "Mau Hapus Penjualan ini ?",
                   type: "warning",
                   showCancelButton: true,
                   confirmButtonColor: "#DD6B55",
                   confirmButtonText: "Yes, delete it!",
                   closeOnConfirm: true,
                },function(isConfirm){
                  if (isConfirm) {
                    window.location = "{{url('/')}}/kasir/stock/"+id+"/delete";
                  }
                });
              });   
    });
</script>
@stop