<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $c_count = Category::count();
        $p_count = Product::count();
        $m_earning = Payment::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('total');
        $y_earning = Payment::whereYear('created_at', date('Y'))->sum('total');

        return view('admin.index', compact('c_count', 'p_count', 'm_earning', 'y_earning'));
    }
}
