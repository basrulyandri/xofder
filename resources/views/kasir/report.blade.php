@extends('layouts.kasir.master')  

@section('header')
    
@endsection
@section('title')
  Laporan Penjualan
@stop

@section('content')    
    <div class="row wrapper border-bottom white-bg page-heading">   
        <div class="col-sm-4">
            
        </div>
        <div class="col-sm-8">
            <div class="title-action">                 
                <form method="GET" class="form-inline" id="formPeriod" >                    
                    <div class="form-group">
                         {!!Form::select('period',['7' => '7 Hari Terakhir','28' => '28 Hari Terakhir'],\Request::input('period'),['class' => 'form-control','id' => 'period'])!!}                                                 
                    </div>                
                </form>
            </div>
        </div> 
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-content">
                    <div id="penjualan"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                 <div class="ibox-content">
                    <div id="piePenjualanProduct"></div>
                </div>
            </div>
        </div>
	</div>
@stop

@section('footer')   
<script type="text/javascript" src="{{asset('assets/backend/js/plugins/highcharts/highcharts.js')}}"></script>
<script>
        $(document).ready(function() {
            Highcharts.setOptions({
                lang: {
                    thousandsSep: '.',
                    numericSymbols:['Rb','Jt','M']
                }
            });
           Highcharts.chart('penjualan', {!!json_encode($penjualanChart)!!});
           Highcharts.chart('piePenjualanProduct', {!!json_encode($piePenjualanProduct)!!});

           $('#period').change(function(){ 
           console.log($('#formPeriod'));           
                $('#formPeriod').submit();
           });
        });        
    </script>
@endsection
