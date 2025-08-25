<div>
    <!-- Breadcrumb Start Here -->
    <div class="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb--wrapper">
                        <h2 class="breadcrumb--title fw--400">  Order #{{ $order->code }} </h2>
                        <ul class="breadcrumb--list">
                            <li class="breadcrumb--item"><a href="{{ url('/') }}" class="breadcrumb--link">Home</a></li>
                            <li class="breadcrumb--icon">//</li>
                            <li class="breadcrumb--item"> <span class="breadcrumb--item--text"> Order #{{ $order->code }} </span> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Breadcrumb End Here -->
    
    <section class="order-summary py-10">
        <div class="container">
            <div class="row gy-3">
                <div class="col-lg-7">
                    <div class="row gy-3">
                        <div class="col-lg-12">
                            <div class="base--card">
                                <div class="summary-content--wrap d-flex flex-column align-items-start justify-content-start">
                                    <h6 class="fs--22 mb-2"><i class="fa-regular fa-circle-check"></i> Confirmed</h6>

                                    <div class="ms-4 mb-4">
                                        <p>Update {{ $order->created_at->format('d M Y') }}</p>
                                        <p>We've received your order</p>
                                    </div>
        
                                    <ul class="ms-4 d-flex flex-column justify-content-start gap--12">
                                        <li>
                                            <h6 class="fs--18 mb-0">Submitted</h6>
                                        </li>
                                        <li>
                                            <h6 class="fs--18 mb-0">Shipped</h6>
                                        </li>
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="base--card">
                                <h6>Order Details</h6>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="d-flex flex-column gap--12">
                                            <li>
                                                <p>Shipping Address</p>
                                                @foreach (json_decode($order->billing) ?? [] as $key => $value)
                                                <p class="text--black fw--700">{{ ucfirst(str_replace('_',' ',$key)) }} : {{ ucfirst(str_replace('_',' ',$value)) }}</p>
                                                @endforeach
                                            </li>
                                            <li>
                                                <p>Shipping Method</p>
                                                <p class="text--black fw--700">Inside Dhaka</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="d-flex flex-column gap--12">
                                            <li>
                                                <p>Payment</p>
                                                <p class="text--black fw--700">Cash On Delivery (COD) - ৳{{ $order->total }}</p>
                                            </li>
                                            <li>
                                                <p>Billing Address</p>
                                                @foreach (json_decode($order->billing) ?? [] as $key => $value)
                                                <p class="text--black fw--700">{{ ucfirst(str_replace('_',' ',$key)) }} : {{ ucfirst(str_replace('_',' ',$value)) }}</p>
                                                @endforeach
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-5">
                    <div class="row gy-3">
                        <div class="col-lg-12">
                            <div class="base--card">
                                <h6>{{ formatPrice($order->total) }} BDT</h6>
                                <p>This order has a pending payment. The balance will be updated when payment is received.
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="base--card">
                                <h6>Order summary</h6>

                                <div class="product-list--wrap d-flex flex-column gap--12 mb-5">
                                    @foreach ($order->orderDetails as $detail)
                                    <div
                                        class="order-product--card d-flex justify-content-between align-items-center gap--16 border-top--none">
                                        <div class="thumb--wrap position-relative flex-shrink-0">
                                            <img class="fit--img" src="{{ uploadedFile($detail->product->thumbnail_img) }}" alt="...">
                                            <div
                                                class="count position-absolute d-flex justify-content-center align-items-center">
                                                <p class="text--white fw--600 text--sm">{{ $detail->quantity }}</p>
                                            </div>
                                        </div>
                                        <div class="content--wrap">
                                            <div class="title">
                                                <h6 class="fs--14 mb-0">
                                                    {{ $detail->product->name ?? 'Unavailable' }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <p>৳ {{ $detail->price*$detail->quantity+$detail->shipping_cost }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="price--erap">
                                    <ul class="d-flex flex-column justify-content-between gap--16">
                                        <li class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">Total</h6>
                                            <p>৳ {{ $order->total }}</p>
                                        </li>
                                    </ul>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
