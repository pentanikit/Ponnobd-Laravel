
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
							<h4 class="card-header-title">Personal Information</h4> </div>
						<!-- Card body START -->
						<div class="card-body">
							<!-- Form START -->
							<form class="row g-3" wire:submit.prevent='updateProfile'>
								<!-- Profile photo -->
								<div class="col-12">
									<label class="form-label">Upload your profile photo<span class="text-danger">*</span></label>
                                    @error('profile_pic')
                                    <div class="text text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <div class="d-flex align-items-center">
										<label class="position-relative me-4" for="uploadProfile" title="Replace this pic">
											<!-- Avatar place holder -->
                                            <span class="avatar avatar-xl">
                                                @if ($profile_pic)
												<img class="avatar-img rounded-circle border border-white border-3 shadow" src="{{ $profile_pic->temporaryUrl() }}" alt="Profile Picture">
                                                @else
												<img class="avatar-img rounded-circle border border-white border-3 shadow" src="{{ profilePic() }}" alt="Profile Picture">
                                                @endif
                                            </span>
                                        </label>
										<!-- Upload button -->
										<label class="btn btn-sm btn-primary-soft mb-0" for="uploadProfile">Change</label>
										<input id="uploadProfile" wire:model='profile_pic' class="form-control d-none" type="file">                                    </div>
								</div>
								<!-- Name -->
                                <div class="col-md-6">
									<label class="form-label">Username</label>
									<input type="text" class="form-control" value="{{ $user->username }}" disabled>
                                </div>
								<div class="col-md-6">
									<label class="form-label">Full Name<span class="text-danger">*</span></label>
									<input type="text" class="form-control" wire:model='name' value="{{ $name }}" placeholder="Enter your full name">
                                </div>
                                <div class="col-md-6">
									<label class="form-label">Mobile number</label>
									<input type="text" class="form-control" wire:model='mobile' value="{{ $mobile }}" placeholder="Enter your mobile number">
                                    @error('mobile')
                                    <div class="text text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
								<!-- Email -->
								<div class="col-md-6">
									<label class="form-label">Email address<span class="text-danger">*</span></label>
									<input type="email" wire:model='email' class="form-control" value="{{ $email }}" placeholder="Enter your email">
                                    @error('email')
                                    <div class="text text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
								<!-- Button -->
								<div class="col-12 text-end">
                                    <button type="submit" href="#" class="btn btn-primary mb-0" wire:loading.attr='disabled'>Save Changes</button>
                                </div>
							</form>
							<!-- Form END -->
						</div>
						<!-- Card body END -->
					</div>
					<!-- Personal info END -->

					<!-- Update Password START -->
					<div class="card border">
						<!-- Card header -->
						<div class="card-header border-bottom">
							<h4 class="card-header-title">Update Password</h4>
						</div>
						<!-- Card body START -->
						<form wire:submit.prevent='updatePassword' class="card-body">
							<!-- Current password -->
							<div class="mb-3">
								<label class="form-label">Current password <span class="text-danger">*</span></label>
								<input class="form-control @error('current_password') is-invalid @enderror" type="password" wire:model='current_password' placeholder="Enter current password">
                                @error('current_password')
                                <div class="text text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
							<!-- New password -->
							<div class="mb-3">
								<label class="form-label"> Enter new password <span class="text-danger">*</span></label>
								<input class="form-control @error('new_password') is-invalid @enderror" placeholder="Enter new password" wire:model='new_password' type="password">
                                @error('new_password')
                                <div class="text text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
							</div>
							<!-- Confirm -->
							<div class="mb-3">
								<label class="form-label">Confirm new password <span class="text-danger">*</span></label>
								<input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" wire:model='password_confirmation' placeholder="Confirm new password">
                                @error('password_confirmation')
                                <div class="text text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
							<div class="text-end">
                                <button type="submit" class="btn btn-primary mb-0">Change Password</button>
                            </div>
						</form>
						<!-- Card body END -->
					</div>
					<!-- Update Password END -->
				</div>
			</div>
			<!-- Main content END -->
		</div>
	</div>
</section>
