@extends('layouts.backend.master')
@section('header')
    
@endsection
@section('title')
  Daftar Penjualan
@stop

@section('content')      
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
        });        
    </script>
@endsection
