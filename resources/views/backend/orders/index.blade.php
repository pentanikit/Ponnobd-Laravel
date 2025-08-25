@extends('backend.layouts.app')

@section('title')
Orders
@endsection
@section('content')
<div class="card">
    <div class="card-header ">
        <h5 class="mb-md-0 h6">All Orders</h5>
    </div>
    <form>
        <div class="row">
            @can('orders_bulk_delete')
            <div class="col-md-2 ">
                <div class="dropdown pl-2">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                      Bulk Action
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <li><a class="dropdown-item" href="{{ route('order.bulk.delete') }}" id="deleteSelected">Delete selection</a></li>
                    </ul>
                </div>
            </div>
            @endcan
            <div class="col-lg-3">
                <div class="form-group mb-0">
                    <select class="form-select" name="payment_status" id="update_payment_status">
                        <option value="" selected> Filter By Payment Status </option>
                        <option value="unpaid" @selected(request('payment_status') == 'unpaid')> Unpaid </option>
                        <option value="paid" @selected(request('payment_status') == 'paid')> Paid </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <select class="form-select" name="status" id="update_delivery_status">
                        <option value="" selected> Filter By Status </option>
                        <option value="pending" @selected(request('status') == 'pending')> Pending </option>
                        <option value="processing" @selected(request('status') == 'processing')> Processing </option>
                        <option value="on_hold" @selected(request('status') == 'on_hold')> On Hold </option>
                        <option value="completed" @selected(request('status') == 'completed')> Completed </option>
                        <option value="cancelled" @selected(request('status') == 'cancelled')> Cancelled </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Type Order code &amp; hit Enter" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        <div class="d-flex align-items-center">
                            @can('orders_bulk_delete')
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allSelected">
                            </div>
                            @endcan
                            <p class="text-xs font-weight-bold ms-2 mb-0">#</p>
                        </div>
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Order Code</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Num of product</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Amount</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Delivery Status</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Payment method</th>

                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Options</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($orders as $order)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            @can('orders_bulk_delete')
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bulkDelete" value="{{ $order->id }}">
                            </div>
                            @endcan
                            <p class="text-xs font-weight-bold ms-2 mb-0">{{ $orders->firstItem() + $loop->index }}</p>
                        </div>
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
                            <span @class([
                                'badge badge-inline mb-0 text-small',
                                'badge-success' => $order->status == 'completed',
                                'badge-info' => $order->status == 'pending',
                                'badge-secondary' => $order->status == 'processing',
                                'badge-warning' => $order->status == 'on_hold',
                                'badge-danger' => $order->status == 'cancelled',
                            ])>{{ ucfirst(str_replace('_',' ',$order->status)) }}</span>
                        </h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ ucfirst(str_replace('_',' ',$order->payment_type)) }}</h6>
                    </td>
                    <td>
                        <div class="d-flex">
                            @can('orders_view')
                            <a href="{{ route('order.show',$order->id) }}" class="mr-2"><div class="bg-success badge"><i class="fa fa-eye"></i></div></a>
                            @endcan

                            @can('orders_delete')
                            <a href="{{ route('order.destroy',$order->id) }}" onclick="return confirm('Are you sure?')"><div class="bg-danger badge"><i class="fa fa-trash"></i></div></a>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <td colspan="3">No Data Found!</td>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
</div>
@endsection
