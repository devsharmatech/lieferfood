@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <form method="post" action="{{route('vendor.update.delivery-area')}}" class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="hidden" name="id" value="{{ $area->id }}">
                                <label for="postcode" class="form-label">Postcode</label>
                                <input type="text" class="form-control" id="postcode" name="postcode"
                                    placeholder="299393" value="{{ $area->postcode }}">
                                @error('postcode')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City Name</label>
                                <input type="text" class="form-control" id="city" name="city"
                                    placeholder="City name" value="{{ $area->city }}">
                                @error('city')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="village" class="form-label">Village</label>
                                <input type="text" class="form-control" id="village" name="village"
                                    placeholder="Village" value="{{ $area->village }}">
                                @error('village')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="area_name" class="form-label">Area Name</label>
                                <input type="text" class="form-control" id="area_name" name="area_name"
                                    placeholder="london" value="{{ $area->area_name }}">
                                @error('area_name')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="delivery_charge" class="form-label">Delivery Charge (&euro;)</label>
                                <input type="number" step="0.01" class="form-control" id="delivery_charge"
                                    name="delivery_charge" placeholder="5.00" value="{{ $area->delivery_charge }}">
                                @error('delivery_charge')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="min_order_price" class="form-label">Minimum Order Price (&euro;)</label>
                                <input type="number" step="0.01" class="form-control" id="min_order_price"
                                    name="min_order_price" placeholder="20.00" value="{{ $area->min_order_price }}">
                                @error('min_order_price')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="min_order_price_free_delivery" class="form-label">Minimum Price for free
                                    delivery
                                    (&euro;)</label>
                                <input type="number" step="0.01" class="form-control" id="min_order_price_free_delivery"
                                    name="min_order_price_free_delivery" placeholder="25.00"
                                    value="{{ $area->min_order_price_free_delivery }}">
                                @error('min_order_price_free_delivery')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="max_delivery_time" class="form-label">Max Delivery Time (Minutes)</label>
                                <input type="number" step="1" class="form-control" id="max_delivery_time"
                                    name="max_delivery_time" placeholder="30" value="{{ $area->max_delivery_time }}">
                                @error('max_delivery_time')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save Change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

