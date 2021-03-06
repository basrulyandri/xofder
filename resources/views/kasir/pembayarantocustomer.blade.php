@extends('layouts.kasir.master')
@section('header')
	<link rel="stylesheet" href="{{asset('cashier')}}/bootstrap3-editable/css/bootstrap-editable.css">
@stop
@section('content')

<div class="row">
            <div class="col-lg-8">
                <div class="wrapper wrapper-content animated fadeInRight">
                	<div class="ibox-title">
                		<h3>Detail Penjualan</h3>
                	</div>
                   
                    <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-6">                                    
                                    <address>
                                        <strong>{{getSetting('company_name')}}</strong><br>
                                        {{auth()->user()->store->name}}<br>
                                        {{auth()->user()->store->address}}<br>
                                        <abbr title="Phone"></abbr> {{auth()->user()->store->phone}}
                                    </address>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <address>
                                        <strong>{{$order->customer->name}}</strong><br>
                                        <abbr title="Phone"></abbr> {{$order->customer->phone}}
                                    </address>
                                    <p>
                                        
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>BARANG</th>
                                        <th>QTY</th>                                        
                                        <th>HARGA SATUAN</th>
                                        <th>SUBTOTAL</th>                                       
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    
                                    @foreach(session('cart')->items as $key => $item)
                                    <tr>
                                        <td><div><strong>{{$item['item']->name}}</strong></div></td>
                                        <td>{{$item['qty']}}</td>
                                        <td>{{toRp($item['price'])}}</td>
                                        <td>{{toRp($item['qty'] * $item['price'])}}</td>                                        
                                    </tr>                                    
                                    @endforeach
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->
                            
                            <table class="table invoice-total">
                                <tbody>                                
                                <tr>
                                    <td><strong>TOTAL BARANG :</strong></td>
                                    <td>{{$order->total_qty}} PCS</td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL HARGA :</strong></td>
                                    <td>{{toRp($order->total_price)}}</td>
                                </tr>
                                </tbody>
                            </table>                            
                        </div>
                 
                </div>
            </div>

            <div class="col-lg-4">
            	<div class="wrapper wrapper-content animated fadeInRight">
            		<div class="ibox-title">
            		<h3>Pembayaran</h3>
            		</div>
                    
                    <div class="ibox-content p-xl">
            			{!!Form::open(['route' =>'kasir.finish.final.tocustomer'])!!}
                            @if(session('cart')->orderId)
                                <input type="hidden" name="order_id" value="{{$order->id}}">
                            @else
                                <input type="hidden" name="order" value="{{json_encode($order)}}">
                            @endif
							<div class='form-group{{$errors->has('pembayaran') ? ' has-error' : ''}}'>
								{!!Form::label('pembayaran','Cara Pembayaran')!!}
							  
							    {!!Form::select('pembayaran',[''=>'Pilih cara bayar','lunas' => 'Lunas','hutang' => 'hutang'],old('pembayaran'),['class' => 'form-control','required' => 'true','id' => 'pembayaran'])!!}							  
							</div>

							<div class="form-group" id="nominal">
								
								  
								  
							</div>					
							<input type="submit" value="Selesai" class="btn btn-lg btn-primary bg-info">
            			{!!Form::close()!!}
            			
            		</div>
            	</div>
            </div>
        </div>
@stop

@section('footer')
<script src="{{url('assets/backend')}}/js/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#pembayaran').change(function(){
				//alert($(this).val());	

				if($(this).val() == 'hutang'){
					//alert(0);
					var input_nominal = '<label>Jumlah bayar</label><input type="text" name="nominal" class="form-control uang" required>';
					$('#nominal').html(input_nominal);
                     $('.uang').inputmask({
                      'alias': 'numeric', 
                      'radixPoint': ',',
                      'groupSeparator': '.',
                      'autoGroup': true,
                      'digits': 0,
                      'digitsOptional': false,
                      'prefix': 'Rp ',
                      'placeholder': '0',
                      'removeMaskOnSubmit':true,
                      'rightAlign': false
                    });
				}

				if($(this).val() == 'lunas'){
					$('#nominal').html('');
				}
			});

           
		});
	</script>
@stop
