@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <form method="post" action="{{route('vendor.update.delivery-charge')}}" class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="hidden" name="id" value="{{ $area->id }}">
                                <label for="min_km" class="form-label">Min Km</label>
                                <input type="number" step=".01" class="form-control" id="min_km" name="min_km"
                                    placeholder="0.01" value="{{ $area->min_km }}">
                                @error('min_km')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="max_km" class="form-label">Max Km</label>
                                <input type="number" step=".01" class="form-control" id="max_km" name="max_km"
                                    placeholder="2" value="{{ $area->max_km }}">
                                @error('max_km')
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

