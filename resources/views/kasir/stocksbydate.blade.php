@extends('layouts.kasir.master')
@section('header')
    <link href="{{asset('assets/backend')}}/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="{{asset('assets/backend')}}/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
@stop
@section('content')
<div class="row">
    <div class="col-lg-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-info-circle"></i> Stock Masuk
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <a class="list-group-item" href="{{route('kasir.stocks.index')}}">Stock Tiap Barang</a>
                    <a class="list-group-item active" href="{{route('kasir.stocks.bydate')}}">Stock Masuk Berdasarkan tanggal</a>
                </div>
            </div>

        </div>
    </div>
        <div class="col-lg-9">
                <div class="ibox" style="margin-bottom: 0;">     
                	<div class="ibox-title">
                		<h5>Stock Barang masuk berdasarkan tanggal</h5>
                        <div class="ibox-tools">
                        <form method="GET" id="formTanggal">
                            <input type="text" placeholder="Tanggal" id="tanggal" name="tanggal" class="form-control" style="height: 25px;" value="{{\Request::input('tanggal')}}">
                        </form>
                        </div>
                        
                            
                        </div>
                	</div>               
                    <div class="ibox-content">

                        <table class="table table-striped" id="datatables">
                            <thead>
                            <tr>
                                <th>NO</th>
                                <th>TANGGAL</th>
                                <th>BARANG</th> 
                                <th>STOCK MASUK</th>                                                              
                                <th>DARI</th> 
                                <th>USER</th>                                
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = ($stocks->currentpage()-1) * $stocks->perpage() + 1;?>
                            @foreach($stocks as $stock)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$stock->tanggal->format('d M Y')}}</td>             
                                <td><a href="{{route('kasir.stock.product.view',$stock->product)}}">{{$stock->product->name}}</a></td>
                                <td>{{$stock->stock_in}}</td>
                                <td>{{$stock->supplier->name}}</td>
                                <td>{{$stock->user->username}}</td>                             
                                <td class="text-navy">
                                    @if($stock->created_at->isToday())                                    
                                        <button id="{{$stock->id}}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                    @endif
                                </td>
                            </tr>
                            <?php $i++;?>
                            @endforeach
                            </tbody>
                        </table>
                        {{$stocks->appends(['tanggal' => \Request::input('tanggal')])->links()}}
                       
                    </div>
                </div>
            </div>
        
@stop

@section('footer')
    <script src="{{asset('assets//backend')}}/js/plugins/datapicker/bootstrap-datepicker.js"></script>
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

              $('#tanggal').datepicker({format:"yyyy-mm-dd"}).on('changeDate',function(e){
                $('#formTanggal').submit();
                console.log(e);
              }); 
        // $('#tanggal').change(function(){
        //     alert(0);
        // });
    });
</script>
@stop   