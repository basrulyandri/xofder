@extends('layouts.kasir.master')
@section('header')
	
@stop
@section('content')
<div class="row">
        <div class="col-lg-12">
                <div class="ibox float-e-margins">     
                	<div class="ibox-title">
                		<h2>List Stock Barang</h2>
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
                            <?php $i = ($products->currentPage() - 1) * $products->perPage() + 1; ?>
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

                        {{$products->links()}}
                    </div>
                </div>
            </div>
        </div>
@stop