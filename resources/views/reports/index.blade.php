@extends('layouts.backend.master')
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
                <form role="form" class="form-inline">
                    
                    <div class="form-group">
                        <form method="GET" class="inline-form" id="formPeriod" >
                         {!!Form::select('period',['7' => '7 Hari Terakhir','28' => '28 Hari Terakhir'],\Request::input('period'),['class' => 'form-control'])!!}                           

                            <input type="submit" class="btn btn-info" value="OK"/>
                        </form>
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
                $('form[id="formPeriod"]').submit();
           });
        });        
    </script>
@endsection
