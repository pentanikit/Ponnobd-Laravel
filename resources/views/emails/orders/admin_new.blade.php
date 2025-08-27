@component('mail::message')
# New Order Received

**Order:** #{{ $order->code ?? $order->id }}  
**Customer:** {{ data_get($order->billing, 'full_name', optional($order->user)->name) ?? 'N/A' }}  
**Email:** {{ $order->email ?? optional($order->user)->email ?? data_get($order->billing,'email','N/A') }}  
**Phone:** {{ data_get($order->billing, 'phone', 'N/A') }}

@php
    $lines = $order->orderDetails;  // ✅ or $order->items
    $subtotal = 0;
@endphp

@component('mail::table')
| Item (SKU) | Qty | Unit | Line Total |
|:-----------|---:|----:|----------:|
@foreach($lines as $item)
@php
    $name = $item->product->name ?? $item->name ?? 'Item';
    $sku  = $item->product->sku ?? $item->sku ?? '—';
    $qty  = $item->quantity ?? $item->qty ?? 1;
    $unit = $item->price ?? $item->unit_price ?? 0;
    $line = $qty * $unit;
    $subtotal += $line;
@endphp
| {{ $name }} ({{ $sku }}) | {{ $qty }} | {{ number_format($unit, 2) }} | {{ number_format($line, 2) }} |
@endforeach
@endcomponent

**Subtotal:** {{ number_format($order->subtotal ?? $subtotal, 2) }}  
@isset($order->discount) **Discount:** −{{ number_format($order->discount, 2) }} @endisset
@isset($order->shipping_cost) **Shipping:** {{ number_format($order->shipping_cost, 2) }} @endisset  
**Grand Total:** {{ number_format($order->total ?? $order->grand_total ?? ($order->subtotal ?? $subtotal), 2) }}

@endcomponent
