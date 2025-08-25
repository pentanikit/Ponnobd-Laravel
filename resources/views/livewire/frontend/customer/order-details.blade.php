<section class="pt-3">
	<div class="container">
		<div class="row">
			<!-- Sidebar START -->
			<div class="col-lg-4 col-xl-3">
				<!-- Responsive offcanvas body START -->
				<div class="offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasSidebar">
					<!-- Offcanvas header -->
					<div class="offcanvas-header justify-content-end pb-2">
						<button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasSidebar" aria-label="Close"></button>
					</div>
					<!-- Offcanvas body -->
					<livewire:frontend.customer.sidebar/>
				</div>
				<!-- Responsive offcanvas body END -->
			</div>
			<!-- Sidebar END -->
			<!-- Main content START -->
			<div class="col-lg-8 col-xl-9">
				<!-- Offcanvas menu button -->
				<div class="d-grid mb-0 d-lg-none w-100">
					<button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"> <i class="fas fa-sliders-h"></i> Menu </button>
				</div>
				<div class="vstack gap-4">
					<div class="card border">
						<!-- Card header -->
						<div class="card-header border-bottom">
							<h4 class="card-header-title">Order Summary</h4>
                        </div>
						<!-- Card body START -->
						<div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 table-responsive">
                                    <table class="table-borderless table ">
                                        <tbody>
                                            <tr>
                                                <th class="fw-600">Order Code::</th>
                                                <td>{{ $order->code }}</td>
                                            </tr>
                                            <tr>
                                                <th class="fw-600">Customer:</th>
                                                <td>{{ $order->user?->name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="fw-600">Email:</th>
                                                <td>{{ $order->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <th class="fw-600">Shipping address:</th>
                                                <td>
                                                    @php
                                                        $shipping = is_array($order->shipping) ? $order->shipping : json_decode($order->shipping);
                                                        $billing = is_array($order->billing) ? $order->billing : json_decode($order->billing);
                                                    @endphp
                                                    @foreach ($shipping as $key => $ship)
                                                    <b>{{ ucwords(str_replace('_',' ',$key)) }}</b> : {{ $ship }} <br>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="fw-600">Billing address:</th>
                                                <td>
                                                    {{-- @dd() --}}
                                                    @foreach ($billing as $key => $ship)
                                                    <b>{{ ucwords(str_replace('_',' ',$key)) }}</b> : {{ $ship }} <br>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 table-responsive">
                                    <table class="table-borderless table">
                                        <tbody>
                                            <tr>
                                                <th class="fw-600">Order date:</th>
                                                <td>{{ $order->created_at->format('d M Y h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <th class="fw-600">Order status:</th>
                                                <td>{{ ucwords(str_replace('_',' ',$order->status)) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="fw-600">Total order amount:</th>
                                                <td>{{ formatPrice($order->total) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="fw-600">Shipping method:</th>
                                                <td>{{ ucwords(str_replace('_',' ',$order->detail->first()?->shipping_type)) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="fw-600">Payment method:</th>
                                                <td>{{ ucwords(str_replace('_',' ',$order->payment_type)) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-main text-bold">Order Note:</th>
                                                <td class="text-truncate">{{ $order->note }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
						</div>
						<!-- Card body END -->
					</div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card rounded-0 shadow-none border mt-2 mb-4">
                                <div class="card-header border-bottom-0">
                                    <h5 class="fs-16 fw-700 text-dark mb-0">Order Details</h5>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="text-gray">
                                            <tr class="footable-header">
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Variation</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $subtotal = 0;
                                        @endphp
                                        <tbody class="fs-14">
                                            @foreach ($order->detail as $detail)
                                            @php
                                                $variants = json_decode($detail->variation);
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->index +1 }}</td>
                                                <td>
                                                    <a href="{{ route('product.details',$detail->product?->slug) }}" wire:navigate target="_blank">{{ $detail->product?->name ?? 'N/A' }}</a>
                                                </td>

                                                <td>
                                                    @if(!is_null($variants))
                                                        @foreach ($variants as $variant => $value)
                                                            <span><b>{{ $variant }} : </b>{{ $value }}</span> <br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td> {{ $detail->quantity }} </td>
                                                <td>{{ formatPrice($detail->price*$detail->quantity) }}</td>
                                            </tr>
                                            @php
                                                $subtotal += $detail->price*$detail->quantity;
                                            @endphp
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Order Ammount -->
                        <div class="col-md-12">
                            <div class="card rounded-0 shadow-none border mt-2">
                                <div class="card-header border-bottom-0">
                                    <b class="fs-16 fw-700 text-dark">Order Amount</b>
                                </div>
                                <div class="card-body pb-0">
                                    <table class="table-borderless table">
                                        <tbody>
                                            <tr>
                                                <td class="w-50 fw-600">Subtotal</td>
                                                <td class="text-right"> <span class="strong-600">{{ formatPrice($subtotal) }}</span> </td>
                                            </tr>
                                            {{-- <tr>
                                                <td class="w-50 fw-600">Shipping</td>
                                                <td class="text-right"> <span class="text-italic">$0.000</span> </td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">Tax</td>
                                                <td class="text-right"> <span class="text-italic">$0.000</span> </td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">Coupon</td>
                                                <td class="text-right"> <span class="text-italic">$0.000</span> </td>
                                            </tr> --}}
                                            <tr>
                                                <td class="w-50 fw-600">Total</td>
                                                <td class="text-right"> <strong>{{ formatPrice($subtotal) }}</strong> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<!-- Main content END -->
		</div>
	</div>
</section>
