<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Product;
use App\Order;
use Image;
class PageController extends Controller
{
  public function home()
  {      
    return view('pages.home');
  }

  public function single($slug)
  {
    $product = Product::whereSlug($slug)->with('images')->first();
    $randomProduct=Product::all()->random(5);    
    return view('pages.single',compact(['product','randomProduct']));
  }

  public function cart()
  {
    return view('pages.shoppingcart');
  }

  public function checkout()
  {    
    if(!\Auth::check()){
      return redirect()->route('page.login')->with('backroute',\Request::route()->getName());
    }
    return view('pages.checkout');
  }

  public function login()
  {
    return view('pages.login');
  }

  public function postlogin(Request $request){
    //dd($request->all());
    $this->validate($request, [
      'email' => 'required',
      'password' => 'required',
    ]);  
    if(\Auth::attempt(['email' => $request->input('email'),'password' => $request->input('password')])){  
      if($request->input('backroute') != ''){
        return redirect()->route($request->input('backroute'));
      }
      return redirect()->route('home');

    }                      
    return redirect()->back()->withInput();
  }

  public function postcheckout(Request $request)
  { 
    $order = new \App\Order;
    $order->user_id = \Auth::user()->id;
    $order->cart = serialize(session('cart'));
    $order->payment_method = $request->input('payment_method');   

    if($request->payment_method == 'eWallet'){
      if(!isEWalletCukup()){
        return redirect()->back()->with('alert-warning','Saldo eWallet Tidak cukup');
      }

      $order->status = 'dibayar';
      $order->tgl_dibayar = \Carbon\Carbon::now()->toDateString();
      $order->save();
      $transaksiKredit = new \App\Transaksi;
      $transaksiKredit->tanggal = \Carbon\Carbon::now();
      $transaksiKredit->nominal = session('cart')->totalPrice;    
      $transaksiKredit->d_k = 'kredit';
      $transaksiKredit->via = 3;
      $transaksiKredit->anggota_id = \Auth::user()->anggota_id;
      $transaksiKredit->jenis = 'belanja-warungmun-ewallet';
      $transaksiKredit->meta = serialize(['order_id' =>$order->id]);
      $transaksiKredit->save();

      $transaksiDebit = new \App\Transaksi;
      $transaksiDebit->tanggal = \Carbon\Carbon::now();
      $transaksiDebit->nominal = session('cart')->totalPrice;    
      $transaksiDebit->d_k = 'debit';
      $transaksiDebit->via = 3;
      $transaksiDebit->anggota_id = \Auth::user()->anggota_id;
      $transaksiDebit->jenis = 'kas-belanja-warungmun-ewallet';
      $transaksiDebit->meta = serialize(['order_id' =>$order->id]);
      $transaksiDebit->save();

      $anggota = \App\Anggota::find(\Auth::user()->anggota->id);
      $anggota->saldo_ewallet -= session('cart')->totalPrice;
      $anggota->save();
    } else{
      $order->status = 'dipesan';      
      $order->save();
    }
    
    

    \Session::forget('cart');
    return redirect()->route('page.order.view',['order' => $order]);
  }

  public function myaccount()
  {    
    return view('pages.myaccount');
  }

  public function myorders()
  {
    $orders = \Auth::user()->orders()->orderBy('created_at','desc')->paginate(10);
    $orders->transform(function($order,$key){
      $order->cart = unserialize($order->cart);
      return $order;
    });
    return view('pages.myorders',compact(['orders']));
  }

  public function order(Order $order)
  {
    $order->cart = unserialize($order->cart);
    return view('pages.order',compact(['order']));
  }

  public function register()
  {
      return view('pages.register');
  }

  public function postregister(Request $request)
  {

    $this->validate($request,[
        'nama' => 'required|min:3',
        'email' =>'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required',
      ]);
    
    $username = explode(' ',$request->input('nama'))[0];    
    $users = \App\User::where('username','like',$username.'%')->get();
    if(!$users->isEmpty()){
      $count = $users->count() + 1;
      $username = $username.$count;        
    }

    $user = \App\User::create([
      'role_id' => 6,
      'username' => strtolower($username),
      'email' => $request->input('email'),
      'password' => bcrypt($request->input('password')),
      'activated' => 1,
      'first_name' => $request->input('nama'),
      'remember_token' => str_random(100),
    ]);
    \Auth::login($user);
    return redirect()->route('page.myaccount');
  }

  public function search(Request $request)
  {
      if(!$request->has('q')){
        return redirect()->route('home');
      }

      $products = Product::where('name','LIKE','%'.$request->input('q').'%')->orWhere('description','LIKE','%'.$request->input('q').'%')->paginate(12);
      return view('pages.search',compact(['products','request']));
  }

  public function category($slug)
  {
    $kategori = \App\Kategori::whereSlug($slug)->first();
    $products = $kategori->products()->paginate(12);
    return view('pages.category',compact(['products','kategori']));
  }

  public function konfirmasipembayaran(Request $request)
  {
    //dd($request->all());
    $konfirmasi = \App\KonfirmasiPembayaran::create($request->all());

    if($request->hasFile('file')){
      $file = $request->file('file');
      $filename = time().$file->getClientOriginalName();
      if(!Image::make($file)->resize(500,500)->save(public_path('uploads/konfirmasi-pembayaran/'.$filename))){
        return 'not uploaded';
      }

      $konfirmasi->file = $filename;
    }
    $konfirmasi->status = 'terkirim';
    $konfirmasi->save();

    $order = Order::find($request->order_id);
    $order->status = 'validasi-pembayaran';
    $order->save();

    return redirect()->route('page.myaccount.orders')->with('toastr-success','Konfirmasi Pembayaran berhasil terkirim.');
  }
    
}
