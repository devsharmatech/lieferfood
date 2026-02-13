@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">My Details</span> </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="@if ($user->profile) {{ asset('uploads/users/' . $user->profile) }}
                                            @else
                                                {{ asset('uploads/avtarlg.jpg') }} @endif"
                                alt="user-avatar" class="d-block rounded" height="100" width="100"
                                id="uploadedAvatar" />
                            <div class="button-wrapper">
                                
                                <p class="text-muted mb-0 text-uppercase">Vendor Id: {{ 'PIZ' . str_pad($user->id, 2, '0', STR_PAD_LEFT)}}</p>
                                <p class="text-muted mb-0 text-uppercase">Secret Code: {{ 'ENC-' . str_pad($user->id+13, 2, '0', STR_PAD_LEFT)}}</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <form method="POST" id="vendor-profile-form" enctype="multipart/form-data" >
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="row">
                                <input type="file" id="upload" name="image" class="account-file-input" hidden
                                    accept="image/png, image/jpeg" />
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Shop Name</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ $user->name }}" placeholder="Shop Name..." autofocus />
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="surnameGivename" class="form-label">Vendor Surname / Given Name</label>
                                    <input class="form-control" type="text" name="surnameGivename" id="surnameGivename"
                                        value="{{ $user->vendor_details->vendor_full_name ?? '' }}" />
                                    @error('surnameGivename')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Street, House Number</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Address" value="{{ $user->address }}" />
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="zipCode" class="form-label">Zip Code / PLZ</label>
                                    <input type="text" class="form-control" id="zipCode" name="zipcode"
                                        placeholder="231465" maxlength="6" value="{{ $user->zipcode }}" />
                                    @error('zipcode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="city" class="form-label">City / Stadt</label>
                                    <input class="form-control" type="text" id="city" name="city"
                                        placeholder="City" value="{{ $user->city }}" />
                                    @error('city')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="state" class="form-label">State / Bundesland</label>
                                    <input class="form-control" type="text" id="state" name="state"
                                        placeholder="California" value="{{ $user->state }}" />
                                    @error('state')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>



                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phone">Shop Phone Number</label>
                                    <div class="input-group input-group-merge">

                                        <input type="text" id="phone" name="phone" class="form-control"
                                            placeholder="202 555 0111" value="{{ $user->phone }}" />
                                    </div>
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Shop Email</label>
                                    <input class="form-control" type="email" id="email" name="email"
                                        value="{{ $user->email }}" placeholder="john.doe@example.com" />
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="commission" class="form-label">Commission (%)</label>
                                    <select class="form-control form-select"  id="commission" name="commission">
                                        @for($i=1; $i<=50; $i++)
                                          
                                          <option @selected(isset($user->vendor_details->commission) && $user->vendor_details->commission==$i) value="{{$i}}">{{$i}} %</option>
                                        @endfor
                                    </select>
                                    @error('commission')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                 <div class="mb-3 col-md-6">
                                    <label for="paypal_commission" class="form-label">Paypal Commission (%)</label>
                                    <input class="form-control" step="0.01" type="number" id="paypal_commission" name="paypal_commission"
                                        value="{{ isset($user->vendor_details->paypal_commission) ? $user->vendor_details->paypal_commission : '' }}" placeholder="Paypal Commission (%)" />
                                    @error('paypal_commission')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                 <div class="mb-3 col-md-6">
                                    <label for="stripe_commission" class="form-label">Stripe Commission (%)</label>
                                    <input class="form-control" step="0.01" type="number" id="stripe_commission" name="stripe_commission"
                                        value="{{ isset($user->vendor_details->stripe_commission) ? $user->vendor_details->stripe_commission : '' }}" placeholder="Stripe Commission (%)" />
                                    @error('stripe_commission')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                 <div class="mb-3 col-md-6">
                                    <label for="credit_card_commission" class="form-label">Credit Card Commission (%)</label>
                                    <input class="form-control" step="0.01" type="number" id="credit_card_commission" name="credit_card_commission"
                                        value="{{ isset($user->vendor_details->credit_card_commission) ? $user->vendor_details->credit_card_commission : '' }}" placeholder="Credit card Commission (%)" />
                                    @error('credit_card_commission')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="country">Country / Land</label>
                                    <select id="country" name="country" class="select2 form-select">
                                        <option value="">Select</option>
                                        @if (isset($countries) && !empty($countries))
                                            @foreach ($countries as $country)
                                                <option @selected($user->country == $country->name) value="{{ $country->name }}">
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    @error('country')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="language" class="form-label">Language / Sprache</label>
                                    <select id="language" name="language" class="select2 form-select">
                                        <option value="">Select Language</option>
                                        <option @selected($user->language == 'en') value="en">English</option>
                                        <option @selected($user->language == 'fr') value="fr">French</option>
                                        <option @selected($user->language == 'de') value="de">German</option>
                                        <option @selected($user->language == 'pt') value="pt">Portuguese</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="logo" class="form-label">Logo</label>
                                    <input type="file" name="logo" id="logo" accept="image/*"
                                        class="form-control">
                                    @error('logo')
                                        <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                    <div class="mt-2">
                                        @if (isset($user->vendor_details->logo) && !empty($user->vendor_details->logo))
                                            <img src="{{ asset('uploads/logo/' . $user->vendor_details->logo) }}"
                                                style="height: 4rem; width:4rem;" alt="">
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="banner" class="form-label">Shop Banner (1200 X 400px)</label>
                                    <input type="file" name="banner" id="banner" accept="image/*"
                                        class="form-control">
                                    @error('banner')
                                        <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                    <div class="mt-2">
                                        @if (isset($user->vendor_details->banner) && !empty($user->vendor_details->banner))
                                            <img src="{{ asset('uploads/banner/' . $user->vendor_details->banner) }}"
                                                style="height: 4rem;" alt="">
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="categories" class="form-label">Area Of Categories</label>
                                    <select id="categories" name="categories[]"
                                        class="select2 form-select js-example-responsive" multiple="multiple"
                                        style="width: 100%">
                                        <option value="">Select</option>
                                        @if (isset($categories) && count($categories) > 0)
                                            @foreach ($categories as $category)
                                                @php
                                                    $selected = false;
                                                    if (
                                                        isset($user->vendor_details->categories) &&
                                                        $user->vendor_details->categories != null &&
                                                        json_decode($user->vendor_details->categories) != null
                                                    ) {
                                                        $selected = in_array(
                                                            $category->id,
                                                            json_decode($user->vendor_details->categories),
                                                        );
                                                    } else {
                                                        $selected = false;
                                                    }

                                                @endphp
                                                <option @selected($selected) value="{{ $category->id }}">
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('categories')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="free_delivery" class="form-label">Free Delivery / Lieferkosten</label>
                                    <select name="free_delivery" id="free_delivery" class="form-select select2">
                                        <option value="1" @selected(isset($user->vendor_details->delivery_free) && $user->vendor_details->delivery_free == '1')>Yes</option>
                                        <option value="0" @selected(isset($user->vendor_details->delivery_free) && $user->vendor_details->delivery_free == '0')>No</option>
                                    </select>
                                    @error('free_delivery')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="delivery_cost" class="form-label">Delivery Cost / Lieferkosten</label>
                                    <input type="number" class="form-control" id="delivery_cost" name="delivery_cost"
                                        placeholder="Delivery Cost" step="0.01"
                                        value="{{ isset($user->vendor_details->delivery_cost) ? $user->vendor_details->delivery_cost : '' }}" />
                                    @error('delivery_cost')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="restaurant_status" class="form-label">Restaurant Status</label>
                                    <select name="restaurant_status" id="restaurant_status" class="form-select select2">
                                        <option value="1" @selected(isset($user->vendor_details->restaurant_status) && $user->vendor_details->restaurant_status == '1')>Open</option>
                                        <option value="0" @selected(isset($user->vendor_details->restaurant_status) && $user->vendor_details->restaurant_status == '0')>Close</option>
                                    </select>
                                    @error('restaurant_status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="minimum_order_price" class="form-label">Minimum Order Price</label>
                                    <input type="number" class="form-control" id="minimum_order_price"
                                        name="minimum_order_price" step="0.01"
                                        value="{{ isset($user->vendor_details->minimum_price) ? $user->vendor_details->minimum_price : '' }}" />
                                    @error('minimum_order_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                 <div class="mb-3 col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="6" class="form-control">{{ isset($user->vendor_details->description) ? $user->vendor_details->description : '' }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <h5 class="text-muted my-3">Order Received By</h5>
                                 <div class="mb-3 col-md-6">
                                   <div class="form-check">
                                     <input @checked(isset($user->vendor_details->byemail) && $user->vendor_details->byemail == '1') class="form-check-input" name="isReceivedByMail" type="checkbox"  id="isReceivedByMail" >
                                     <label class="form-check-label" for="isReceivedByMail">
                                       By Mail
                                     </label>
                                   </div>
                                   <div class="form-check">
                                     <input @checked(isset($user->vendor_details->bywinorder) && $user->vendor_details->bywinorder == '1') class="form-check-input" name="isReceivedByWinorder" type="checkbox"  id="isReceivedByWinorder" >
                                     <label class="form-check-label" for="isReceivedByWinorder">
                                       By Winorder
                                     </label>
                                   </div>
                                   <div class="form-check">
                                     <input @checked(isset($user->vendor_details->bysmartorder) && $user->vendor_details->bysmartorder == '1') class="form-check-input" name="isReceivedBySmartOrder" type="checkbox" id="isReceivedBySmartOrder" >
                                     <label class="form-check-label" for="isReceivedBySmartOrder">
                                       By Order Smart
                                     </label>
                                   </div>
                                </div>
                                
                                <h5 class="text-muted my-3">Company Details / Business Details </h5>
                                <div class="mb-3 col-md-4">
                                    <label for="company_service" class="form-label">Delivery Service</label>
                                    <select id="company_service" name="isDelivery" class="select2 form-select">
                                        <option value="">Select</option>
                                        <option @selected(isset($user->vendor_details->isDelivery) && $user->vendor_details->isDelivery == '1') value="1">Active</option>
                                        <option @selected(isset($user->vendor_details->isDelivery) && $user->vendor_details->isDelivery == '0') value="0">Inactive</option>
                                    </select>
                                    @error('isDelivery')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="company_service1" class="form-label">Pickup Service</label>
                                    <select id="company_service1" name="isPickup" class="select2 form-select">
                                        <option value="">Select</option>
                                        <option @selected(isset($user->vendor_details->isPickup) && $user->vendor_details->isPickup == '1') value="1">Active</option>
                                        <option @selected(isset($user->vendor_details->isPickup) && $user->vendor_details->isPickup == '0') value="0">Inactive</option>
                                    </select>
                                    @error('isPickup')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                        placeholder="Company Name"
                                        value="{{ isset($user->vendor_details->company_name) ? $user->vendor_details->company_name : '' }}" />
                                    @error('company_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="restuarnat_title" class="form-label">Restaurant Title</label>
                                    <input type="text" class="form-control" id="restuarnat_title"
                                        name="restuarnat_title" placeholder="Italian style pizza, Burgers"
                                        value="{{ isset($user->vendor_details->restuarnat_title) ? $user->vendor_details->restuarnat_title : '' }}" />
                                    @error('restuarnat_title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="min_prepare_time" class="form-label">Minimum Prepare Time
                                        (Minutes)</label>
                                    <input type="number" class="form-control" id="min_prepare_time"
                                        name="min_prepare_time" placeholder="Minimum Prepare Time"
                                        value="{{ isset($user->vendor_details->min_prepare_time) ? $user->vendor_details->min_prepare_time : '' }}" />
                                    @error('min_prepare_time')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="max_prepare_time" class="form-label">Maximum Prepare Time
                                        (Minutes)</label>
                                    <input type="number" class="form-control" id="max_prepare_time"
                                        name="max_prepare_time" placeholder="Maximum Prepare Time"
                                        value="{{ isset($user->vendor_details->max_prepare_time) ? $user->vendor_details->max_prepare_time : '' }}" />
                                    @error('max_prepare_time')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="company_email" class="form-label">Company Email</label>
                                    <input type="email" class="form-control" id="company_email" name="company_email"
                                        placeholder="Company Email"
                                        value="{{ isset($user->vendor_details->company_email) ? $user->vendor_details->company_email : '' }}" />
                                    @error('company_email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="company_phone" class="form-label">Company Phone</label>
                                    <input type="tel" class="form-control" id="company_phone" name="company_phone"
                                        placeholder="Company Phone"
                                        value="{{ isset($user->vendor_details->company_phone) ? $user->vendor_details->company_phone : '' }}" />
                                    @error('company_phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                                    <label for="company_street" class="form-label">Company Street,
                                                        House Number</label>
                                                    <input type="text" class="form-control" id="company_street"
                                                        name="company_street"
                                                        placeholder="Company Street, House Number" value="{{ isset($user->vendor_details->company_street) ? $user->vendor_details->company_street : '' }}" />
                                                         @error('company_street')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                                </div>
                                <div class="mb-3 col-md-6">
                                                    <label for="company_zipcode" class="form-label">Zip Code /
                                                        PLZ</label>
                                                    <input type="text" class="form-control" id="company_zipcode"
                                                        name="company_zipcode" placeholder="231465" maxlength="6"
                                                        value="{{ isset($user->vendor_details->company_zipcode) ? $user->vendor_details->company_zipcode : '' }}" />
                                                        @error('company_zipcode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                                </div>
                                <div class="mb-3 col-md-6">
                                                    <label for="company_city" class="form-label">Company City /
                                                        Stadt</label>
                                                    <input class="form-control" type="text" id="company_city"
                                                        name="company_city" placeholder="City" value="{{ isset($user->vendor_details->company_city) ? $user->vendor_details->company_city : '' }}" />
                                                        @error('company_city')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                                </div>
                                <div class="mb-3 col-md-6">
                                                    <label for="company_state" class="form-label">Company State /
                                                        Bundesland</label>
                                                    <input class="form-control" type="text" id="company_state"
                                                        name="company_state" placeholder="California"
                                                        value="{{ isset($user->vendor_details->company_state) ? $user->vendor_details->company_state : '' }}" />
                                                        @error('company_state')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="company_country">Country / Land</label>
                                    <select id="company_country" name="company_country" class="select2 form-select">
                                        <option value="">Select</option>
                                        @if (isset($countries) && !empty($countries))
                                            @foreach ($countries as $country)
                                                <option @selected(isset($user->vendor_details->company_country) && $user->vendor_details->company_country == $country->name) value="{{ $country->name }}">
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    @error('company_country')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>                
                                <div class="mb-3 col-md-6">
                                    <label for="steuernummer" class="form-label">Steuernummer / Vat</label>
                                    <input type="text" class="form-control" id="steuernummer" name="steuernummer"
                                        placeholder="Steuernummer" required
                                        value="{{ isset($user->vendor_details->gst_number) ? $user->vendor_details->gst_number : '' }}" />
                                    @error('Steuernummer')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="pan_number" class="form-label">Steuer Id / Tin</label>
                                    <input type="text" class="form-control" id="steuerId" name="steuerId"
                                        placeholder="Steuer Id."
                                        value="{{ isset($user->vendor_details->pan_number) ? $user->vendor_details->pan_number : '' }}" />
                                    @error('steuerId')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="vat" class="form-label">Umsatzsteuer - ID / EU-VAT</label>
                                    <input type="text" class="form-control" id="vat" name="vat"
                                        placeholder="Umsatzsteuer - ID / EU-VAT"
                                        value="{{ isset($user->vendor_details->vat) ? $user->vendor_details->vat : '' }}" />
                                    @error('vat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                 <div class="col-12">
                                 <h5 class="text-muted my-3">Bank Details </h5>
                                </div>
                                                
                                 <div class="mb-3 col-md-6">
                                    <label for="bank_name" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name"
                                        value="{{ isset($user->vendor_details->bank_name) ? $user->vendor_details->bank_name : '' }}" />
                                    @error('bank_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>                
                                <div class="mb-3 col-md-6">
                                    <label for="bank_account_number" class="form-label">Bank Account/IBAN</label>
                                    <input type="text" class="form-control" id="bank_account_number"
                                        name="bank_account_number" placeholder="Company Bank Account Number"
                                        value="{{ isset($user->vendor_details->bank_account_number) ? $user->vendor_details->bank_account_number : '' }}" />
                                    @error('bank_account_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="bic" class="form-label">BIC</label>
                                    <input type="text" class="form-control" id="bic" name="bic"
                                        placeholder="Company Bank BIC"
                                        value="{{ isset($user->vendor_details->bank_ifsc_code) ? $user->vendor_details->bank_ifsc_code : '' }}" />
                                    @error('bic')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="bank_account_holder_name" class="form-label">Holder Name</label>
                                    <input type="text" class="form-control" id="bank_account_holder_name"
                                        name="bank_account_holder_name" placeholder="Company Bank Holder Name"
                                        value="{{ isset($user->vendor_details->bank_account_holder_name) ? $user->vendor_details->bank_account_holder_name : '' }}" />
                                    <input type="hidden" name="company_id"
                                        value="{{ isset($user->vendor_details->id) ? $user->vendor_details->id : '' }}">
                                    @error('bank_account_holder_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                               
                               


                            </div>
                           
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
                
            </div>
        </div>
    </div>
@endsection
@section('vendor_custome_script')
    <script>
        $(document).ready(function() {
            $('#upload').on('change', function() {
                var fileInput = this;
                var file = fileInput.files[0];

                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#uploadedAvatar').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('.account-image-reset').on('click', function() {
                $('#uploadedAvatar').attr('src', '{{ asset('uploads/avtarlg.jpg') }}');
                $('#upload').val('');
            });
        });
    </script>
    <script>
        $(".js-example-responsive").select2({
            width: 'resolve'
        });
      
    </script>
    <script>
    // Disable form submission
    document.getElementById('vendor-profile-form').addEventListener('submit', function (event) {
        event.preventDefault();
        alert('Form submission is disabled.');
    });

    // Make all fields read-only or disabled
    const formFields = document.querySelectorAll('#vendor-profile-form input, #vendor-profile-form textarea, #vendor-profile-form select');
    formFields.forEach(field => {
        field.setAttribute('readonly', true);
        field.setAttribute('disabled', true);
    });
</script>
@endsection
