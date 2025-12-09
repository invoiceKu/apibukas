<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller; // ✅ penting
use App\Models\Price;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        // Ambil data dengan id 1 sampai 3
        $prices = Price::whereIn('id', [1, 2, 3])->get();

        return view('homepage', compact('prices'));
    }
}
