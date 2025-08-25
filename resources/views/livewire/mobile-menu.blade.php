<div>
    <div class="iconmobilebottom suto">
		<div class="container">
			<div class="row justify-content-between align-items-center text-center">
				<div class="col-2">
					<div class="mibwrp">
						<a href="{{ url('/') }}" aria-label="Home" class="bi bi-house-door {{ Route::is('home') ? 'active' : '' }}"></a> <small>Home</small> </div>
				</div>
				<div class="col-2">
					<div class="mibwrp">
						<a href="{{ url('led-tv-price-in-bangladesh') }}" aria-label="TV" class="bi bi-list-ul {{ url()->full() == url('led-tv-price-in-bangladesh') ? 'active' : '' }}"></a> <small>TV</small> </div>
				</div>
				<div class="col-2">
					<div class="mibwrp hshop">
						<a href="{{ url('shop?sort=high') }}" aria-label="Shop" class="bi bi-bag {{ Route::is('shop') ? 'active' : '' }}"></a> <small>Shop</small>
                    </div>
				</div>
				<div class="col-2">
                    <div class="mibwrp">
                        <a href="{{ route('cart') }}" class="bi bi-basket"><span class="cartcount">{{ $cartCount }}</span></a>
                        <small>Cart</small>
                    </div>
				</div>
				<div class="col-2">
					<div class="mibwrp">
						<a href="{{ route('customer.dashboard') }}" aria-label="Customer Dashboard" wire:navigate class="bi bi-person-circle {{ Route::is('customer.dashboard') ? 'active' : '' }}"></a> <small>Account</small>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
