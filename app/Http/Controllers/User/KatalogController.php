<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inventory;

class KatalogController extends Controller
{
    public function index()
    {
        $inventories = Inventory::where('total_stock', '>', 0)->latest()->get();
        return view('user.katalog', compact('inventories'));
    }
}
