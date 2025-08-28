@php
    // Normalize arrays (works whether casted or stored as JSON)
    $billing  = is_array($order->billing)  ? $order->billing  : json_decode($order->billing ?? '{}', true);
    $shipping = is_array($order->shipping) ? $order->shipping : json_decode($order->shipping ?? '{}', true);

    $customerName = $billing['full_name']
        ?? $billing['name']
        ?? optional($order->user)->name
        ?? 'Customer';

    // Totals
    $subtotal   = 0;
    $shipTotal  = 0;
    $qtyTotal   = 0;

    foreach ($order->orderDetails as $d) {
        $subtotal  += ($d->price * $d->quantity);
        $shipTotal += ($d->shipping_cost ?? 0);
        $qtyTotal  += $d->quantity;
    }

    $grandTotal = $order->total ?? ($subtotal + $shipTotal);

    // Simple number formatter (no decimals)
    $fmt = fn($n) => number_format((float)$n, 0);
    $orderCode = $order->code ?? $order->id;
    $orderDate = optional($order->created_at)->timezone(config('app.timezone'))->format('d M Y, h:i A');
    $trackUrl  = url('/orders/' . $orderCode);
@endphp

@component('mail::message')
# ধন্যবাদ, {{ $customerName }}! 🎉

আপনার অর্ডার **#{{ $orderCode }}** কনফার্ম হয়েছে।

**Order date:** {{ $orderDate }}  
**Payment method:** {{ strtoupper($order->payment_type ?? 'COD') }}  
**Order status:** {{ ucfirst($order->status ?? 'pending') }}

@component('mail::button', ['url' => $trackUrl])
View / Track Your Order
@endcomponent

---

## Order Items ({{ $qtyTotal }})

@component('mail::table')
| Item | Qty | Price | Shipping | Line Total |
|:-----|:--:|------:|---------:|-----------:|
@foreach($order->orderDetails as $item)
@php
    $name      = optional($item->product)->name ?? 'Unavailable';
    $qty       = (int) $item->quantity;
    $price     = (float) $item->price;
    $ship      = (float) ($item->shipping_cost ?? 0);
    $lineTotal = $qty * $price + $ship;
@endphp
| {{ $name }} | {{ $qty }} | ৳ {{ $fmt($price) }} | ৳ {{ $fmt($ship) }} | **৳ {{ $fmt($lineTotal) }}** |
@endforeach
@endcomponent

@component('mail::panel')
**Order Summary**  
**Subtotal:** ৳ {{ $fmt($subtotal) }}  
**Shipping:** ৳ {{ $fmt($shipTotal) }}  
@if(!empty($order->discount))
**Discount:** − ৳ {{ $fmt($order->discount) }}  
@endif
**Grand Total:** **৳ {{ $fmt($grandTotal) }}**
@endcomponent

@if(!empty($order->note))
> **Note from you:** {{ $order->note }}
@endif

---

## Shipping Address
@php
    // Prefer shipping; fall back to billing if shipping is empty
    $ship = $shipping ?: $billing;
@endphp

**{{ $ship['full_name'] ?? $ship['name'] ?? $customerName }}**  
{{ $ship['address'] ?? '-' }}  
@if(!empty($ship['city']) || !empty($ship['postal_code']))
{{ $ship['city'] ?? '' }} {{ !empty($ship['city']) && !empty($ship['postal_code']) ? '-' : '' }} {{ $ship['postal_code'] ?? '' }}  
@endif
@if(!empty($ship['phone'])) **Phone:** {{ $ship['phone'] }} @endif  
@if(!empty($ship['email'])) **Email:** {{ $ship['email'] }} @endif

## Billing Address
@php
    $bill = $billing ?: $shipping;
@endphp

**{{ $bill['full_name'] ?? $bill['name'] ?? $customerName }}**  
{{ $bill['address'] ?? '-' }}  
@if(!empty($bill['city']) || !empty($bill['postal_code']))
{{ $bill['city'] ?? '' }} {{ !empty($bill['city']) && !empty($bill['postal_code']) ? '-' : '' }} {{ $bill['postal_code'] ?? '' }}  
@endif
@if(!empty($bill['phone'])) **Phone:** {{ $bill['phone'] }} @endif  
@if(!empty($bill['email'])) **Email:** {{ $bill['email'] }} @endif

---

যদি কোনো সহায়তা প্রয়োজন হয়, এই ইমেইলে রিপ্লাই করুন বা আমাদের সঙ্গে যোগাযোগ করুন।  
**Order #{{ $orderCode }}** — মোট: **৳ {{ $fmt($grandTotal) }}**

ধন্যবাদান্তে,  
{{ config('app.name') }}
@endcomponent
