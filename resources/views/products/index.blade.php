@extends('layouts.backend.master')
@section('header')
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="{{url('assets/backend')}}/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
@endsection
@section('title')
  Daftar Produk
@stop

@section('content')  
    <div class="row wrapper border-bottom white-bg page-heading">	
        <div class="col-sm-4">
            <h2>Barang</h2>
            <ol class="breadcrumb">
                <li class="active">
                    <a href="{{route('products.index')}}">Barang</a>
                </li>                
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">                  
                    
                <a href="{{route('product.add')}}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
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
                                <th>KODE</th>
                                <th>NAMA</th> 
                                <th>STOCK TERSEDIA</th>                                                              
                                <th>HARGA JUAL</th>
                                <th>HARGA MODAL</th> 
                                <th>DESKRIPSI</th>                                
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{$product->code}}</td>                                                           
                                <td><a href="{{route('product.view',$product->id)}}">{{$product->name}}</a></td>
                                <td>{{$product->available_stocks}}</td>
                                <td>{{toRp($product->sell_price)}}</td>
                                <td>{{toRp($product->buy_price)}}</td>
                                <td>{{substr($product->description,0,50)}}</td>                                
                                <td class="text-navy">
                                    <a href="{{route('product.view',$product->id)}}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> Lihat</a>
                                    
                                    <a href="{{route('product.edit',$product)}}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Ubah</a>
                                    <a href="{{route('product.addstocks',$product->id)}}" class="btn btn-xs btn-info"><i class="fa fa-plus"></i> Tambah Stock</a>
                                    <!-- <button id="" class='btn btn-danger'>Delete</button> -->
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
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
