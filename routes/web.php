<?php

use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\AdminFoodController;
use App\Http\Controllers\admin\AdminOfferController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\WinOrderController;
use App\Http\Controllers\admin\vendor\VendorController;
use App\Http\Controllers\admin\vendor\VendorOffersController;
use App\Http\Controllers\AllergenController;
use App\Http\Controllers\allOrderController;
use App\Http\Controllers\auth\customerAuthController;
use App\Http\Controllers\auth\SocialiteController;
use App\Http\Controllers\BusinessServiceController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CollectionsController;
use App\Http\Controllers\CourierServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\extraItemController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\foodReviewController;
use App\Http\Controllers\FoodSubItemController;
use App\Http\Controllers\global\DeliveryAreaController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TableServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\variantController;
use App\Http\Controllers\VariantExtraPriceController;
use App\Http\Controllers\VendorFoodItemsController;
use App\Http\Controllers\VendorMenuOptionController;
use App\Http\Controllers\VendorOpeningTimeController;
use App\Http\Controllers\WebsiteSettingControllerController;
use Illuminate\Support\Facades\Route;


Route::get('/vendor/login', [AdminAuthController::class, 'loginVendor'])->name('vendor.login');
Route::post('/vendor/login', [AdminAuthController::class, 'signinVendor'])->name('vendor.signin');

Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'signin'])->name('admin.signin');

