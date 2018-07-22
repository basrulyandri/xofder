<?php

namespace App;

class Cart
{
    public $items = null;    
    public $totalQty = 0;
    public $totalPrice = 0;
    public $orderId = null;
    //public $customer = 'Anonim';

    public function __construct($oldCart)
    {
    	if($oldCart){
    		$this->items = $oldCart->items;            
    		$this->totalQty = $oldCart->totalQty;
    		$this->totalPrice = $oldCart->totalPrice;
            $this->orderId = $oldCart->orderId;
            //$this->customer = $oldCart->customer;            
    	}
    }

    public function add($item,$id)
    {    	
    	$storedItem = ['qty' => 0,'price' => $item->sell_price,'item' => $item,'stocks' => 0];
    	if($this->items){
    		if(array_key_exists($id, $this->items)){
    			$storedItem = $this->items[$id];
    		}
    	}
    	$storedItem['qty']++;    	
        $storedItem['stocks'] = Product::find($id)->available_stocks;
    	$this->items[$id] = $storedItem;        
    	$this->totalQty++;
    	$this->totalPrice += $item->sell_price;
    }

    public function substractqty($item,$id)
    {   
        if($this->items){
            if(array_key_exists($id, $this->items)){
                $this->items[$id]['qty'] -= 1;
            }
        }
        $this->totalQty -= 1;
        $this->totalPrice -= $item->price;
    }


    public function removeItem($item_id)
    {
        //return $this->items[$item_id];
        if($this->items){
            if(array_key_exists($item_id,$this->items)){
                $this->totalQty -= $this->items[$item_id]['qty'];
                $this->totalPrice -= $this->items[$item_id]['price'] * $this->items[$item_id]['qty'];
                //return $this->totalPrice;
                unset($this->items[$item_id]);
            }
        }
    }

    public function editQty($id,$qty)
    {       
        if($this->items){
            if(array_key_exists($id, $this->items)){
                if($qty > $this->items[$id]['qty']){
                    $editedQty = $qty - $this->items[$id]['qty'];
                    $this->items[$id]['qty'] = $qty;
                    $this->totalQty += $editedQty;                    
                    $this->totalPrice = $this->totalPrice + ($editedQty * $this->items[$id]['price']);
                } else {
                    $editedQty = $this->items[$id]['qty'] - $qty;
                    $this->totalQty -= $editedQty;
                    $this->items[$id]['qty'] = $qty;
                    $this->totalPrice = $this->totalPrice - ($editedQty * $this->items[$id]['price']);
                }
            }
        }
        
    }

    public function editHarga($id,$harga)
    {       
        if($this->items){
            if(array_key_exists($id, $this->items)){
                // Mengambil harga subtotal sebelum diubah harganya
                $hargasubtotalsebelumnya = $this->items[$id]['qty'] * $this->items[$id]['price'];

                $this->items[$id]['price'] = $harga;
                $this->totalPrice = ($this->totalPrice - $hargasubtotalsebelumnya ) + $this->items[$id]['qty'] * $this->items[$id]['price'];              
            }
        }
        
    }

    // public function changeCustomer($name)
    // {
    //     $this->customer = $name;
    // }
}
