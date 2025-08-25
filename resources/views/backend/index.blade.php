@extends('backend.layouts.app')

@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card mb-4">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-uppercase font-weight-bold mb-0 text-sm">Today's Visitors</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $today_visitors }}
                                        </h5>
                                        <p class="mb-0">
                                            <span class="text-success font-weight-bolder text-sm">Logged User : </span>
                                            <span>{{ $logged_user }}</span> <br>
                                            <span class="text-danger font-weight-bolder text-sm">Guest User : </span>
                                            <span>{{ $guest_user }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success rounded-circle text-center">
                                        <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card mb-4">
                        <div class="card-body p-3" style="height:143px;">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-uppercase font-weight-bold mb-0 text-sm">Last 7 Days Visitors</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $weekly_visitors }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success rounded-circle text-center">
                                        <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card mb-4">
                        <div class="card-body p-3" style="height:143px;">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-uppercase font-weight-bold mb-0 text-sm">Last 30 Days Visitors</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $monthly_visitors }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success rounded-circle text-center">
                                        <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card mb-4">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-uppercase font-weight-bold mb-0 text-sm">Total Products
                                        </p>
                                        <h5 class="font-weight-bolder">
                                            {{ $products->count() }}
                                        </h5>
                                        <p class="mb-0">
                                            <span class="text-success font-weight-bolder text-sm">Publish : </span>
                                            <span>{{ $products->where('status', 'publish')->count() }}</span> <br>
                                            <span class="text-danger font-weight-bolder text-sm">Draft : </span>
                                            <span>{{ $products->where('status', 'draft')->count() }}</span>

                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow-primary rounded-circle text-center">
                                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card mb-4">
                        <div class="card-body p-3" style="height:143px;">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-uppercase font-weight-bold mb-0 text-sm">Total Customers
                                        </p>
                                        <h5 class="font-weight-bolder">
                                            {{ $customer_count }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger rounded-circle text-center">
                                        <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card mb-4">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-uppercase font-weight-bold mb-0 text-sm">Total Orders</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $orders->count() }}
                                        </h5>
                                        <p class="mb-0">
                                            <span class="text-success font-weight-bolder text-sm">Completed : </span>
                                            <span>{{ $orders->whereStatus('completed')->count() }}</span> <br>
                                            <span class="text-danger font-weight-bolder text-sm">Cancelled : </span>
                                            <span>{{ $orders->whereStatus('cancelled')->count() }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-warning shadow-warning rounded-circle text-center">
                                        <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('orders_view')
    <div class="card">
        <div class="card-title h4 p-2">
            Recent Orders
        </div>
        <div class="table-responsive">
            <table class="align-items-center mb-0 table">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                            #
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Order Code</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Num of product
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Amount</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Delivery Status
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Payment method
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Options</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse (App\Models\Order::with('user')->latest()->limit(20)->get() as $order)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                <h6 class="mb-0 text-xs">#{{ $order->code }}</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 text-xs">{{ count($order->orderDetails) }}</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 text-xs">{{ $order->user->name ?? $order->guest_id }}</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 text-xs">{{ formatPrice($order->total) }}</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 text-xs">
                                    <span
                                        @class([
                                            'badge badge-inline mb-0 text-small',
                                            'badge-success' => $order->status == 'completed',
                                            'badge-info' => $order->status == 'pending',
                                            'badge-secondary' => $order->status == 'processing',
                                            'badge-warning' => $order->status == 'on_hold',
                                            'badge-danger' => $order->status == 'cancelled',
                                        ])>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                                </h6>
                            </td>
                            <td>
                                <h6 class="mb-0 text-xs">{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</h6>
                            </td>
                            <td>
                                <div class="d-flex">

                                    <a href="{{ route('order.show', $order->id) }}" class="mr-2">
                                        <div class="bg-success badge"><i class="fa fa-eye"></i></div>
                                    </a>
                                    @can('orders_delete')
                                    <a href="{{ route('order.destroy', $order->id) }}"
                                        onclick="return confirm('Are you sure?')">
                                        <div class="bg-danger badge"><i class="fa fa-trash"></i></div>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td colspan="10" class="text-center">No Recent Order Found!</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endcan
@endsection
