@extends('layouts.kasir.master')
@section('header')
	 <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
@stop
@section('content')
<div class="row">
    <div class="col-lg-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-info-circle"></i> Manajemen Stock 
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <a class="list-group-item active" href="{{route('kasir.stocks.index')}}">Stock Tiap Barang</a>
                    <a class="list-group-item" href="{{route('kasir.stocks.bydate')}}">Riwayat Stock Berdasarkan tanggal</a>
                </div>
            </div>

        </div>
    </div>
        <div class="col-lg-9">
                <div class="ibox float-e-margins">     
                	<div class="ibox-title">
                		<h5>Stock Tiap Barang</h5>
                	</div>               
                    <div class="ibox-content">

                        <table class="table table-striped" id="datatables">
                            <thead>
                            <tr>
                                <th>NO</th>
                                <th>KODE</th>
                                <th>NAMA</th> 
                                <th>STOCK TERSEDIA</th>                                                              
                                <th>HARGA JUAL</th> 
                                <th>DESKRIPSI</th>                                
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;?>
                            @foreach($products as $product)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$product->code}}</td>                                                           
                                <td><a href="{{route('kasir.stock.product.view',$product)}}">{{$product->name}}</a></td>
                                <td><span class="label @if($product->storeAvailableStocks() > 100) label-primary @else label-danger @endif">{{$product->storeAvailableStocks()}}</span></td>
                                <td>{{toRp($product->sell_price)}}</td>
                                <td>{{substr($product->description,0,50)}}</td>                                
                                <td class="text-navy">
                                    <a href="{{route('kasir.stock.product.view',$product)}}" class="btn btn-xs btn-success"><i class="fa fa-eye"></i> Lihat</a>                                   
                                    
                                    <a href="{{route('kasir.product.addstock',$product)}}" class="btn btn-xs btn-info"><i class="fa fa-plus"></i> Tambah Stock</a>
                                    <!-- <button id="" class='btn btn-danger'>Delete</button> -->
                                </td>
                            </tr>
                            <?php $i++;?>
                            @endforeach
                            </tbody>
                        </table>

                       
                    </div>
                </div>
            </div>
        </div>
@stop

@section('footer')
    <script src="{{url('assets/backend')}}/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="{{url('assets/backend')}}/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="{{url('assets/backend')}}/js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="{{url('assets/backend')}}/js/plugins/dataTables/dataTables.tableTools.min.js"></script>
<script>
        $(document).ready(function() {
            $('#datatables').dataTable({
                responsive: true,
                pageLength:100,
            });               
        });        
    </script>
@stop