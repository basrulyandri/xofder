@extends('layouts.kasir.master')
@section('header')
    
@stop
@section('content')
<div class="row">
            <div class="col-lg-12">
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
@stop