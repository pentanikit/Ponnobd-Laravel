<div class="offcanvas-body p-3 p-lg-0">
    <div class="card bg-light w-100">
        <!-- Edit profile button -->
        <div class="position-absolute top-0 end-0 p-3">
            <a href="{{ route('customer.profile') }}"  wire:navigate class="text-primary-hover" data-bs-toggle="tooltip" data-bs-title="Edit profile"> <i
                    class="bi bi-pencil-square"></i> </a>
        </div>
        <!-- Card body START -->
        <div class="card-body p-3">
            <!-- Avatar and content -->
            <div class="text-center mb-3">
                <!-- Avatar -->
                <div class="avatar avatar-xl mb-2"> <img class="avatar-img rounded-circle border border-2 border-white"
                        src="{{ profilePic() }}" alt="">
                </div>
                <h6 class="mb-0">{{ user('name') }}</h6> <a href="#" class="text-reset text-primary-hover small">{{
                    user('email') }}</a>
                <hr>
            </div>
            <!-- Sidebar menu item START -->
            <ul class="nav nav-pills-primary-soft flex-column">
                <li class="nav-item">
                    <a @class(['nav-link','active'=> Route::is('customer.dashboard')]) href="{{ route('customer.dashboard') }}" wire:navigate><i class="bi bi-house-door fa-fw me-2"></i>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link','active'=> Route::is('customer.orders')]) href="{{ route('customer.orders') }}" wire:navigate><i class="bi bi-basket fa-fw me-2"></i>My Orders</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link','active'=> Route::is('customer.profile')]) href="{{ route('customer.profile') }}" wire:navigate><i class="bi bi-person fa-fw me-2"></i>My Profile</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="account-delete.html"><i class="bi bi-trash fa-fw me-2"></i>Delete Profile</a>
                </li> --}}
                <li class="nav-item" wire:click='logOut'>
                    <a class="nav-link text-danger bg-danger-soft-hover" href="javascript:void(0)"><i class="bi bi-box-arrow-left fa-fw me-2"></i>Sign Out</a>
                </li>
            </ul>
            <!-- Sidebar menu item END -->
        </div>
        <!-- Card body END -->
    </div>
</div>
