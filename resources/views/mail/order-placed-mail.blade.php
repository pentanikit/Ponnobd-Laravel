<x-mail::message>
# New Order Placed - #{{ $order->code }}

A new order has been placed on your website. Here are the details:

<b>Order Code: #{{ $order->code }}</b>  <br>
@foreach (json_decode($order->shipping) as $key => $ship)
<b> Customer {{ ucwords(str_replace('_',' ',$key)) }}</b> : {{ $ship }} <br>
@endforeach

<b>Order Total :</b> {{ $order->total }} BDT.
@component('mail::table')
| #    | Product   | Quantity  | Price  |
|:------:   |:----------- |:-----------  |:--------: |
@foreach ($order->detail as $detail)
| {{ $loop->index +1 }} | {{ $detail->product?->name ?? 'N/A' }}     | {{ $detail->quantity }} | {{ formatPrice($detail->price*$detail->quantity) }} |
@endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
