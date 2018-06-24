@extends('layouts.backend.master')
@section('title')
    Dashboard
@stop
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Dashboard</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('dashboard.index')}}">Dashboard</a>
                </li>                
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">                        
                        <h5>Penjualan</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{amountOfSuccessOrders()}}</h1>                        
                        <small>Total</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">                        
                        <h5>Stock Tersedia</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{amountOfTotalStocks()}}</h1>                        
                        <small>PCS</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop