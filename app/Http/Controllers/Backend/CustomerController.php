<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::customer()->when(request('search'), function ($query) {
            $query->where('name', 'LIKE', '%'.request('search').'%')
                ->orWhere('email', 'LIKE', '%'.request('search').'%')
                ->orWhere('username', 'LIKE', '%'.request('search').'%')
                ->orWhere('phone', 'LIKE', '%'.request('search').'%');
        })->latest()->paginate()->appends(request()->all());

        return view('backend.customers.index', compact('customers'));
    }

    public function destroy($id)
    {
        User::destroy($id);

        $orders = Order::where('user_id', $id)->get();

        foreach ($orders as $order) {
            OrderDetails::where('order_id', $order->id)->delete();
            $order->delete();
        }

        Cart::where('user_id', $id)->delete();
        Wishlist::where('user_id', $id)->delete();
        ProductReview::where('user_id', $id)->delete();
        DB::table('sessions')->where('user_id', $id)->delete();

        return back()->with('success', 'User deleted successfully!');

    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $this->destroy($id);
            }

            session()->flash('success', count($ids).' Bulk deleted successfully!');

            return 1;
        }
        session()->flash('error', 'Whoops, something went wrong!');

        return 1;
    }
}