Route::get('login/google', [SocialiteController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [SocialiteController::class, 'handleGoogleCallback']);
Route::middleware(['role:admin'])->group(function () {
  Route::controller(CustomerController::class)->prefix('admin')->group(function () {
    Route::get('/all-customer', 'index')->name('admin.all.customers');
  });
  Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
  Route::controller(customerAuthController::class)->group(function () {
     Route::get('/delete/{id}/account', 'delete_profile')->name('delete_profile');
  });
  Route::get('/admin/dashboard', [AdminAuthController::class,'dashboard'])->name('admin.dashboard');

   Route::controller(VendorController::class)->prefix('admin')->group(function () {
    Route::get('/all-vendor', 'index')->name('admin.all.vendor');
    Route::get('/add-vendor', 'create')->name('admin.create.vendor');
    Route::post('/add-vendor', 'store')->name('admin.store.vendor');
    Route::post('/edit-vendor', 'update')->name('admin.update.vendor');
    Route::post('/delete-vendor', 'deleteVendor')->name('admin.delete.vendor');
    Route::get('/{id}/vendor-detail', 'show')->name('admin.show.vendor');
    Route::get('/vendors/{vendor}/document', 'showVendorDocument')->name('vendors.edit.document');
    Route::get('/vendors/{vendor}/document/delete', 'deleteThisDocument')->name('vendors.delete.document');
    Route::get('/vendor/add/document', 'addVendorDocument')->name('vendors.add.document');
    Route::get('/vendors/documents', 'vendorDocuments')->name('vendors.show.document');
    Route::post('/vendor/upload/document','uploadDocument')->name('vendors.upload.document');
    Route::get('/vendors/{vendor}/permissions', 'permissions')->name('vendors.permissions');
    Route::post('/vendors/{vendor}/permissions','updatePermissions');
    Route::post('/impersonate/{vendorId}','impersonateVendor')->name('admin.impersonate');
  });

  Route::controller(CategoryController::class)->prefix('admin')->group(function () {
    Route::get('/food-category', 'index')->name('admin.food.category');
    Route::get('/add-food-category', 'addNew')->name('admin.create.food.category');
    Route::post('/add-food-category', 'store')->name('admin.store.food.category');
    Route::post('/update-food-category', 'update')->name('admin.update.food.category');
    Route::get('/remove/{id}/food-category', 'remove')->name('admin.remove.food.category');
    Route::get('/edit/{id}/food-category', 'edit')->name('admin.edit.food.category');
    Route::post('/update-category-status', 'updateCategory')->name('update.category.status');
  });
  Route::controller(AdminFoodController::class)->prefix('admin')->group(function () {
    Route::get('/food', 'index')->name('admin.food');
    Route::get('/new-food', 'create')->name('admin.add.food');
    Route::post('/new-food', 'store')->name('admin.store.food');
    Route::get('/{id}/edit-food', 'edit')->name('admin.edit.food');
    Route::get('/{id}/delete-food', 'delete')->name('admin.delete.food');
    Route::post('/update-food', 'update')->name('admin.update.food');
    Route::post('/update-food-status', 'menuAvailable')->name('admin.food.change.status');
  });
  Route::controller(CollectionsController::class)->prefix('admin')->group(function () {
    Route::get('/collections', 'adminIndex')->name('admin.collections');
    Route::get('/collection/{id}', 'adminEditCollection')->name('admin.edit.collection');
    Route::get('/delete/collection/{id}', 'adminDeleteCollection')->name('admin.delete.collection');
    Route::post('/update-collection', 'adminCreateUpdateCollection')->name('admin.create.collection');
  });
  Route::controller(variantController::class)->prefix('admin')->group(function () {
    Route::get('/edit/variant/{id?}', 'getVariant')->name('admin.edit.variant');
    Route::put('/update/variant/{id?}', 'saveVariant')->name('admin.update.variant');
    Route::get('/delete/variant/{id?}', 'deleteVariant')->name('admin.delete.variant');
    Route::post('/add/variant', 'saveVariant')->name('admin.save.variant');
  });
  Route::controller(extraItemController::class)->prefix('admin')->group(function () {
    Route::get('/edit/extra/{id?}', 'getExtra')->name('admin.edit.extra');
    Route::put('/update/extra/{id?}', 'saveExtra')->name('admin.update.extra');
    Route::get('/delete/extra/{id?}', 'deleteExtra')->name('admin.delete.extra');
    Route::post('/add/extra', 'saveExtra')->name('admin.save.extra');
  });
  Route::controller(AdminOfferController::class)->prefix('admin')->group(function () {
    Route::get('/offers', 'index')->name('admin.offer');
    Route::get('/add-offer', 'addNew')->name('admin.create.offer');
    Route::get('/{id}/edit-offer', 'edit')->name('admin.edit.offer');
    Route::get('/{id}/delete-offer', 'delete')->name('admin.delete.offer');
    Route::post('/add-offer', 'store')->name('admin.store.offer');
    Route::post('/update-offer', 'update')->name('admin.update.offer');
  });
  Route::controller(WebsiteSettingControllerController::class)->prefix('admin')->group(function () {
    Route::get('/home-slider', 'homeSlider')->name('admin.home-slider');
    Route::get('/add-slide', 'addNew')->name('admin.create.slide');
    Route::get('/{id}/edit-slide', 'editSlide')->name('admin.edit.slide');
    Route::get('/{id}/delete-slide', 'delete')->name('admin.delete.slide');
    Route::post('/add-slide', 'storeSlide')->name('admin.store.slide');
    Route::post('/update-slide', 'updateSlide')->name('admin.update.slide');
  });
  Route::controller(CourierServiceController::class)->prefix('admin')->group(function () {
    Route::get('/all-applications', 'allCouriersApplications')->name('admin.all.courier.applications');
    Route::get('/view-application/{id}', 'viewCourierApplication')->name('view.courier.application');
    Route::get('/delete-application/{id}', 'deleteCourierApplication')->name('delete.courier.application');
    Route::get('/all-courier-partners', 'allPartners')->name('all.courier.partner');
    Route::get('/add-courier-partner', 'addPartner')->name('add.courier.partner');
  });
  Route::controller(allOrderController::class)->prefix('admin')->group(function () {
    Route::get('/orders', 'index')->name('admin.all.order');
    Route::post('/order-status', 'updateStatus')->name('admin.order.status');
    Route::get('/order-view/{id}', 'viewOrder')->name('admin.order.view');
    Route::get('/order-pdf/{id}', 'generateOrderPDF')->name('admin.generate.order.pdf');
  });

  Route::controller(foodReviewController::class)->prefix('admin')->group(function () {
    Route::get('/food-review', 'index')->name('admin.food.reviews');
    Route::get('/edit-food-review/{id}', 'editReview')->name('admin.edit.food.review');
    Route::post('/review-update', 'update')->name('admin.upadate.food.review');
    Route::get('/delete-food-review/{id}', 'deleteReview')->name('admin.delete.food.review');
  });
  Route::controller(PaymentController::class)->prefix('admin')->group(function () {
    Route::get('/payment-ladger', 'ladger')->name('admin.payment.ladger');
    Route::get('/all-vendor/revenue', 'allVendorForRevenue')->name('admin.all.revenue.vendor');
    Route::get('/{vid}/all-revenue', 'revenues')->name('admin.all.revenues');
    Route::get('/{orderid}/order/detail', 'viewOrder')->name('admin.order.detail');
    Route::get('/{orderid}/order/pdf', 'generateOrderPDF')->name('admin.order.pdf');
    Route::get('/{payout_id}/payout/delete', 'payoutDelete')->name('admin.delete.payout');
    Route::get('/payout/history', 'payoutHistory')->name('admin.payment.history');
    Route::get('/generate/payout', 'generatePayout')->name('admin.generate.payout');
    Route::post('/generate/payout/pdf', 'generateInvoice')->name('admin.generate.payout.pdf');
  });
  Route::controller(WinOrderController::class)->prefix('admin')->group(function () {
    Route::get('/all-winorders-api', 'allApis')->name('admin.all.winorder');
    Route::get('/delete/{id}/winorder-api', 'deleteThis')->name('admin.delete.winorder');
    Route::post('/generate-winorders-api', 'store')->name('admin.store.winorder');
  });
});


// vendor route
Route::middleware(['role:vendor'])->group(function () {
Route::controller(VendorController::class)->prefix('vendor')->group(function () {
    Route::get('/dashboard', 'dashboard')->name('vendor.dashboard');
    Route::get('/my-profile', 'editVendorProfile')->name('vendor.my.profile');
    Route::post('/update-profile', 'updateVendorProfile')->name('update.profile.vendor')->middleware(['permission']);
    Route::post('/update-restaurant-status', 'updateVendorStatus')->name('update.status.vendor');
    Route::get('/logout', 'logout')->name('logout.vendor');
    Route::post('/return', 'returnToAdmin')->name('admin.return')->middleware(['permission']);
    Route::post('/update-location', 'updateVendorLocation')->name('update.location.vendor');
});
 Route::controller(foodReviewController::class)->prefix('vendor')->group(function () {
    Route::get('/food-review', 'vendorReviews')->name('vendor.food.reviews');
  });
Route::controller(CategoryController::class)->prefix('vendor')->group(function () {
    Route::get('/all/category', 'allCategory')->name('vendor.all.category')->middleware(['permission']);
    Route::get('/add/category', 'addCategory')->name('vendor.create.category')->middleware(['permission']);
    Route::get('/edit/category/{id}', 'editCategory')->name('vendor.edit.food.category')->middleware(['permission']);
    Route::get('/delete/category/{id}', 'deleteThis')->name('vendor.delete.food.category')->middleware(['permission']);
    Route::post('/delete/category-variant', 'deleteCategoryVariant')->name('vendor.delete.category-variant')->middleware(['permission']);
    Route::post('/store/category', 'storeCategory')->name('vendor.store.food.category')->middleware(['permission']);
    Route::post('/update/category', 'updateVendorCategory')->name('vendor.update.food.category')->middleware(['permission']);
    Route::post('/update/category/order', 'updateSortOrder')->name('vendor.update.sort.category')->middleware(['permission']);
});

Route::controller(VendorFoodItemsController::class)->prefix('vendor')->group(function () {
    Route::get('/all-foods', 'index')->name('vendor.all.foods');
    Route::get('/new-food', 'create')->name('vendor.add.food')->middleware(['permission']);
    Route::post('/new-food', 'store')->name('vendor.store.food')->middleware(['permission']);
    Route::post('/get-category-collections', 'getCollectionByCategory')->name('vendor.get.category.collection');
    Route::post('/get-category-variants', 'getVariantByCategory')->name('vendor.get.category.variants');
    Route::get('/{food_id}/delete-food', 'delete')->name('vendor.delete.food')->middleware(['permission']);
    Route::get('/{food_id}/edit-food', 'ediFood')->name('vendor.edit.food')->middleware(['permission']);
    Route::post('/update-food', 'update')->name('vendor.update.food')->middleware(['permission']);
    Route::post('/update-food-order', 'updateSortOrder')->name('vendor.update.sort.order');
    Route::get('/all-orders', 'allOrders')->name('vendor.all.orders');
    Route::post('/order/status', 'orderStatus')->name('vendor.order.status')->middleware(['permission']);
    Route::get('/order/{id}', 'orderView')->name('vendor.order.view')->middleware(['permission']);
    Route::get('/order-pdf/{id}', 'generateOrderPDF')->name('vendor.generate.order.pdf')->middleware(['permission']);
    Route::get('/all-payments', 'payments')->name('vendor.all.payments');
    Route::get('/revenues', 'revenues')->name('vendor.all.revenues');
    Route::post('/menu-status', 'menuAvailable')->name('vendor.change.status')->middleware(['permission']);
});

Route::controller(extraItemController::class)->prefix('vendor')->group(function () {
    Route::get('/edit/extra/{id?}', 'getExtra')->name('vendor.edit.extra')->middleware(['permission']);
    Route::put('/update/extra/{id?}', 'saveExtra')->name('vendor.update.extra')->middleware(['permission']);
    Route::get('/delete/extra/{id?}', 'deleteExtra')->name('vendor.delete.extra')->middleware(['permission']);
    Route::post('/add/extra', 'saveExtra')->name('vendor.save.extra')->middleware(['permission']);
});

Route::controller(CollectionsController::class)->prefix('vendor')->group(function () {
    Route::get('/all-type/{id?}', 'typeIndex')->name('vendor.all.types')->middleware(['permission']);
    Route::get('/collections', 'index')->name('vendor.collections');
    Route::get('/collection/{id}', 'editCollection')->name('vendor.edit.collection')->middleware(['permission']);
    Route::get('/delete/type/{id}', 'deleteType')->name('vendor.delete.type')->middleware(['permission']);
    Route::get('/delete/collection/{id}', 'deleteCollection')->name('vendor.delete.collection')->middleware(['permission']);
    Route::post('/update-collection', 'createUpdateCollection')->name('vendor.create.collection')->middleware(['permission']);
    Route::post('/add-type', 'updateType')->name('vendor.create.type')->middleware(['permission']);
});

Route::controller(VendorOffersController::class)->prefix('vendor')->group(function () {
    Route::get('/offers', 'index')->name('vendor.offer');
    Route::get('/add-offer', 'addNew')->name('vendor.create.offer')->middleware(['permission']);
    Route::get('/{id}/edit-offer', 'edit')->name('vendor.edit.offer')->middleware(['permission']);
    Route::get('/{id}/delete-offer', 'delete')->name('vendor.delete.offer')->middleware(['permission']);
    Route::post('/add-offer', 'store')->name('vendor.store.offer')->middleware(['permission']);
    Route::post('/update-offer', 'update')->name('vendor.update.offer')->middleware(['permission']);
    Route::post('/update-offer-status', 'updateStatus')->name('vendor.change.status.offer')->middleware(['permission']);
});

Route::controller(TableServiceController::class)->prefix('vendor')->group(function () {
Route::get('/table-service', 'tableService')->name('vendor.table.service');
Route::get('/time-slots', 'timeSlots')->name('vendor.table.slots');
Route::get('/add-slot', 'createSlot')->name('vendor.create.slot')->middleware(['permission']);
Route::get('/{id}/table-service/image-delete', 'delete')->name('vendor.table.delete.image')->middleware(['permission']);
Route::get('/{id}/delete/slot', 'deleteSlot')->name('vendor.delete.slot')->middleware(['permission']);
Route::get('/{id}/status/change', 'changeStatus')->name('vendor.change.status.slot')->middleware(['permission']);
Route::post('/table-service', 'tableServiceStore')->name('vendor.store.table-service')->middleware(['permission']);
Route::post('/add-slot', 'addSlot')->name('vendor.add.slot')->middleware(['permission']);
Route::get('/slot-offers', 'slotOffers')->name('vendor.slot.offers');
Route::get('/add-slot-offer', 'createOffer')->name('vendor.create.slot.offer')->middleware(['permission']);
Route::post('/store-slot-offer', 'storeSlotOffer')->name('vendor.store.slot.offer')->middleware(['permission']);
Route::post('/update-slot-offer', 'updateSlotOffer')->name('vendor.update.slot.offer')->middleware(['permission']);
Route::get('/{id}/delete/slot/offer', 'deleteSlotOffer')->name('vendor.delete.slot.offer')->middleware(['permission']);
Route::post('/change/slot/offer-status', 'changeStatusSlotOffer')->name('vendor.change.slot.offer.status')->middleware(['permission']);
Route::get('/{id}/edit/slot/offer', 'editSlotOffer')->name('vendor.edit.slot.offer')->middleware(['permission']);
Route::get('/table-foods', 'tableFoods')->name('vendor.table.foods');
Route::get('/add-table-food', 'addTableFood')->name('vendor.add-table.food')->middleware(['permission']);
Route::get('/edit-table-food/{id}', 'editTableFood')->name('vendor.edit-table.food')->middleware(['permission']);
Route::post('/add-table-food', 'storeTableFood')->name('vendor.store-table.food')->middleware(['permission']);
Route::delete('/delete-table-food/{id}', 'deleteTableFood')->name('vendor.delete-table.food')->middleware(['permission']);
Route::post('/update-table-food', 'updateTableFood')->name('vendor.update-table.food')->middleware(['permission']);
Route::get('/table-bookings', 'getTableBooking')->name('vendor.table.bookings');
Route::post('/table-booking-status', 'tableStatusChange')->name('vendor.tableStatusChange')->middleware(['permission']);
  });
  
  Route::controller(variantController::class)->prefix('vendor')->group(function () {
    Route::get('/edit/variant/{id?}', 'getVariant')->name('vendor.edit.variant')->middleware(['permission']);
    Route::put('/update/variant/{id?}', 'saveVariant')->name('vendor.update.variant')->middleware(['permission']);
    Route::get('/delete/variant/{id?}', 'deleteVariant')->name('vendor.delete.variant')->middleware(['permission']);
    Route::post('/add/variant', 'saveVariant')->name('vendor.save.variant')->middleware(['permission']);
  });
  Route::controller(VendorMenuOptionController::class)->prefix('vendor')->group(function () {
    Route::get('/menu-item-options', 'menuItemOptions')->name('menuItemOptions');
    Route::get('/menu-item-option/{id}/delete', 'deleteMenuOption')->name('deleteMenuOption')->middleware(['permission']);
    Route::get('/menu-item-option/{id}/edit', 'editMenuOption')->name('editMenuOption')->middleware(['permission']);
    Route::post('/add/menu-item-option', 'addMenuItemOption')->name('addMenuItemOption')->middleware(['permission']);
    Route::get('/{id}/menu-item-option-value', 'menuItemOptionValues')->name('menuItemOptionValues')->middleware(['permission']);
    Route::post('/add/menu-option-value', 'addMenuOptionValues')->name('addMenuOptionValues')->middleware(['permission']);
    Route::get('/{mid}/{value_id}/menu-option-value/delete', 'menuOptionValuesDelete')->name('menuOptionValuesDelete')->middleware(['permission']);
    Route::get('/{mid}/{value_id}/menu-option-value/edit', 'editMenuOptionValues')->name('editMenuOptionValues')->middleware(['permission']);

    Route::get('/groups-food', 'groupData')->name('groupData')->middleware(['permission']);
    Route::post('/add/group', 'groupDataStore')->name('groupDataStore')->middleware(['permission']);
    Route::get('/delete/{id}/group', 'deleteGroup')->name('deleteGroup')->middleware(['permission']);
    Route::get('/edit/{id}/group', 'editGroup')->name('editGroup')->middleware(['permission']);


    Route::get('/{id}/group-items', 'groupItems')->name('groupItems')->middleware(['permission']);
    Route::post('/group-items/add', 'addGroupItems')->name('addGroupItems')->middleware(['permission']);
    Route::get('/{id}/group-item/delete', 'groupItemDelete')->name('groupItemDelete')->middleware(['permission']);
  });
  Route::controller(DeliveryAreaController::class)->prefix('vendor')->group(function () {
    Route::get('/delivery-areas', 'addDeliveryManager')->name('vendor.all.delivery-areas');
    Route::post('/delivery-areas', 'saveDeliveryArea')->name('vendor.save.delivery-area')->middleware(['permission']);
    Route::delete('/delivery-area/{id?}', 'destroy')->name('vendor.delete.delivery-area')->middleware(['permission']);
    Route::get('/delivery-area/{id?}', 'editDeliveryArea')->name('vendor.edit.delivery-area')->middleware(['permission']);
    Route::post('/update-delivery-area', 'saveDeliveryAreaChange')->name('vendor.update.delivery-area')->middleware(['permission']);
    Route::post('/update-delivery-area-status', 'updateStatus')->name('vendor.update.delivery-area-status')->middleware(['permission']);
    
    Route::get('/delivery-charges', 'deliveryChargeManager')->name('vendor.all.delivery-charge');
    Route::post('/delivery-charge', 'saveDeliveryCharge')->name('vendor.save.delivery-charge')->middleware(['permission']);
    Route::delete('/delivery-charge/{id?}', 'destroyRange')->name('vendor.delete.delivery-charge')->middleware(['permission']);
    Route::get('/delivery-charge/{id?}', 'editDeliveryCharge')->name('vendor.edit.delivery-charge')->middleware(['permission']);
    Route::post('/update-delivery-charge', 'saveDeliveryChargeChange')->name('vendor.update.delivery-charge')->middleware(['permission']);
    Route::post('/update-delivery-charge-status', 'updateStatusDeliveryCharge')->name('vendor.update.delivery-charge-status')->middleware(['permission']);
  });
  Route::controller(VendorOpeningTimeController::class)->prefix('vendor')->group(function () {
    Route::get('/all-openings', 'index')->name('vendor.all.openings');
    Route::get('/all-table-openings', 'index2')->name('vendor.table.openings');
    Route::get('/custome-openings', 'customeOpening')->name('vendor.custome_opening')->middleware(['permission']);
    Route::put('/update-opening-times/{id?}', 'update')->name('vendor.update.openings')->middleware(['permission']);
    Route::put('/update-table-opening-times/{id?}', 'updateTableTime')->name('vendor.update.table.openings');
    Route::put('/pickup-status/{id?}', 'updatePickupStatus')->name('vendor.update.pickup.status');
    Route::put('/delivery-status/{id?}', 'updateDeliverStatus')->name('vendor.update.delivery.status');
    Route::put('/table-status/{id?}', 'updateTableStatus')->name('vendor.update.table.status');
    Route::post('/save-custome-opening', 'saveCustomTiming')->name('vendor.add.custome_timing')->middleware(['permission']);
    Route::post('/update-custome-opening', 'updateCustomeOpening')->name('vendor.update.custome_timing')->middleware(['permission']);
    Route::put('/custome-pickup-status/{id?}', 'updatePickupStatusCustome')->name('vendor.update.pickup_custome.status')->middleware(['permission']);
    Route::put('/custome-delivery-status/{id?}', 'updateDeliverStatusCustome')->name('vendor.update.delivery_custome.status')->middleware(['permission']);
    Route::delete('/delete-custom-timing', 'destroyCustomeOpening')->name('vendor.custom-timing.destroy')->middleware(['permission']);
  });
  
  Route::controller(AllergenController::class)->prefix('vendor')->group(function () {
    Route::get('/all-allergen', 'index')->name('vendor.all.allergen');
    Route::post('/add-allergen', 'saveAllergen')->name('vendor.add.allergen')->middleware(['permission']);
    Route::put('/allergen-status/{id?}', 'updateAllergenStatus')->name('vendor.update.allergen.status')->middleware(['permission']);
    Route::post('/update-allergen', 'updateAllergen')->name('vendor.update.allergen')->middleware(['permission']);
    Route::delete('/delete-allergen', 'destroyAllergen')->name('vendor.allergen.destroy')->middleware(['permission']);
    
    
    Route::get('/all-taxes', 'allTax')->name('vendor.all.tax');
    Route::get('/edit-tax/{tax_id}', 'editTax')->name('vendor.edit.tax');
    Route::post('/save-tax', 'saveTax')->name('vendor.save.tax');
    Route::post('/delete-tax', 'destroyTax')->name('vendor.tax.destroy');
  });

  // only if you have permission  
  

  Route::controller(VariantExtraPriceController::class)->prefix('vendor')->group(function () {
    Route::get('/all-variant-price-extras/{extra_id?}', 'index')->name('vendor.all.variant-price-extras');
    Route::post('/add-variant-price-extra', 'store')->name('vendor.add.variant-price-extra')->middleware(['permission']);
    Route::delete('/delete-variant-price-extra/{id?}', 'destroy')->name('vendor.delete.variant-price-extra')->middleware(['permission']);
  });

 
  Route::controller(FoodSubItemController::class)->prefix('vendor')->group(function () {
    Route::get('/all-includes/{id?}', 'index')->name('vendor.all.include');
    Route::post('/add-include', 'saveInclude')->name('vendor.add.include')->middleware(['permission']);
    Route::post('/get-include', 'getFoodSubType')->name('vendor.food-sub-items.get')->middleware(['permission']);
    Route::post('/update-include', 'updateInclude')->name('vendor.update.include')->middleware(['permission']);
    Route::get('/status-include/{id?}', 'statusInclude')->name('vendor.update.include.status')->middleware(['permission']);
    Route::delete('/delete-include/{id?}', 'destroyInclude')->name('vendor.delete.include')->middleware(['permission']);
  });


});



Route::controller(ShopController::class)->group(function () {
  Route::get('/shop', 'index')->name('shop');
  Route::get('/{slug}/category/shop', 'index')->name('shop.category');
  Route::get('/{unid}/shop', 'viewRestaurant')->name('shop.view');
  Route::get('/food-item/details/{id?}', 'getFoodDetails3')->name('getFoodDetails');
  Route::get('/{unid}/table-booking', 'tableShop')->name('shop.table');
  Route::post('/generate-slots', 'generateSlots')->name('shop.table.times');
  Route::get('/fetch-offers/{id}', 'fetchOffers')->name('shop.fetch.offers');
  Route::get('/shop/vendor-details/{id?}', 'getVendorDetails')->name('shop.fetch.shop.details');
  Route::post('/save-feeback', 'storeFeedback')->name('shop.save.feedback');
  Route::get('/get-review', 'getReview')->name('getReview');
  Route::post('/store-review', 'storeReview')->name('storeReview');
  Route::post('/report-review', 'reportReview')->name('review.report');

});
Route::controller(FavoriteController::class)->group(function () {
  Route::post('/add-favorite', 'addFavorite')->name('addFavorite');
});


Route::controller(BusinessServiceController::class)->group(function () {
  Route::get('/business-service', 'index')->name('business-service');
  Route::get('/paying-cards', 'payingCards')->name('paying-card');
});
Route::controller(CourierServiceController::class)->prefix('courier')->group(function () {
  Route::get('/courier-service', 'index')->name('courier-service');
  Route::get('/apply', 'applyCourier')->name('courier.apply');
  Route::post('/apply', 'store');
});


Route::controller(HomePageController::class)->group(function () {
  Route::get('/home', 'index')->name('home');
  Route::get('/', 'index')->name('homepage');
  Route::get('/privacy-policy', 'privacyPolicy')->name('privacy-policy');
  Route::get('/terms-conditions', 'termCondition')->name('terms-conditions');
  Route::get('/refund-cancellation', 'refundCancellation')->name('refund-cancellation');
  Route::get('/cookie-policy', 'cookiePolicy')->name('cookie-policy');
  Route::post('/check-location-restaurants', 'checkDeliveryArea')->name('check.rest.location');
  Route::post('/save-location-session', 'saveInSession')->name('save.session.location');
  Route::post('/save-location', 'saveLocation')->name('save.location');
});
Route::controller(customerAuthController::class)->group(function () {
  Route::get('/login', 'login')->name('login');
  Route::get('/register', 'register')->name('register');
  Route::post('/register', 'register_save')->name('register_save');
  Route::post('/login', 'login_verify')->name('login_verify');
  Route::get('/logout', 'logout')->name('logout');
  Route::get('/forget-password', 'forgetpassword')->name('forgetpassword');
  Route::post('/forget-password', 'sendotp')->name('sendotp');
  Route::get('/otp-verify', 'otpget')->name('otpget');
  Route::post('/otp-verify', 'setpassword')->name('setpassword');
});

// for auth users
Route::middleware(['auth'])->group(function () {
  Route::controller(UserController::class)->group(function () {
    Route::get('/my-account', 'myAccount')->name('myaccount');
    Route::post('/update-account', 'updateAccount')->name('update.my.account');
    Route::post('/update-address', 'updateAddress')->name('update.my.address');
  });
  Route::controller(CartController::class)->group(function () {
    Route::post('/cart', 'store2')->name('cart.store');
    Route::post('/cart/product/details', 'getCartProductDetail')->name('cart.get.product.detail');
    Route::post('/cart/get', 'getCart')->name('cart.get');
    Route::post('/cart-qty-update', 'updateQty')->name('cart.update');
    Route::post('/update-cart-note', 'updateNote')->name('cart.update.note');
  });
  Route::controller(CheckoutController::class)->group(function () {
    Route::get('/checkout/{method?}', 'checkout')->name('checkout.now');
    Route::get('/order/success', 'orderSuccess')->name('order.success');
    Route::post('/order/cancel', 'cancelStatus')->name('order.cancel');
  });
  Route::controller(PayPalController::class)->group(function () {
    Route::post('/order/payment', 'payWithPayPal')->name('paypal.payment');
    Route::delete('/old-address/{address_id}', 'deleteOldAddress')->name('old.address.delete');
    Route::get('/payment-status', 'payPalStatus')->name('paypal.status');
  });
  Route::controller(TableServiceController::class)->group(function () {
    Route::post('/pre-book', 'preBookTable')->name('preBookTable');
    Route::get('/{unid}/choose-food', 'chooseFood')->name('chooseFood');
    Route::post('/add-food-to_table', 'addFoodToTable')->name('addFoodToTable');
    Route::post('/cancel-booking', 'cancelBooking')->name('cancelBooking');
  });
  Route::controller(FavoriteController::class)->group(function () {
    Route::get('/favorites-restaurants', 'getFavoritesRestaurants')->name('user.getFavoritesRestaurants');
  });
});
