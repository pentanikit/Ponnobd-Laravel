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
							<h4 class="card-header-title">My Orders</h4>
                        </div>
						<!-- Card body START -->
						<div class="card-body">
                            <div class="table-responsive border-0">
                                <table class="table align-middle p-4 mb-0 table-hover table-shrink">
                                    <!-- Table head -->
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="border-0 rounded-start">#</th>
                                            <th scope="col" class="border-0">Order No.</th>
                                            <th scope="col" class="border-0">Date</th>
                                            <th scope="col" class="border-0">Amount</th>
                                            <th scope="col" class="border-0">Status</th>
                                            <th scope="col" class="border-0 rounded-end">Options</th>
                                        </tr>
                                    </thead>
                                    <!-- Table body START -->
                                    <tbody class="border-top-0">
                                        @forelse ($orders as $order)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0">{{ $orders->firstItem() + $loop->index }}</h6>
                                            </td>
                                            <td>
                                                <a href="#">#{{ $order->code }}</a>
                                            </td>
                                            <td> {{ $order->created_at->format('d M Y h: A') }} </td>
                                            <td>
                                                {{ formatPrice($order->total) }}
                                            </td>
                                            <td>
                                                <div @class([
                                                    'badge',
                                                    'text-bg-success' => $order->status == 'completed',
                                                    'text-bg-danger' => $order->status == 'cancelled',
                                                    'text-bg-primary' => $order->status == 'pending',
                                                    'text-bg-secondary' => $order->status == 'processing',
                                                    'text-bg-dark' => $order->status == 'on_hold',
                                                ]) class="">{{ str_replace('_',' ',ucfirst($order->status)) }}</div>
                                            </td>
                                            <td>
                                                <a href="{{ route('customer.order.details',encrypt($order->id)) }}" wire:navigate class="btn btn-sm btn-light mb-0">View</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <td colspan="6">No Order Found!</td>
                                        @endforelse

                                    </tbody>
                                    <!-- Table body END -->
                                </table>
                            </div>
						</div>
						<!-- Card body END -->
					</div>
					<!-- Personal info END -->
				</div>
			</div>
			<!-- Main content END -->
		</div>
	</div>
</section>
