<?php

namespace App\Http\Controllers;

use App\Models\add_favorite;
use App\Models\category;
use App\Models\gallery;
use App\Models\slot_offer;
use App\Models\slots;
use App\Models\VendorTableTime;
use App\Models\table_booking;
use App\Models\table_food;
use App\Models\table_service;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TableServiceController extends Controller
{
    //
    public function tableService()
    {
        $id = auth()->user()->id;
        $table_service = table_service::where('vendor_id', $id)->first();
        
        $gallery = gallery::latest()->where('vendor_id', $id)->get();
        return view('vendor.table.table-service', compact('table_service', 'gallery'));
    }
    function generateSlots($openTime, $closeTime, $interval = 30)
    {

        $start = DateTime::createFromFormat('h:i A', $openTime);
        $end = DateTime::createFromFormat('h:i A', $closeTime);
        $end->modify('+1 minute');

        $slots = [];

        while ($start < $end) {
            $slots[] = [
                'time' => $start->format('H:i:s')
            ];
            $start->modify("+{$interval} minutes");
        }

        return $slots;
    }
    public function tableServiceStore(Request $request)
    {
        $id = auth()->user()->id;
        $request->validate([
            'table_service_status' => ['required'],
            'holiday' => ['required', 'string'],
            'open_time' => ['required', 'date_format:h:i A'],
            'close_time' => ['required', 'date_format:h:i A', 'after:open_time'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif'],

        ]);
        $tableService = table_service::where('vendor_id', $id)->first();
        if ($tableService) {
            $tableService->status = $request->table_service_status;
            $tableService->vendor_id = $id;
            $tableService->day_off = $request->holiday;
            $tableService->open_time = $request->open_time;
            $tableService->close_time = $request->close_time;
            // add gallery images
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $file) {
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read($file);
                    $filename = uniqid('image_') . '.' . $file->getClientOriginalExtension();
                    $image->resize(1200, 400)->save(public_path('uploads/gallery/' . $filename));
                    $gallery = new gallery();
                    $gallery->vendor_id = $id;
                    $gallery->image = $filename;
                    $gallery->status = 1;
                    $gallery->save();
                }
            }
            $tableService->slots = 1;
            $tableService->save();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Table Service Updated Successfully']);
        } else {
            $slots = $this->generateSlots($request->open_time, $request->close_time, 30);
            if (!empty($slots) && is_array($slots)) {
                $tableService = new table_service();
                $tableService->status = $request->table_service_status;
                $tableService->vendor_id = $id;
                $tableService->day_off = $request->holiday;
                $tableService->open_time = $request->open_time;
                $tableService->close_time = $request->close_time;
                if ($request->hasFile('images')) {
                    $images = $request->file('images');
                    foreach ($images as $file) {
                        $manager = new ImageManager(Driver::class);
                        $image = $manager->read($file);
                        $filename = uniqid('image_') . '.' . $file->getClientOriginalExtension();
                        $image->resize(1200, 400)->save(public_path('uploads/gallery/' . $filename));
                        $gallery = new gallery();
                        $gallery->vendor_id = $id;
                        $gallery->image = $filename;
                        $gallery->status = 1;
                        $gallery->save();
                    }
                }
                foreach ($slots as $slot) {

                    $slotB = new slots();
                    $slotB->vendor_id = $id;
                    $slotB->time = $slot['time'];
                    $slotB->status = 1;
                    $slotB->save();
                }
                $tableService->slots = 1;
                $tableService->save();
                return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Table Service Updated Successfully']);
            } else {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Sorry slots are not created.']);
            }
        }
    }
    public function delete($img_id)
    {
        $id = auth()->user()->id;
        $image = gallery::where('id', $img_id)->where('vendor_id', $id)->first();

        if (!empty($image)) {
            $oldPath = public_path('uploads/gallery/' . $image->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $image->delete();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Image deleted successfully!']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Image not found!']);
        }
    }
    public function timeSlots()
    {
        $id = auth()->user()->id;
        $slots = slots::orderBy('time', 'ASC')->where('vendor_id', $id)->get();
        return view('vendor.table.table-slots', compact('slots'));
    }
    public function addTimeSlots(Request $request)
    {
        $id = auth()->user()->id;
    }
    public function deleteSlot($slid)
    {
        $id = auth()->user()->id;
        $slot = slots::where('id', $slid)->where('vendor_id', $id)->first();
        if (!empty($slot)) {
            $slot->delete();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Slot deleted successfully!']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Slot not found.']);
        }
    }
    public function changeStatus($slot_id)
    {
        $id = auth()->user()->id;
        $slot = slots::where('id', $slot_id)->where('vendor_id', $id)->first();
        if (!empty($slot)) {
            $slot->status = $slot->status == 1 ? 0 : 1;
            $slot->save();

            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Slot status updated successfully!']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Slot not found.']);
        }
    }
    public function createSlot()
    {
        return view('vendor.table.add-slot');
    }
    public function addSlot(Request $request)
    {
        try {

            $id = auth()->user()->id;
            $request->validate(['slot' => ['required']]);
            $slot = new slots();
            $slot->vendor_id = $id;
            $slot->time = $request->slot;
            $slot->save();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Slot added successfully!']);
        } catch (Exception $e) {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => "You have already created this slot"]);
        }
    }
    public function slotOffers()
    {
        $id = auth()->user()->id;
        $offers = slot_offer::where('vendor_id', $id)->with('slot')->get();
        return view('vendor.table.offers.slots-offers', compact('offers'));
    }
    public function createOffer()
    {
        $id = auth()->user()->id;
        $slots = VendorTableTime::where('vendor_id', $id)->orderBy('id', 'ASC')->get();
        return view('vendor.table.offers.add-offer', compact('slots'));
    }
    public function storeSlotOffer(Request $request)
    {

        $id = auth()->user()->id;
        $request->validate([
            'title' => ['required', 'string'],
            'time_id' => ['required', 'exists:vendor_table_times,id'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'discount_type' => ['required', 'in:fixed,percentage'],
            'discount' => ['required', 'numeric'],
            'upto_price' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image']
        ]);
        $offer = new slot_offer();
        $offer->vendor_id = $id;
        $offer->title = $request->title;
        $offer->description = $request->description;
        $offer->discount_type = $request->discount_type;
        $offer->discount = $request->discount;
        $offer->start_date = $request->start_date;
        $offer->end_date = $request->end_date;
        $offer->upto_price = $request->upto_price;
        $offer->slot_id = $request->time_id;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($file);
            $filename = uniqid('offer_') . '.' . $file->getClientOriginalExtension();
            $image->resize(200, 200)->save(public_path('uploads/offer/' . $filename));

            $offer->image = $filename;
        }
        $offer->save();
        return redirect()->route('vendor.slot.offers')->with(['alert-type' => 'success', 'message' => 'Offer added Successfully']);
    }
    public function updateSlotOffer(Request $request)
    {

        $id = auth()->user()->id;
        $request->validate([
            'id' => ['required', 'exists:slot_offers,id'],
            'title' => ['required', 'string'],
            'time_id' => ['required', 'exists:vendor_table_times,id'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'discount_type' => ['required', 'in:fixed,percentage'],
            'discount' => ['required', 'numeric'],
            'upto_price' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image']
        ]);
        $offer = slot_offer::where('id', $request->id)->first();

        if ($offer) {
            $offer->title = $request->title;
            $offer->description = $request->description;
            $offer->discount_type = $request->discount_type;
            $offer->discount = $request->discount;
            $offer->start_date = $request->start_date;
            $offer->end_date = $request->end_date;
            $offer->upto_price = $request->upto_price;
            $offer->slot_id = $request->time_id;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $manager = new ImageManager(Driver::class);
                $oldPath = public_path('uploads/offer/' . $offer->image);
                $image = $manager->read($file);
                $filename = uniqid('offer_') . '.' . $file->getClientOriginalExtension();
                $image->resize(200, 200)->save(public_path('uploads/offer/' . $filename));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $offer->image = $filename;
            }
            $offer->save();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Offer added Successfully']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Offer not found']);
        }
    }

    public function deleteSlotOffer($offer_id)
    {
        $id = auth()->user()->id;
        $offer = slot_offer::where('vendor_id', $id)->where('id', $offer_id)->first();
        if (!empty($offer)) {
            $oldPath = public_path('uploads/offer/' . $offer->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            return back()->with(['alert-type' => 'success', 'message' => 'Slot offer deleted successfully.']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Slot offer not found!']);
        }
    }
    public function changeStatusSlotOffer(Request $request)
    {
        if(isset(auth()->user()->id)){
          $id = auth()->user()->id;
          $slot = slot_offer::where('id', $request->id)->where('vendor_id', $id)->first();
          if (!empty($slot)) {
            $slot[$request->col] = $request->value;
            $slot->save();
            return response()->json(['status' => true, 'message' => 'Slot offer status created.']);
          } else {
            return response()->json(['status' => false, 'message' => 'Slot Offer not found.']);
        }
        }else{
            return response()->json(['status' => false, 'message' => 'Please login.']);
        }
    }
    public function editSlotOffer($oid)
    {
        $id = auth()->user()->id;
        $slots = VendorTableTime::where('vendor_id', $id)->orderBy('id', 'ASC')->get();;
        $offer = slot_offer::where('id', $oid)->where('vendor_id', $id)->first();
        if (!empty($offer)) {
            return view('vendor.table.offers.edit-slot-offer', compact('slots', 'offer'));
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Offer not found!']);
        }
    }









    // table foods
    public function tableFoods()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $foods = table_food::where('vendor_id', $id)->latest()->with('category')->get();
            return view('vendor.table.table-food', compact('foods'));
        } else {
            return back()->with(['alert-type' => 'warning', 'message' => 'Please login first.']);
        }
    }

    public function addTableFood()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $categories = category::orderBy('name', 'ASC')->get();
            return view('vendor.table.table-food-add', compact('categories'));
        } else {
            return back()->with(['alert-type' => 'warning', 'message' => 'Please login first.']);
        }
    }

    public function storeTableFood(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;
            $validate = Validator::make(
                $request->all(),
                [
                    'food_name' => 'required',
                    'price' => 'required',
                    'category' => 'required|exists:categories,id',
                    'discount' => 'required|min:0|max:100',
                    'prep_time' => 'required|numeric',
                    'is_vegetarian' => 'required|numeric',
                    'is_spicy' => 'required|numeric',
                    'description' => 'nullable|string',
                    'ingredients' => 'nullable|array',
                    'image' => 'required|image'
                ]
            );
            if ($validate->fails()) {
                // dd($validate->errors());
                return back()->withErrors($validate->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Validation failed.']);
            } else {
                $food = new table_food();
                $food->name = $request->food_name;
                $food->category_id = $request->category;
                $food->vendor_id = $vendor_id;
                $food->price = $request->price;
                $food->description = $request->description;
                $food->discount = $request->discount;
                $food->is_available = 1;
                $food->preparation_time = $request->prep_time;
                $food->is_vegetarian = $request->is_vegetarian;
                $food->is_spicy = $request->is_spicy;
                $food->ingredients = json_encode($request->ingredients);
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read($file);
                    $filename = uniqid('food_') . '.' . $file->getClientOriginalExtension();
                    $image->resize(400, 400)->save(public_path('uploads/table-foods/' . $filename));
                    $food->image = $filename;
                }
                $food->save();
                return redirect()->route('vendor.table.foods')->with(['alert-type' => 'success', 'message' => 'Successfully added new food.']);
            }
        } else {
            return back()->with(['alert-type' => 'warning', 'message' => 'Please login first.']);
        }
    }
    public function updateTableFood(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;
            $validate = Validator::make(
                $request->all(),
                [
                    'id' => 'required|exists:table_foods,id',
                    'food_name' => 'required',
                    'price' => 'required',
                    'category' => 'required|exists:categories,id',
                    'discount' => 'required|min:0|max:100',
                    'prep_time' => 'required|numeric',
                    'is_vegetarian' => 'required|numeric',
                    'is_available' => 'required|numeric',
                    'is_spicy' => 'required|numeric',
                    'description' => 'nullable|string',
                    'ingredients' => 'nullable|array',
                    'image' => 'nullable|image'
                ]
            );
            if ($validate->fails()) {
                // dd($validate->errors());
                return back()->withErrors($validate->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Validation failed.']);
            } else {
                $food = table_food::where('id', $request->id)->where('vendor_id', $vendor_id)->first();
                if ($food) {
                    $food->name = $request->food_name;
                    $food->category_id = $request->category;
                    $food->vendor_id = $vendor_id;
                    $food->price = $request->price;
                    $food->description = $request->description;
                    $food->discount = $request->discount;
                    $food->is_available = 1;
                    $food->preparation_time = $request->prep_time;
                    $food->is_vegetarian = $request->is_vegetarian;
                    $food->is_spicy = $request->is_spicy;
                    $food->is_available = $request->is_available;
                    $food->ingredients = json_encode($request->ingredients);
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $manager = new ImageManager(Driver::class);
                        $image = $manager->read($file);
                        $filename = uniqid('food_') . '.' . $file->getClientOriginalExtension();
                        $image->resize(400, 400)->save(public_path('uploads/table-foods/' . $filename));
                        $food->image = $filename;
                    }
                    $food->save();
                    return redirect()->route('vendor.table.foods')->with(['alert-type' => 'success', 'message' => 'Successfully added new food.']);
                } else {
                    return back()->with(['alert-type' => 'error', 'message' => 'You are not allowed to edit this food.']);
                }
            }
        } else {
            return back()->with(['alert-type' => 'warning', 'message' => 'Please login first.']);
        }
    }

    public function deleteTableFood($id)
    {
        $vendor_id = auth()->user()->id;
        $food = table_food::where('id', $id)->where('vendor_id', $vendor_id)->first();

        if (!empty($food)) {
            $oldPath = public_path('uploads/table-foods/' . $food->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $food->delete();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Food deleted successfully!']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Food not found!']);
        }
    }
    public function editTableFood($id)
    {
        $vendor_id = auth()->user()->id;
        $food = table_food::where('id', $id)->where('vendor_id', $vendor_id)->first();
        $categories = category::orderBy('name', 'ASC')->get();
        if (!empty($food)) {
            return view('vendor.table.edit-table-food', compact('food', 'categories'));
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Food not found!']);
        }
    }

    public function preBookTable(Request $request)
    {
       
        if (isset(auth()->user()->id)) {
            $user_id = auth()->user()->id;
            if (isset($request->table_date) && empty($request->table_date)) {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Please select a date.']);
            }
            if (isset($request->guest) && empty($request->guest)) {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Please select number guest.']);
            }
            if (isset($request->food_type) && empty($request->food_type)) {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Please select food type.']);
            }
            if (isset($request->slot) && empty($request->slot)) {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Please choose a slot.']);
            }
            $request->validate([
                'table_date' => 'required|date',
                'guest' => 'required|numeric',
                'food_type' => 'required',
                'slot' => 'required',
                'offer' => 'nullable|exists:slot_offers,id',
            ]);
            $vendor_id = $request->vendor_id;
            $table_date = $request->table_date;
            $guest = $request->guest;
            $food_type = $request->food_type;
            $slot_time = $request->slot;
            $offer_id = $request->offer ?? null;
           
            $slot_offer = slot_offer::where('id', $offer_id)->where('vendor_id', $vendor_id)->first();
            $table_book = new table_booking();
            $table_book->vendor_id = $vendor_id;
            $table_book->table_date = $table_date;
            $table_book->guest = $guest;
            $table_book->food_type = $food_type;
            $table_book->slot_time = $slot_time;
            $table_book->slot_id = null;
            $table_book->offer_id = $offer_id;
            $table_book->offer = json_encode($slot_offer);
            $table_book->unid = uniqid();
            $table_book->user_id = $user_id;
            $table_book->save();
            return redirect()->route('chooseFood', $table_book->unid)->with(['alert-type' => 'success', 'message' => 'Now you have ready to choose your plate menu.']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'You are not allowed to book a table.']);
        }
    }

    public function chooseFood(Request $request)
    {
        $unid = $request->unid;
        $table_book = table_booking::where('unid', $unid)->where('isComplete',0)->first();
        if (!empty($table_book)) {
            if (isset($request->search) && !empty($request->search)) {
                $search = $request->search;
                $foods = table_food::where('name', 'like', '%' . $search . '%')->where('vendor_id', $table_book->vendor_id)->where('is_available', 1)->with('category')->get();
            } else {
                $foods = table_food::where('vendor_id', $table_book->vendor_id)->where('is_available', 1)->with('category')->get();
            }
            $categories = table_food::select('category_id')
                ->distinct()
                ->with('category')
                ->where('is_available', 1)
                ->where('vendor_id', $table_book->vendor_id)
                ->get();
            // dd($categories);
            if (isset(auth()->user()->id)) {
                $user_id = auth()->user()->id;
                return view('external.shop.choose-table-food', compact('table_book', 'foods', 'categories'));
            } else {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
            }
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Pre Booking not found.']);
        }
    }
    public function addFoodToTable(Request $request)
    {
        $validate= Validator::make($request->all(),[
            'foods' => 'required|array',
            'foods.*' => 'required|exists:table_foods,id',
            'extra_note' => 'nullable|string',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Please choose atleast one food.']);
        }else{
            $unid = $request->unid;
            $table_book = table_booking::where('unid', $unid)->first();
            if (!empty($table_book)) {
                $foods = $request->foods;
                $extra_note = $request->extra_note;
                $table_book->foods=json_encode($foods);
                $table_book->extra_note = $extra_note;
                $table_book->isComplete = 1;
                $table_book->save();
                return redirect()->route('myaccount')->with(['alert-type' => 'success','message' => 'Food added successfully.']);
            }else{
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Pre Booking not found.']);
            }
        }

    }
    public function cancelBooking(Request $request){

        if (isset(auth()->user()->id)) {
            $id = $request->id;
            $table_booking = table_booking::where('user_id', auth()->user()->id)->where('id', $id)->first();
            if ($table_booking) {
                $table_booking->status = 'cancelled';
                $table_booking->save();
                
                return response()->json(['status'=>true,'message'=>'Booking cancelled successfully.'],200);
            } else {
                
                return response()->json(['status'=>false,'message'=>'Booking not found.'],200);
            }
        } else {
            return response()->json(['status'=>false,'message'=>'Please login first'],200);
        }
    }
    public function tableStatusChange(Request $request){

        if (isset(auth()->user()->id)) {
            $id = $request->id;
            $table_booking = table_booking::where('vendor_id', auth()->user()->id)->where('id', $id)->first();
            if ($table_booking) {
                $table_booking->status = $request->status;
                $table_booking->save();
                
                return response()->json(['status'=>true,'message'=>'Booking Status Updated successfully.'],200);
            } else {
                
                return response()->json(['status'=>false,'message'=>'Booking not found.'],200);
            }
        } else {
            return response()->json(['status'=>false,'message'=>'Please login first'],200);
        }
    }
    public function getTableBooking(){
        if(isset(auth()->user()->id)){

            $tables = table_booking::where('vendor_id', auth()->user()->id)
            ->where('isComplete',1)
            ->with('user')
            ->orderBy('table_date','DESC')
            ->get();
            $tables->each(function ($table) {
                $foodIds = json_decode($table->foods, true); 
    
                if (is_array($foodIds) && count($foodIds) > 0) {
                    $table->foodDetails = table_food::whereIn('id', $foodIds)->get();
                } else {
                    $table->foodDetails = collect(); 
                }
            });
            return view('vendor.table.table-bookings',compact('tables'));
        }else{
            return redirect()->route('login');
        }
    }
}
