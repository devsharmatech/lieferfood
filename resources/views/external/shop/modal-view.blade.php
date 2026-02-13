<div class="row">
    @csrf
    <input type="hidden" name="food_item_id" value="{{ $item->id }}">
    <input type="hidden" name="price_food" value="{{ $item->price }}">
    <input type="hidden" name="quantity" id="cartQuantity" value="1">
    <input type="hidden" name="total_price" id="totalPrice" value="{{ $item->price }}">
    <div class="col-md-12">
        <p class="modal-title fw-bold" id="staticBackdropLabel">
            {{ $item->name }}
            <a href="#"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
        </p>
        @if ($group_items)
            @php

                $groupedFoodItems = [];
                foreach ($group_items as $key => $groupItem) {
                    if (isset($groupItem->food_item)) {
                        $foodName = $groupItem->food_item->food_item_name;

                        if (!isset($groupedFoodItems[$foodName])) {
                            $groupedFoodItems[$foodName] = 0;
                        }

                        $groupedFoodItems[$foodName]++;
                    }
                }
            @endphp
            <ul>
                @foreach ($groupedFoodItems as $foodName => $count)
                    <li>
                        {{ $count }} - {{ $foodName }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>No group items available</p>
        @endif

        @if ($item->description)
            <p>{{ $item->description }}</p>
        @endif

        @if (isset($item->group_items->food_item->ingredients) &&
                is_array(json_decode($item->group_items->food_item->ingredients)))
            <ul>
                @foreach (json_decode($item->group_items->food_item->ingredients) as $ingredient)
                    <li>{{ $ingredient }}</li>
                @endforeach
            </ul>
        @endif

        @if ($item->price)
            <p class="bg-success p-2 d-inline-block text-light rounded-2">
                {{ $item->price }} <i class="fas fa-euro-sign"></i>
                <input type="hidden" value="{{ $item->price }}" id="priceItem">
            </p>
        @endif
    </div>

    @if ($group_items)
        @foreach ($group_items as $key => $groupItem)
            @if (isset($groupItem->food_item))
                <div class="col-12 mb-3">
                    <div class="form-group">
                        <label for="foodItem{{ $key + 1 }}" class="fw-medium">
                            {{ $groupItem->food_item->food_item_name }}
                        </label>
                        <div class="custom-select-wrapper">
                            <div class="custom-select">
                                <input type="hidden" name="foods[]" value="{{ $groupItem->menu_item_id }}">
                                <select id="foodItem{{ $key + 1 }}"
                                    name="group_items[{{ $groupItem->food_item->food_item_name }}][{{ $key }}]">
                                    @if (isset($groupItem->food_item->menu_item_options) && !empty($groupItem->food_item->menu_item_options))
                                        @foreach ($groupItem->food_item->menu_item_options as $option)
                                            <option value="{{ $option->option_name }}">{{ $option->option_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <p>No group items available</p>
    @endif
</div>
