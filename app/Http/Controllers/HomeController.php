<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(Carbon::today());    
        $user = User::where('email', '!=', 'admin@gmail.com')
            ->inRandomOrder()
            ->take(4)
            ->get();

        $dailysales = count(
            Order::whereDate('created_at', '=', Carbon::today())
                ->get()
        );

        $revenue_today =  DB::table('orders')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');
            
        // dd($revenue_today);

        $products = count(Product::where('quantity', '>', 0)
            ->orWhere('status', '=', 'active')
            ->get());

        return view('backend.index', compact('user', 'dailysales', 'revenue_today', 'products'));
    }
}
