@component('mail::message')
# ধন্যবাদ, {{ $order->billing_name ?? optional($order->user)->name ?? 'Customer' }}!

**Order:** #{{ $order->order_number ?? $order->id }}  
**Date:** {{ optional($order->created_at)->format('M d, Y H:i') }}

@php
    $lines = $order->items ?? collect();
    $subtotal = 0;
@endphp

@component('mail::table')
| Item | Qty | Unit | Total |
|:-----|---:|-----:|------:|
@foreach($lines as $item)
@php
    $name = $item->product->name ?? $item->name ?? 'Item';
    $qty  = $item->qty ?? $item->quantity ?? 1;
    $unit = $item->price ?? $item->unit_price ?? 0;
    $line = $qty * $unit;
    $subtotal += $line;
@endphp
| {{ $name }} | {{ $qty }} | {{ number_format($unit, 2) }} | {{ number_format($line, 2) }} |
@endforeach
@endcomponent

**Subtotal:** {{ number_format($order->subtotal ?? $subtotal, 2) }}  
@isset($order->discount) **Discount:** −{{ number_format($order->discount, 2) }} @endisset
@isset($order->shipping_cost) **Shipping:** {{ number_format($order->shipping_cost, 2) }} @endisset  
**Total:** {{ number_format($order->total ?? $order->grand_total ?? ($order->subtotal ?? $subtotal), 2) }}

@component('mail::button', ['url' => config('app.url')])
Visit Our Website
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
