@extends('external.frame')
@section('external-css')
    <style>
        body {
            background-color: #f8fafc;
        }

        .badge {
            border-radius: 6px !important;
            font-weight: 600;
            padding: 0.5em 0.75em;
        }

        /* Modern redesign base variables & resets handled in main CSS block below */

        .star {
            font-size: 30px;
            cursor: pointer;
            color: gray;
        }

        .star.selected {
            color: gold;
        }

        .profile-wrapper img {
            border-radius: 50%;
            height: 100%;
            width: 100%;
            object-fit: fill;
            object-position: center;
        }

        .profile-info li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 8px 0px;
        }

        .order-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin: 16px;
            background-color: #fff;
            max-width: 100%;
        }

        .food-name {
            font-size: 1.5em;
            margin-bottom: 8px;
        }

        .order-items,
        .total-price,
        .status {
            margin-bottom: 8px;
        }

        .cancel-order {
            background-color: #f41909;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .cancel-order:hover {
            background-color: #d41106;
        }

        .extra-item {
            display: none;
        }

        .bg-light-warning {
            background: yellow;
        }

        .bg-light-success {
            background: #66FF99;
        }

        .step {
            flex: 1;
            min-width: 70px;
            /* Adjusts spacing for smaller screens */
        }

        .step-icon {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
        }

        @media (max-width: 576px) {
            .step-icon {
                width: 30px;
                height: 30px;
                font-size: 12px;
            }

            .small {
                font-size: 10px;
            }
        }
    </style>
    <style>
        .unread-notification {
            background-color: #f0f8ff;
            border-left: 4px solid #007bff;
        }

        .read-notification {
            background-color: #fff;
            border-left: 4px solid #ddd;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .text-muted {
            color: #000 !important;
            font-size: 14px;
        }

        .notification-item .btn {
            font-size: 12px;
            padding: 3px 8px;
        }
        .border-1{
            border:1px solid gray !important;
        }
    </style>
    <style>
        /* Mobile Responsive Styles */
        .order-list-container {
            max-height: 600px;
            overflow-x: hidden;
        }

        /* Mobile Card */
        .order-card-mobile {
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .order-card-mobile {
                margin-left: -8px;
                margin-right: -8px;
                border-radius: 0;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            .status-badge {
                font-size: 0.75rem;
                padding: 0.25rem 0.75rem;
            }
        }

        /* Progress Tracker Mobile */
        .order-stepper-mobile {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
        }

        @media (max-width: 768px) {
            .order-stepper-mobile {
                padding: 12px;
                margin: 12px 0;
            }
        }

        /* Progress Container */
        .progress-container-mobile .progress-wrapper {
            padding: 0 10px;
        }

        .progress {
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar {
            background: linear-gradient(90deg, #28a745, #20c997);
            transition: width 0.5s ease;
        }

        .progress-bar.cancelled {
            background: linear-gradient(90deg, #dc3545, #e35d6a);
        }

        /* Desktop Steps */
        .step-desktop {
            position: relative;
            text-align: center;
            min-width: 100px;
        }

        .step-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 14px;
            border: 3px solid #e9ecef;
            background: white;
            transition: all 0.3s ease;
        }

        .step-icon.completed {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }

        .step-icon.current {
            background: #20c997;
            color: white;
            border-color: #20c997;
            animation: pulse 2s infinite;
        }

        .step-icon.pending {
            background: #e9ecef;
            color: #6c757d;
            border-color: #dee2e6;
        }

        .step-icon.cancelled {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        /* Mobile Steps */
        .status-scroll-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 10px;
        }

        .status-scroll {
            min-width: 100%;
            padding: 0 5px;
        }

        .step-mobile {
            min-width: 60px;
            flex-shrink: 0;
        }

        .step-icon-mobile {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 13px;
            border: 2px solid #e9ecef;
            background: white;
        }

        .step-icon-mobile.completed {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }

        .step-icon-mobile.current {
            background: #20c997;
            color: white;
            border-color: #20c997;
        }

        .step-icon-mobile.pending {
            background: #e9ecef;
            color: #6c757d;
            border-color: #dee2e6;
        }

        .step-icon-mobile.cancelled {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .step-label-mobile {
            font-size: 11px;
            font-weight: 600;
            margin-top: 4px;
            white-space: nowrap;
        }

        .step-label-mobile.completed {
            color: #28a745;
        }

        .step-label-mobile.current {
            color: #20c997;
            font-weight: 700;
        }

        .step-label-mobile.pending {
            color: #6c757d;
        }

        .step-label-mobile.cancelled {
            color: #dc3545;
            font-weight: 700;
        }

        .step-time-mobile {
            font-size: 9px;
            margin-top: 2px;
        }

        .extra-small {
            font-size: 9px;
        }

        /* Current Status Mobile */
        .current-status-mobile {
            border-left: 4px solid;
        }

        .current-status-mobile.bg-info-subtle {
            border-color: #0dcaf0;
        }

        .current-status-mobile.bg-success-subtle {
            border-color: #198754;
        }

        .current-status-mobile.bg-danger-subtle {
            border-color: #dc3545;
        }

        /* Estimated Time */
        .estimated-time {
            font-size: 12px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .estimated-time {
                font-size: 11px;
                padding: 0.25rem 0.75rem;
            }
        }

        /* Accordion for Mobile Order Items */
        .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
            color: #212529;
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(0, 0, 0, .125);
        }

        /* Hide/Show Elements */
        @media (max-width: 768px) {
            .d-mobile-none {
                display: none !important;
            }

            .d-mobile-block {
                display: block !important;
            }
        }

        @media (min-width: 769px) {
            .d-mobile-none {
                display: block !important;
            }

            .d-mobile-block {
                display: none !important;
            }
        }

        /* Pulse Animation */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(32, 201, 151, 0.7);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(32, 201, 151, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(32, 201, 151, 0);
            }
        }

        /* Scrollbar Styling */
        .status-scroll-container::-webkit-scrollbar {
            height: 4px;
        }

        .status-scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 2px;
        }

        .status-scroll-container::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 2px;
        }

        .status-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }

        .order-list-container::-webkit-scrollbar {
            width: 6px;
        }

        .order-list-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .order-list-container::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }

        .order-list-container::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }

        /* Action Buttons Responsive */
        @media (max-width: 768px) {
            .btn-sm {
                padding: 0.375rem 0.5rem;
                font-size: 0.875rem;
            }

            .flex-fill {
                flex: 1;
            }
        }

        /* Bottom Bar for Mobile */
        .card-footer {
            background: linear-gradient(to right, #f8f9fa, #fff);
        }

        /* Modern Redesign CSS */
        .card {
            border: none;
            border-radius: 16px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px 14px !important;
            font-size: 15px !important;
            font-weight: 400 !important;
            background-color: #fdfdfd !important;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .form-control:focus,
        .form-select:focus,
        .btn:focus,
        .btn-primary:focus,
        .btn-outline-danger:focus,
        .nav-link:focus,
        .accordion-button:focus,
        .page-link:focus {
            background-color: #ffffff;
            border-color: #ef4444 !important;
            outline: 0 !important;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15) !important;
        }

        .form-label {
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #495057;
            margin-bottom: 5px;
        }

        /* Profile Tabs */
        .profiletab {
            gap: 10px;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 5px;
            -webkit-overflow-scrolling: touch;
            border-bottom: 1px solid #f1f5f9;
        }

        .profiletab::-webkit-scrollbar {
            display: none;
        }

        .profiletab {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .profiletab .nav-item a {
            font-size: 15px !important;
            font-weight: 600;
            color: #64748b !important;
            background: transparent;
            border-radius: 10px !important;
            padding: 10px 20px;
            white-space: nowrap;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .profiletab .nav-item a:hover {
            color: #ef4444 !important;
            background-color: #fef2f2;
        }

        .profiletab .nav-item a.active {
            color: #ffffff !important;
            background-color: #ef4444 !important;
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2);
        }

        .profile-info li {
            font-size: 15px !important;
            font-weight: 500;
            color: #334155;
            padding: 14px 0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .profile-info li:last-child {
            border-bottom: none;
        }

        .profile-wrapper {
            height: 130px;
            width: 130px;
            border-radius: 50%;
            border: 4px solid #ffffff;
            box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.3);
            overflow: hidden;
            position: relative;
            margin: 0 auto;
        }

        .btn-primary {
            background-color: #ef4444 !important;
            border-color: #ef4444 !important;
            border-radius: 10px !important;
            font-weight: 600;
            padding: 12px 24px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #dc2626 !important;
            border-color: #dc2626 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3);
        }

        .order-card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }
    </style>
@endsection
@section('external-home-content')
    <section class="py-4 container-fluid px-md-5 overflow-hidden">
        <div class="row mb-5 gx-md-5">
            <div class="col-12">
                <h3 class="fw-bold text-center mb-5">My Account</h3>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-1">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-center">My Profile</h5>

                        <div class="d-flex justify-content-center mb-3">
                            <div class="profile-wrapper">
                                <img src="@if (isset($user->profile) && $user->profile != '') {{ asset('uploads/users/' . $user->profile) }}
                                @else
                                        {{ asset('uploads/users/default.jpg') }} @endif" alt="">
                            </div>
                        </div>
                        <h4 class="text-center fw-bold text-uppercase mb-4"> {{ $user->name . ' ' . $user->surname }} </h4>

                        <ul class="list-unstyled profile-info m-0">
                            <li>
                                <span class="text-muted">
                                    <i class="fa fa-phone-alt text-danger me-2" aria-hidden="true"></i>
                                    Phone
                                </span>
                                <span class="fw-bold text-dark"> {{ $user->phone }} </span>
                            </li>

                            <li>
                                <span class="text-muted">
                                    <i class="fa fa-envelope text-danger me-2" aria-hidden="true"></i>
                                    Email
                                </span>
                                <span class="fw-bold text-dark"> {{ $user->email }} </span>
                            </li>
                            <li class="flex-column align-items-start border-0 pb-0">
                                <span class="text-muted mb-2">
                                    <i class="fa-solid fa-location-dot text-danger me-2" aria-hidden="true"></i>
                                    Address
                                </span>
                                <span class="fw-bold text-dark lh-base"> {{ $user->address }} </span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card h-100 border-0 ">
                    <div class="card-body">
                        <ul class="nav justify-content-center nav-pills profiletab mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a href="{{ route('myaccount') }}?opt=profile"
                                    class="nav-link border-1 @if (isset($_GET['opt']) && $_GET['opt'] == 'profile') active @elseif(!isset($_GET['opt'])) active @endif">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('myaccount') }}?opt=address"
                                    class="nav-link border-1 @if (isset($_GET['opt']) && $_GET['opt'] == 'address') active @endif">Address</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('myaccount') }}?opt=orders"
                                    class="nav-link border-1 @if (isset($_GET['opt']) && $_GET['opt'] == 'orders') active @endif">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('myaccount') }}?opt=table_booking"
                                    class="nav-link border-1 @if (isset($_GET['opt']) && $_GET['opt'] == 'table_booking') active @endif">Table
                                    Booking</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('myaccount') }}?opt=notifications"
                                    class="nav-link border-1 @if (isset($_GET['opt']) && $_GET['opt'] == 'notifications') active @endif">Notifications</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade @if (isset($_GET['opt']) && $_GET['opt'] == 'profile') show active @elseif (!isset($_GET['opt'])) show active @endif"
                                id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <form method="post" enctype="multipart/form-data" action="{{ route('update.my.account') }}"
                                    class="mt-2 row g-3">
                                        @csrf
                                        <div class="col-12 mb-3">
                                            <h5 class="fw-bold text-dark border-bottom pb-2">Edit Profile Details</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}">

                                            @error('name')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="surname" class="form-label">Surname</label>
                                            <input type="text" class="form-control" id="surname" name="surname"
                                                value="{{ $user->surname }}">
                                            @error('surname')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $user->email }}">
                                            @error('email')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="phone" class="form-control" id="phone" name="phone"
                                                value="{{ $user->phone }}">
                                            @error('phone')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">New Password (Optional)</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current">
                                            @error('password')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="file" class="form-label">Profile Image</label>
                                            <input type="file" class="form-control" id="file" name="image">
                                            @error('image')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="address" class="form-label">Default Address</label>
                                            <textarea class="form-control" id="address" name="address" rows="3">{{ $user->address }}</textarea>
                                            @error('address')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>

                                        <div class="col-12 mt-4 text-end">
                                            <button class="btn btn-primary px-5" type="submit">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade @if (isset($_GET['opt']) && $_GET['opt'] == 'address') show active @endif"
                                    id="pills-address" role="tabpanel" aria-labelledby="pills-address-tab">
                                    <form method="post" action="{{ route('update.my.address') }}" class="mt-2 row g-3">
                                        @csrf
                                        <div class="col-12 mb-3">
                                            <h5 class="fw-bold text-dark border-bottom pb-2">Delivery Address</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="country" class="form-label">Country</label>
                                            <select class="form-select" id="country" name="country">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option @selected(isset($user->delivery_address->country) && $country->name == $user->delivery_address->country) value="{{ $country->name }}">
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="state" class="form-label">State</label>
                                            <input type="text" class="form-control" id="state" name="state"
                                                value="{{ isset($user->delivery_address->state) ? $user->delivery_address->state : '' }}">

                                            @error('name')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                value="{{ isset($user->delivery_address->city) ? $user->delivery_address->city : '' }}">
                                            @error('city')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="postal_code" class="form-label">Postal Code (Zip code)</label>
                                            <input type="text" class="form-control" id="postal_code"
                                                name="postal_code"
                                                value="{{ isset($user->delivery_address->postal_code) ? $user->delivery_address->postal_code : '' }}">
                                            @error('postal_code')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="neighborhood" class="form-label">Neighborhood</label>
                                            <input type="text" class="form-control" id="neighborhood"
                                                name="neighborhood"
                                                value="{{ isset($user->delivery_address->neighborhood) ? $user->delivery_address->neighborhood : '' }}">
                                            @error('neighborhood')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="street" class="form-label">Street</label>
                                            <input type="text" class="form-control" id="street" name="street"
                                                value="{{ isset($user->delivery_address->street) ? $user->delivery_address->street : '' }}">
                                            @error('street')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="house_number" class="form-label">House Number</label>
                                            <input type="text" class="form-control" id="house_number"
                                                name="house_number"
                                                value="{{ isset($user->delivery_address->number) ? $user->delivery_address->number : '' }}">
                                            @error('house_number')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="complement" class="form-label">Complement</label>
                                            <input type="text" class="form-control" id="complement"
                                                name="complement"
                                                value="{{ isset($user->delivery_address->complement) ? $user->delivery_address->complement : '' }}">
                                            @error('complement')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-12 mt-4 text-end">
                                            <button class="btn btn-primary px-5" type="submit">Update Address</button>
                                        </div>
                                    </form>
                                </div>
                              <div class="tab-pane fade @if (isset($_GET['opt']) && $_GET['opt'] == 'orders') show active @endif"
        id="pills-orders" role="tabpanel" aria-labelledby="pills-orders-tab">

        <div class="order-list-container">
            @php $orderIndex = 0; @endphp
            @forelse ($orders as $order)
                @php 
                                $orderIndex++;
                    $totalOrderAmount = 0;

                    // Calculate timestamps for each status
                    $statusTimestamps = [
                        'pending' => $order->created_at,
                        'confirmed' => $order->confirmed_at ?? null,
                        'preparing' => $order->preparing_at ?? null,
                        'out_for_delivery' => $order->out_for_delivery_at ?? null,
                        'delivered' => $order->delivered_at ?? null,
                        'cancelled' => $order->cancelled_at ?? null,
                    ];

                    // Status definitions
                    $statuses = [
                        'pending' => [
                            'icon' => 'fa-clock',
                            'label' => 'New Order',
                            'short_label' => 'New',
                            'description' => 'Your order has been received'
                        ],
                        'confirmed' => [
                            'icon' => 'fa-check-circle',
                            'label' => 'Confirmed',
                            'short_label' => 'Confirmed',
                            'description' => 'Restaurant accepted your order'
                        ],
                        'preparing' => [
                            'icon' => 'fa-utensils',
                            'label' => 'Preparing',
                            'short_label' => 'Preparing',
                            'description' => 'Chef is cooking your food'
                        ],
                        'out_for_delivery' => [
                            'icon' => $order->method_type == 'delivery' ? 'fa-motorcycle' : 'fa-user',
                            'label' => $order->method_type == 'delivery' ? 'On the Way' : 'Ready',
                            'short_label' => $order->method_type == 'delivery' ? 'On Way' : 'Ready',
                            'description' => $order->method_type == 'delivery' ? 'Rider is delivering' : 'Ready for pickup'
                        ],
                        'delivered' => [
                            'icon' => 'fa-box-check',
                            'label' => 'Delivered',
                            'short_label' => 'Delivered',
                            'description' => 'Order delivered successfully'
                        ],
                        'cancelled' => [
                            'icon' => 'fa-times-circle',
                            'label' => 'Cancelled',
                            'short_label' => 'Cancelled',
                            'description' => 'Order was cancelled'
                        ]
                    ];

                    $currentStatus = $order->order_status;
                    $isCancelled = $currentStatus == 'cancelled';

                    // Find current status index
                    $statusKeys = array_keys($statuses);
                    $currentIndex = array_search($currentStatus, $statusKeys);
                    if ($currentIndex === false)
                        $currentIndex = 0;

                    // Calculate progress percentage
                    if ($isCancelled) {
                        $progressPercentage = 100;
                    } else {
                        $progressPercentage = ($currentIndex / (count($statuses) - 2)) * 100;
                    }
                @endphp

                <div class="card mb-4 border-0 shadow-sm order-card-mobile">
                    <div class="card-header bg-white">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div class="mb-2 mb-md-0">
                                <h5 class="fw-bold mb-1">Order #{{ $order->id }}</h5>
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fa fa-calendar me-1"></i>
                                    <span>{{ date('M d, Y', strtotime($order->created_at)) }}</span>
                                    <span class="mx-1">•</span>
                                    <span>{{ date('h:i A', strtotime($order->created_at)) }}</span>
                                </small>
                            </div>
                            <div>
                                <span class="badge bg-{{ $isCancelled ? 'danger' : ($currentStatus == 'delivered' ? 'success' : 'primary') }} rounded-pill px-3 py-2 status-badge">
                                    <span class="d-none d-md-inline">{{ ucfirst(str_replace('_', ' ', $currentStatus)) }}</span>
                                    <span class="d-inline d-md-none">{{ strtoupper(substr($currentStatus, 0, 3)) }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-2 p-md-3">
                        <!-- Mobile: Quick Order Summary -->
                        <div class="d-block d-md-none mb-3">
                            <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded">
                                <div>
                                    <small class="text-muted d-block">Total</small>
                                    <strong class="text-primary">
                                        €{{ number_format($totalOrderAmount + $order->method_cost - $order->discount, 2) }}
                                    </strong>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">{{ ucfirst($order->method_type) }}</small>
                                    <small class="fw-bold">{{ $order->order_items->count() }} item(s)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items - Mobile Optimized -->
                        <div class="mb-4 d-none d-md-block">
                            <h6 class="fw-bold mb-3">
                                <i class="fa fa-list me-2"></i>Order Details
                            </h6>
                            @foreach ($order->order_items as $item)
                                <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                                    <div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-light text-dark me-2">{{ $item->quantity }}x</span>
                                            <strong>{{ $item->food_item_name }}</strong>
                                        </div>

                                        @php
                                            $extra_toppings = json_decode($item->extras ?? '[]', true);
                                            $itemTotal = floatval($item->price) * intval($item->quantity);
                                            $totalOrderAmount += $itemTotal;
                                        @endphp

                                        @if (!empty($extra_toppings))
                                            <div class="mt-2 ps-4">
                                                @foreach ($extra_toppings as $extra_topping)
                                                    @php
                                                        $extraPrice = isset($extra_topping['price']) ? floatval($extra_topping['price']) : 0;
                                                        $totalOrderAmount += $extraPrice;
                                                    @endphp
                                                    <small class="d-block text-muted">
                                                        + {{ $extra_topping['name'] }}
                                                        @if($extraPrice > 0)
                                                            <span class="text-success">+€{{ number_format($extraPrice, 2) }}</span>
                                                        @else
                                                            <span class="text-success">Free</span>
                                                        @endif
                                                    </small>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <strong class="text-dark">€{{ number_format($itemTotal, 2) }}</strong>
                                        <div>
                                            <small class="text-muted">€{{ number_format($item->price, 2) }} each</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Mobile: Collapsible Order Items -->
                        <div class="d-block d-md-none mb-3">
                            <div class="accordion" id="orderItems{{ $order->id }}">
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed bg-light py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $order->id }}">
                                            <i class="fa fa-list me-2"></i>
                                            <span class="fw-bold">Order Items ({{ $order->order_items->count() }})</span>
                                            <span class="ms-auto text-primary">View Details</span>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $order->id }}" class="accordion-collapse collapse" data-bs-parent="#orderItems{{ $order->id }}">
                                        <div class="accordion-body p-2">
                                            @foreach ($order->order_items as $item)
                                                <div class="d-flex justify-content-between align-items-start mb-2 pb-2 border-bottom">
                                                    <div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-light text-dark me-2">{{ $item->quantity }}x</span>
                                                            <strong class="small">{{ $item->food_item_name }}</strong>
                                                        </div>
                                                        <div class="text-muted small">€{{ number_format($item->price, 2) }} each</div>
                                                    </div>
                                                    <div class="text-end">
                                                        <strong class="small">€{{ number_format(floatval($item->price) * intval($item->quantity), 2) }}</strong>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="bg-light p-2 p-md-3 rounded mb-4 d-none d-md-block">
                            <h6 class="fw-bold mb-3">
                                <i class="fa fa-receipt me-2"></i>Order Summary
                            </h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span>€{{ number_format($totalOrderAmount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>
                                            <i class="fa fa-{{ $order->method_type == 'delivery' ? 'motorcycle' : 'store' }} me-1"></i>
                                            {{ $order->method_type == 'delivery' ? 'Delivery Fee' : 'Pickup' }}:
                                        </span>
                                        <span class="text-danger">+€{{ number_format($order->method_cost, 2) }}</span>
                                    </div>
                                    @if($order->discount > 0)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>
                                                <i class="fa fa-tag me-1 text-success"></i>
                                                Discount:
                                            </span>
                                            <span class="text-success">-€{{ number_format($order->discount, 2) }}</span>
                                        </div>
                                    @endif
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold fs-5">
                                        <span>Total:</span>
                                        <span class="text-primary">
                                            €{{ number_format($totalOrderAmount + $order->method_cost - $order->discount, 2) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-white p-3 rounded">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fa fa-{{ $order->method_type == 'delivery' ? 'home' : 'store' }} text-primary me-2"></i>
                                            <div>
                                                <small class="text-muted">{{ $order->method_type == 'delivery' ? 'Delivery to' : 'Pickup from' }}</small>
                                                <div class="fw-bold small">{{ $order->delivery_address ?? 'Not specified' }}</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-credit-card text-primary me-2"></i>
                                            <div>
                                                <small class="text-muted">Payment</small>
                                                <div class="fw-bold">{{ ucfirst($order->payment_method) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Order Progress Tracker - Mobile Responsive -->
                        <div class="order-stepper-mobile">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                                <h6 class="fw-bold mb-2 mb-md-0">
                                    <i class="fa fa-map-marker-alt me-2"></i>
                                    <span class="d-none d-md-inline">Order Status</span>
                                    <span class="d-inline d-md-none">Status</span>
                                </h6>
                                @if($currentStatus == 'out_for_delivery' && $order->method_type == 'delivery')
                                    <div class="estimated-time bg-primary text-white px-3 py-1 rounded">
                                        <i class="fa fa-clock me-1"></i>
                                        <span class="d-none d-md-inline">ETA: 25-35 min</span>
                                        <span class="d-inline d-md-none">25-35m</span>
                                    </div>
                                @endif
                            </div>

                            <div class="progress-container-mobile">
                                <!-- Progress Bar -->
                                <div class="progress-wrapper position-relative">
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar {{ $isCancelled ? 'cancelled' : '' }}" 
                                             role="progressbar" 
                                             style="width: {{ $progressPercentage }}%"
                                             aria-valuenow="{{ $currentIndex }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="{{ count($statuses) - 2 }}">
                                        </div>
                                    </div>

                                    <!-- Steps for Desktop -->
                                    <div class="d-none d-md-flex justify-content-between position-relative mt-3">
                                        @foreach($statuses as $statusKey => $statusInfo)
                                            @if($statusKey != 'cancelled')
                                                @php
                                                    $isCompleted = array_search($statusKey, $statusKeys) <= $currentIndex;
                                                    $isCurrent = $statusKey == $currentStatus;
                                                    $stepClass = $isCancelled ? 'cancelled' : ($isCompleted ? 'completed' : ($isCurrent ? 'current' : 'pending'));
                                                    $timestamp = $statusTimestamps[$statusKey] ?? null;
                                                @endphp

                                                <div class="step step-desktop {{ $stepClass }}">
                                                    <div class="step-icon {{ $stepClass }}">
                                                        <i class="fa {{ $statusInfo['icon'] }}"></i>
                                                    </div>
                                                    <div class="step-label {{ $stepClass }} mt-2">
                                                        {{ $statusInfo['label'] }}
                                                    </div>
                                                    @if($timestamp)
                                                        <div class="step-time small text-muted mt-1">
                                                            {{ date('h:i A', strtotime($timestamp)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <!-- Steps for Mobile - Horizontal Scroll -->
                                    <div class="d-flex d-md-none mt-3 status-scroll-container">
                                        <div class="d-flex status-scroll">
                                            @foreach($statuses as $statusKey => $statusInfo)
                                                @if($statusKey != 'cancelled')
                                                    @php
                                                        $isCompleted = array_search($statusKey, $statusKeys) <= $currentIndex;
                                                        $isCurrent = $statusKey == $currentStatus;
                                                        $stepClass = $isCancelled ? 'cancelled' : ($isCompleted ? 'completed' : ($isCurrent ? 'current' : 'pending'));
                                                    @endphp

                                                    <div class="step-mobile text-center mx-2 {{ $stepClass }}">
                                                        <div class="step-icon-mobile {{ $stepClass }} mb-1">
                                                            <i class="fa {{ $statusInfo['icon'] }}"></i>
                                                        </div>
                                                        <div class="step-label-mobile {{ $stepClass }} small">
                                                            {{ $statusInfo['short_label'] }}
                                                        </div>
                                                        @if($isCurrent && $statusTimestamps[$statusKey] ?? null)
                                                            <div class="step-time-mobile extra-small text-muted">
                                                                {{ date('h:i', strtotime($statusTimestamps[$statusKey])) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Status Display for Mobile -->
                                <div class="d-block d-md-none mt-3">
                                    <div class="current-status-mobile bg-{{ $isCancelled ? 'danger' : ($currentStatus == 'delivered' ? 'success' : 'info') }}-subtle p-3 rounded">
                                        <div class="d-flex align-items-center justify-content-start " >
                                            <div class="step-icon-mobile {{ $isCancelled ? 'cancelled' : ($currentIndex == count($statuses) - 2 ? 'completed' : 'current') }} me-3" style="margin:0px !important;">
                                                <i class="fa {{ $statuses[$currentStatus]['icon'] ?? 'fa-info-circle' }}"></i>
                                            </div>
                                            <div style="margin-left:10px;">
                                                <strong class="d-block">{{ $statuses[$currentStatus]['label'] ?? ucfirst($currentStatus) }}</strong>
                                                <small class="text-muted d-block">{{ $statuses[$currentStatus]['description'] ?? 'Your order is being processed' }}</small>
                                                @if($statusTimestamps[$currentStatus] ?? null)
                                                    <small class="text-muted mt-1 d-block">
                                                        <i class="fa fa-clock me-1"></i>
                                                        {{ date('h:i A', strtotime($statusTimestamps[$currentStatus])) }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Messages for Desktop -->
                                <div class="d-none d-md-block">
                                    <div class="alert alert-{{ $isCancelled ? 'danger' : ($currentStatus == 'delivered' ? 'success' : 'info') }} mt-3" role="alert">
                                        <div class="d-flex align-items-center">
                                            <i class="fa {{ $statuses[$currentStatus]['icon'] ?? 'fa-info-circle' }} me-2"></i>
                                            <div>
                                                <strong>{{ $statuses[$currentStatus]['label'] ?? ucfirst($currentStatus) }}</strong>
                                                <div class="small">{{ $statuses[$currentStatus]['description'] ?? 'Your order is being processed' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons - Mobile Optimized -->
                        <div class="mt-4 d-flex flex-column flex-md-row justify-content-between gap-2">
                            <div class="d-flex gap-2">
                                @if($currentStatus == 'pending')
                                    <button class="btn btn-danger btn-sm flex-fill" onclick="cancelOrder({{ $order->id }})">
                                        <i class="fa fa-times me-1"></i>
                                        <span class="d-none d-md-inline">Cancel Order</span>
                                        <span class="d-inline d-md-none">Cancel</span>
                                    </button>
                                @elseif($currentStatus == 'delivered')
                                    <button class="btn btn-success btn-sm flex-fill" onclick="getReview({{ $order->id }}, {{ $order->vendor_id }})">
                                        <i class="fa fa-star me-1"></i>
                                        <span class="d-none d-md-inline">Add Feedback</span>
                                        <span class="d-inline d-md-none">Feedback</span>
                                    </button>
                                @endif
                            </div>

                            <div class="d-flex gap-2">
                                @if($currentStatus != 'cancelled')
                                    <button class="btn btn-primary btn-sm flex-fill" onclick="contactSupport({{ $order->id }})">
                                        <i class="fa fa-headset me-1"></i>
                                        <span class="d-none d-md-inline">Help</span>
                                        <span class="d-inline d-md-none">Help</span>
                                    </button>
                                @endif


                            </div>
                        </div>
                    </div>

                    <!-- Mobile Bottom Bar -->
                    <div class="card-footer bg-white border-top d-block d-md-none py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fa fa-{{ $order->method_type == 'delivery' ? 'motorcycle' : 'store' }} me-1"></i>
                                {{ ucfirst($order->method_type) }}
                            </small>
                            <small class="text-muted">
                                <i class="fa fa-credit-card me-1"></i>
                                {{ ucfirst($order->payment_method) }}
                            </small>

                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fa fa-shopping-cart fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Orders Yet</h4>
                        <p class="text-muted mb-4">You haven't placed any orders yet</p>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                        <i class="fa fa-utensils me-2"></i>Browse Restaurants
                    </a>
                </div>
            @endforelse
        </div>
    </div>

                                <div class="tab-pane fade @if (isset($_GET['opt']) && $_GET['opt'] == 'table_booking') show active @endif"
                                    id="pills-table_booking" role="tabpanel" aria-labelledby="pills-table_booking-tab">
                                    @forelse ($tables as $table)
                                        <div class="card mb-4 border-0 shadow-sm">
                                            <div class="card-body p-4">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3 mb-md-0">
                                                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Booking Details</h6>
                                                        <p class="mb-2"><strong class="text-muted"> Restaurant: </strong>
                                                            <span class="fw-bold">{{ $table->vendor->name }}</span>
                                                        </p>
                                                        <p class="mb-2"><strong class="text-muted"> Visit Date: </strong>
                                                            <span class="fw-bold">{{ date('d F Y', strtotime($table->table_date)) }}</span></p>
                                                        <p class="mb-2"><strong class="text-muted"> Visit Time: </strong>
                                                            <span class="fw-bold">{{ date('h:i A', strtotime($table->slot_time)) }}</span></p>
                                                        <p class="mb-2"><strong class="text-muted"> Food Type: </strong>
                                                            <span class="fw-bold">{{ $table->food_type }}</span></p>
                                                        <p class="mb-0"><strong class="text-muted"> Guests: </strong>
                                                            <span class="fw-bold">{{ $table->guest }}</span></p>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Food Menu & Offers</h6>
                                                        @if (isset($table->foodDetails) && !empty($table->foodDetails))
                                                        <ul class="list-unstyled mb-3">
                                                            @foreach ($table->foodDetails as $item)
                                                                <li class="mb-1"><i class="fa fa-utensils text-danger me-2"></i>{{ $item->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                        @else
                                                        <p class="text-muted mb-3 fst-italic">No food items pre-ordered.</p>
                                                        @endif
                                                        
                                                        @if (isset($table->offer) && json_decode($table->offer) != null)
                                                            @php
                                                                $offer = json_decode($table->offer);
                                                            @endphp
                                                            <div class="bg-light p-3 rounded-3 border-0">
                                                                <h6 class="fw-bold text-success mb-2"><i class="fa fa-tag me-2"></i>Offer Applied</h6>
                                                                <ul class="list-unstyled mb-0 small">
                                                                    <li class="mb-1"><strong class="text-muted">Name:</strong> {{ $offer->title }}</li>
                                                                    <li class="mb-1"><strong class="text-muted">Discount:</strong> <span class="badge bg-success px-2">{{ $offer->discount }}{{ isset($offer->discount_type) && $offer->discount_type == 'percentage' ? '%' : '' }}</span></li>
                                                                    <li class="mb-1"><strong class="text-muted">Max Discount:</strong> {{ $offer->upto_price }}</li>
                                                                    <li class="mb-0"><strong class="text-muted">Valid until:</strong> {{ date('d F Y', strtotime($offer->end_date)) }}</li>
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-between flex-wrap align-items-center">
                                                        <div>
                                                            <span class="text-muted me-2">Booking Status:</span>
                                                        @if ($table->status == 'pending')
                                                            <span class="badge bg-info p-2 px-3 rounded-pill text-white shadow-sm">Pending</span>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-danger px-4 rounded-pill fw-bold"
                                                            onclick="cancelBook({{ $table->id }})">Cancel Booking</button>
                                                        @elseif ($table->status == 'accept')
                                                            <span class="badge bg-success p-2 px-3 rounded-pill text-white shadow-sm">Accepted</span>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-danger px-4 rounded-pill fw-bold"
                                                            onclick="cancelBook({{ $table->id }})">Cancel Booking</button>
                                                        @elseif ($table->status == 'reject')
                                                            <span class="badge bg-danger p-2 px-3 rounded-pill text-white shadow-sm">Rejected</span>
                                                        </div>
                                                        @elseif ($table->status == 'cancelled')
                                                            <span class="badge bg-secondary p-2 px-3 rounded-pill text-white shadow-sm">Cancelled</span>
                                                        </div>
                                                        @else
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                                            <div class="mb-4">
                                                <i class="fa fa-calendar-times fa-4x text-muted mb-3 opacity-50"></i>
                                                <h4 class="text-dark fw-bold">No Bookings Yet</h4>
                                                <p class="text-muted mb-4">You haven't made any table reservations.</p>
                                            </div>
                                            <a href="{{ route('home') }}" class="btn btn-primary px-4">
                                                <i class="fa fa-calendar-check me-2"></i>Book a Table
                                            </a>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="tab-pane fade @if (isset($_GET['opt']) && $_GET['opt'] == 'notifications') show active @endif"
        id="pills-notifications" role="tabpanel" aria-labelledby="pills-notifications-tab">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">My Notifications</h5>
            <button class="btn btn-sm btn-danger" onclick="clearAllNotifications()">
                <i class="fa fa-trash"></i> Clear All
            </button>
        </div>

        <div id="notifications-container" style="max-height: 400px; overflow-x: auto;">
            <!-- Notifications will be loaded here -->
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading notifications...</p>
            </div>
        </div>

    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div id="reviewModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog rounded-1 modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add/Update Feedback</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="reviewForm" action="post">

                            <input type="hidden" name="csrf_token" value="{{ csrf_token() }}" id="csrf_token">
                            <input type="hidden" name="order_id" id="order_id">
                            <input type="hidden" name="vendor_id" id="vendor_id">
                            <div class="mb-0">
                                <label for="content" class="form-label">Feedback</label>
                                <textarea class="form-control bg-white p-3" id="content" name="content" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <div id="rating" class="d-flex">

                                </div>
                            </div>
                            <button type="button" onclick="storeReview()" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('external-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script>
            function cancelOrder(orderId) {

                if (confirm('Are you sure you want to cancel this order?')) {
                    $.ajax({
                        url: '{{ route('order.cancel') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: orderId
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status) {
                                alert('Order canceled successfully.');
                                location.reload();
                            } else {
                                toastr.error(response.message)
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred while canceling the order.');
                        }
                    });
                }
            }

            function cancelBook(tableid) {

                if (confirm('Are you sure you want to cancel this booking?')) {
                    $.ajax({
                        url: '{{ route('cancelBooking') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: tableid
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status) {
                                alert('Booking cancelled successfully.');
                                location.reload();
                            } else {
                                toastr.error(response.message)
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred while canceling the order.');
                        }
                    });
                }
            }
        </script>
        <script>
            function toggleItems(listId, btnId) {
                const listItems = document.querySelectorAll(`#${listId} .extra-item`);
                const button = document.getElementById(btnId);

                if (button.innerText === "+ Show More") {
                    listItems.forEach(item => item.style.display = 'flex');
                    button.innerText = "- Show Less";
                } else {
                    listItems.forEach(item => item.style.display = 'none');
                    button.innerText = "+ Show More";
                }
            }
        </script>
        <script>
            function getReview(orderId, vendorId) {
                $.ajax({
                    url: '{{ route('getReview') }}',
                    method: 'GET',
                    data: {
                        order_id: orderId,
                        vendor_id: vendorId
                    },
                    success: function(response) {
                        if (response.success) {
                            const review = response.data;
                            $('#order_id').val(orderId);
                            $('#vendor_id').val(vendorId);
                            $('#content').val(review ? review.content : '');

                            // Populate rating stars
                            let ratingHtml = '';
                            for (let i = 1; i <= 5; i++) {
                                ratingHtml += `
                            <span class="star ${review && review.rating >= i ? 'selected' : ''}" 
                                  data-value="${i}" 
                                  onclick="setRating(${i})">★</span>`;
                            }
                            $('#rating').html(ratingHtml);

                            $('#reviewModal').modal('show');
                        }
                    }
                });
            }

            function setRating(rating) {
                $('#rating .star').removeClass('selected');
                for (let i = 1; i <= rating; i++) {
                    $(`#rating .star[data-value="${i}"]`).addClass('selected');
                }
            }

            function storeReview() {
                const data = {
                    order_id: $('#order_id').val(),
                    vendor_id: $('#vendor_id').val(),
                    _token: $('#csrf_token').val(),
                    content: $('#content').val(),
                    rating: $('#rating .star.selected').length,
                };

                $.ajax({
                    url: '{{ route('storeReview') }}',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#reviewModal').modal('hide');
                        }
                    }
                });
            }
        </script>


        <script>
    $(document).ready(function() {
        // Load notifications when notifications tab is active
        if(window.location.search.includes('opt=notifications')) {
            loadNotifications();
        }
    });

    function loadNotifications() {
        $.ajax({
            url: '{{ route("notification-list-get") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: '{{ Auth::id() }}'
            },
            success: function(response) {
                if(response.status) {
                    displayNotifications(response.data);
                } else {
                    $('#notifications-container').html('<div class="text-center py-5"><p class="text-danger">Failed to load notifications</p></div>');
                }
            },
            error: function() {
                $('#notifications-container').html('<div class="text-center py-5"><p class="text-danger">Error loading notifications</p></div>');
            }
        });
    }

    function displayNotifications(notifications) {
        if(notifications.length === 0) {
            $('#notifications-container').html('<div class="text-center py-5"><p class="text-muted">No notifications yet</p></div>');
            return;
        }

        let html = '';
        notifications.forEach(function(notification) {
            const timeAgo = moment(notification.created_at).fromNow();
            const isRead = notification.is_read ? 'read-notification' : 'unread-notification';

            html += `
            <div class="card mb-2 notification-item ${isRead}" id="notification-${notification.id}">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1 me-3">
                            <h6 class="fw-bold mb-1 ${notification.is_read ? '' : 'text-dark'}">${notification.title}</h6>
                            <p class="mb-1">${notification.message}</p>
                            <small class="text-muted">
                                <i class="fa fa-clock"></i> ${timeAgo}
                                <span class="ms-2">
                                    <i class="fa fa-tag"></i> ${notification.type}
                                </span>
                            </small>
                        </div>
                        <div class="d-flex flex-column">
                            <button class="btn btn-sm ${notification.is_read ? 'btn-outline-success' : 'btn-success'} mb-1" 
                                    onclick="markAsRead(${notification.id})" 
                                    ${notification.is_read ? 'disabled' : ''}>
                                ${notification.is_read ? '<i class="fa fa-check"></i> Read' : 'Mark as Read'}
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteNotification(${notification.id})">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
        });

        $('#notifications-container').html(html);
    }

    function markAsRead(notificationId) {
        $.ajax({
            url: '{{ route("notification-read") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: notificationId
            },
            success: function(response) {
                if(response.status) {
                    // Update UI
                    $(`#notification-${notificationId}`).removeClass('unread-notification').addClass('read-notification');
                    $(`#notification-${notificationId} .btn-success`).html('<i class="fa fa-check"></i> Read').removeClass('btn-success').addClass('btn-outline-success').prop('disabled', true);
                    $(`#notification-${notificationId} h6`).removeClass('text-dark');

                    // Update notification badge count if exists
                    updateNotificationBadge();
                }
            }
        });
    }

    function deleteNotification(notificationId) {
        if(!confirm('Are you sure you want to delete this notification?')) return;

        $.ajax({
            url: '{{ route("notification-delete") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: notificationId
            },
            success: function(response) {
                if(response.status) {
                    $(`#notification-${notificationId}`).remove();

                    // Check if any notifications left
                    if($('.notification-item').length === 0) {
                        $('#notifications-container').html('<div class="text-center py-5"><p class="text-muted">No notifications yet</p></div>');
                    }
                }
            }
        });
    }

    function clearAllNotifications() {
        if(!confirm('Are you sure you want to clear all notifications?')) return;

        $.ajax({
            url: '{{ route("notification-clear") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: '{{ Auth::id() }}'
            },
            success: function(response) {
                if(response.status) {
                    $('#notifications-container').html('<div class="text-center py-5"><p class="text-muted">No notifications yet</p></div>');

                    // Update notification badge count if exists
                    updateNotificationBadge();
                }
            }
        });
    }

    function updateNotificationBadge() {
        // If you have a notification badge in your header, update it here
        // Example: $('#notification-badge').text('0');
    }
    </script>
@endsection
