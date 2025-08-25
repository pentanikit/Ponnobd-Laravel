<div>
    <!-- breadcrumb section -->
    <section class="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread d-flex justify-content-center">
                        <ul>
                            <li><a href="{{ url('/') }}" wire:navigate>Home </a></li>
                            <li><a>/ Checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb section -->

    {{-- Section --}}
    <section class="container">
        <form wire:submit.prevent='save'>
            <div class="row mb-5">
                <div class="col-md-8">
                    <div class="col-12 justify-content-center d-flex">
                        <img src="{{ asset('frontend') }}/assets/img/checkout.png" alt="Checkout" title="Checkout">
                    </div>
                    @error('check_terms')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="mt-4">
                        <h4>Billing details</h4>
                        <div class="row mt-4">
                            <div class="col-12 col-md-12">
                                <label for="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model='name' class="form-control @error('name')is-invalid @enderror" placeholder="Full Name">
                                @error('name')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-12 mt-4">
                                <label for="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" wire:model='address' class="form-control @error('address')is-invalid @enderror" placeholder="Enter your full address">
                                @error('address')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-12 mt-4">
                                <label for="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" wire:model='phone' class="form-control @error('phone')is-invalid @enderror" placeholder="Phone">
                                @error('phone')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @guest
                            <div class="col-12 mt-3">
                                <input type="checkbox" wire:model='create_account' value="1" class="form-check-input" id="create-account">
                                <label class="form-check-label" for="create-account">Create an account?</label> <br>
                                <div class="password-field" @if(!$create_account) style="display: none" @endif>
                                    <label class="form-check-label" for="create-account">Create account password <span class="text-danger">*</span></label>
                                    <input type="password" wire:model='password' class="form-control @error('password')is-invalid @enderror" placeholder="Password">
                                    @error('password')
                                    <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @endguest
                            <div class="col-12 col-md-12 mt-4">
                                <label for="form-label">Order notes (optional)</label>
                                <textarea wire:model='notes' class="form-control" rows="4" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <table class="table table-bordered" style="position: static; zoom: 1;">
                        <tbody>
                            @foreach ($carts as $cart)
                            @php
                                $product = $cart->product;
                            @endphp
                            <tr>
                                <td>
                                    <img width="600" height="600" src="{{ uploadedFile($product->thumbnail_img) }}" alt="{{ $product->name }}" sizes="(max-width: 600px) 100vw, 600px">
                                <td>
                                    {{ $product->name }} <br>
                                    <span class="amount">{{ formatPrice($cart->price*$cart->quantity) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Subtotal</th>
                                <td>
                                    {{ formatPrice($carts->sum('price') * $carts->sum('quantity')) }}
                                </td>
                            </tr>
                            <tr>
                                <th>Shipping</th>
                                <td >
                                    <input type="radio" wire:click="updateShipping($event.target.value)" name="shipping_type" value="home_delivery" class="form-check-input" id="home_delivery" @checked($cart->shipping_type == 'home_delivery')>
                                    <label class="form-check-label" for="home_delivery">Home Delivery</label> <br>
                                    <input type="radio" wire:click="updateShipping($event.target.value)" name="shipping_type" value="pickup_from_showroom" class="form-check-input" id="pickup_from_showroom" @checked($cart->shipping_type == 'pickup_from_showroom')>
                                    <label class="form-check-label" for="pickup_from_showroom">Pickup from  Showroom</label> <br>
                                </td>
                            </tr>
                            <tr class="order-total">
                                <th>Total</th>
                                <td>{{ formatPrice($carts->sum('price') * $carts->sum('quantity')) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="payment">

                        <h2 class="kalpurush">ক্যাশ অন ডেলিভারি</h2>
                        <p class="kalpurush dialog">
                            ঢাকার মধ্যে পণ্য বুঝে পাওয়ার পর ক্যাশ টাকার মাধ্যমে পে করতে হবে। ঢাকার বাইরে কুরিয়ারের মাধ্যমে পণ্য নিতে হলে পণ্যের মূল্যের ৫%-১০% বিকাশ/রকেটের মাধ্যমে অগ্রীম প্রদান করতে হবে।
                        </p>
                        <hr>
                        <p>
                            Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.
                        </p>
                        <div class="mt-3">
                            @error('check_terms')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="row">
                                <div class="col-1">
                                    <input type="checkbox" class="form-check-input" wire:model="check_terms" id="terms">
                                </div>
                                <div class="col-11">
                                    <label class="form-check-label" for="terms">
                                        <span> I have read and agree with the policy of {{ config('app.name') }} <a href="{{ route('page','terms-and-conditions') }}">Terms and Conditions.</a></span>
                                     </label>
                                </div>
                            </div>

                        </div>
                        <button type="submit"  class="btn btn-success w-100 text-center">
                            Place order
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
    {{-- Section --}}
</div>
