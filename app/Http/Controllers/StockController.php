<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;

class StockController extends Controller
{
    public function delete(Stock $stock)
    {
    	dd($stock);
    }
}
