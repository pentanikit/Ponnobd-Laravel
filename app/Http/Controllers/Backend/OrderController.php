<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'orderDetails')->latest()->when(request('payment_status'), function ($query) {
            $query->where('payment_status', request('payment_status'));
        })->when(request('status'), function ($query) {
            $query->where('status', request('status'));
        })->when(request('search'), function ($query) {
            $query->where('code', 'LIKE', '%'.request('search').'%');
        })->paginate()->appends(request()->all());

        return view('backend.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view('backend.orders.show', compact('order'));
    }

    public function updateStatus(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = '0';
        $order->status = $request->status;
        $order->save();

        foreach ($order->detail as $key => $orderDetail) {

            $orderDetail->status = $request->status;
            $orderDetail->save();
        }

        session()->flash('success', 'Payment status has been updated!');
        session()->flash('success', 'Delivery status has been updated!');

        return 1;
    }

    public function updatePaymentStatus(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->payment_status_viewed = '0';
        $order->payment_status = $request->status;

        $order->save();

        foreach ($order->detail as $orderDetail) {
            $orderDetail->payment_status = $request->status;
            $orderDetail->save();
        }

        return 1;
    }

    public function destroy($id)
    {
        Order::destroy($id);
        OrderDetails::where('order_id', $id)->delete();

        return back()->with('success', 'Order deleted successfully!');
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
