                            <div class="row">
                                <div class="col-sm-6">                                    
                                    <address>
                                        <strong>{{$order->kasir->store->name}}</strong><br>
                                        <i class="fa fa-map-marker"></i> {{$order->kasir->store->address}}<br>
                                        <i class="fa fa-phone"></i> {{$order->kasir->store->phone}}
                                    </address>
                                </div>

                                <div class="col-sm-6 text-right">                                    
                                    <h4 class="text-navy">NO. {{$order->id}}</h4>
                                    <span class="label @if($order->status == 'lunas') label-primary @else label-danger @endif">{{strtoupper($order->status)}}</span><br><br>
                                    <address>
                                    kepada:<strong>{{$order->customer->name}}</strong><br>
                                        <i class="fa fa-map-marker"></i> {{$order->kasir->store->address}}<br>
                                        <i class="fa fa-map-phone"></i> {{$order->kasir->store->phone}}
                                    </address>
                                    <p>
                                        <span><strong>Tanggal</strong> {{$order->created_at->format('d M Y')}}</span><br>
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th>Qty</th>
                                        <th>Harga Satuan</th>                                        
                                        <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>                                    
                                    @foreach($order->items as $item)
                                    <tr>                                        
                                        <td><strong>{{$item->product->name}}</strong></td>
                                        <td>{{$item->qty}}</td>
                                        <td>{{toRp($item->price)}}</td>
                                        <td>{{toRp($item->price * $item->qty)}}</td>                                        
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
                                <tr>
                                    <td><strong>HUTANG :</strong></td>
                                    <td><span class="label label-warning">{{toRp($order->total_price - $order->pembayaran->sum('nominal'))}}</span></td>
                                </tr>

                                </tbody>
                            </table>

                            <div class="text-right"> <a href="{{route('order.print',$order)}}" class="btn btn-primary"><i class="fa fa-print"></i> Print</a></div>
                       