
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
                    <div class="card-header-title">Dashboard</div>
                    <div class="row g-4">
                        <!-- Counter item -->
                        <div class="col-sm-6 col-md-4 col-xl-4">
                            <div class="card card-body border">
                                <div class="d-flex align-items-center">
                                    <!-- Icon -->
                                    <div class="icon-xl bg-danger rounded-3 text-white"> <i class="bi bi-cart3"></i> </div>
                                    <!-- Content -->
                                    <div class="ms-3">
                                        <h4>{{ $cartsCount }}</h4> <span>Product in cart</span> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-xl-4">
                            <div class="card card-body border">
                                <div class="d-flex align-items-center">
                                    <!-- Icon -->
                                    <div class="icon-xl bg-info rounded-3 text-white">
                                        <i class="bi bi-bag-heart"></i>
                                    </div>
                                    <!-- Content -->
                                    <div class="ms-3">
                                        <h4>{{ $wishlistsCount }}</h4> <span>Product in wishlist</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-xl-4">
                            <div class="card card-body border">
                                <div class="d-flex align-items-center">
                                    <!-- Icon -->
                                    <div class="icon-xl bg-secondary rounded-3 text-white">
                                        <i class="bi bi-basket"></i>
                                    </div>
                                    <!-- Content -->
                                    <div class="ms-3">
                                        <h4>{{ $totalOrdersCount }}</h4> <span>Total Orders</span>
                                    </div>
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
