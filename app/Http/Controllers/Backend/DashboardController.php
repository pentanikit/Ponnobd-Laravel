<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Spatie\ResponseCache\Facades\ResponseCache;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        $data['products'] = Product::query();
        $data['orders'] = Order::with('user','orderDetails');
        $data['customer_count'] = User::customer()->count();
        $data['today_visitors'] = Visitor::query()
                                    ->whereBetween('created_at',[
                                        $startOfDay,
                                        $endOfDay
                                    ])
                                    ->count();

        $data['weekly_visitors'] = Visitor::query()
                                    ->whereBetween('created_at',[
                                        now()->subDay(),
                                        now()->subDays(7)
                                    ])
                                    ->count();

        $data['monthly_visitors'] = Visitor::query()
                                    ->whereBetween('created_at',[
                                        now()->subDay(),
                                        now()->subDays(30)
                                    ])
                                    ->count();

        $data['logged_user'] = Visitor::query()
                    ->whereBetween('created_at',[
                            $startOfDay,
                            $endOfDay
                    ])
                    ->whereNotNull('user_id')
                    ->count();

        $data['guest_user'] = Visitor::query()
                        ->whereBetween('created_at',[
                            $startOfDay,
                            $endOfDay
                        ])
                        ->whereNull('user_id')
                        ->count();

        return view('backend.index', $data);
    }

    public function cacheClear()
    {
        Artisan::call('migrate',[
            '--force' => true
        ]);
        
        Artisan::call('optimize:clear');

        return back()->with('success', 'Cache cleared successfully!');
    }

    public function profile()
    {
        return view('backend.profile.edit');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'nullable|min:6',
            'email' => 'required|email|unique:users,email,'.auth()->id()
        ]);

        $user = User::findOrFail(auth()->id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password != null ? bcrypt($request->password) : $user->password;
        $user->save();

        return back()->with('success','Profile Update successfully!');
    }

    public function updateUrl()
    {
        Artisan::call('link:change');
        return back()->with('success','Link updated!');
    }
}
