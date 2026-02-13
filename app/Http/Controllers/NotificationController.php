<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NotificationController extends Controller
{
    protected $fcm;

    public function __construct()
    {
        $this->fcm = new FirebaseService(env('FIREBASE_PROJECT_ID'),public_path(env('FIREBASE_CREDENTIALS_PATH')));
    }
     public function updateToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'token' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }
        try {
            $user = User::findOrFail($request->user_id);
            $user->device_token = $request->token;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Device token updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update device token',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function testNotification(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $user = User::findOrFail($request->user_id);

    // If token missing
    if (!$user->device_token) {
        return response()->json([
            'success' => false,
            'message' => 'User does not have a device token',
        ]);
    }

    try {
        $this->fcm->sendNotification(
            [$user->device_token],
            [
                'title' => '🔥 Test Notification',
                'body'  => 'Firebase is working successfully!',
                'type'  => 'test',
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Test notification sent successfully',
            'device_token' => $user->device_token,
        ]);

    } catch (\Exception $e) {

        Log::error('FCM Test Error', [
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to send test notification',
            'error'   => $e->getMessage(),
        ], 500);
    }
}

    
    public function notify(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'receiver_id'   => 'required|exists:users,id',
        'message'       => 'required|string',
        'title'         => 'required|string',
        'type'          => 'required|string',   
    ]);
    if ($validator->fails()) {
        return response()->json(['status' => false, 'message' => $validator->errors()->first(),'errors' => $validator->errors(),], 422);
    }
    
    $receiver = User::findOrFail($request->receiver_id);

    
    $notification = Notification::create([
        'user_id'       => $receiver->id,         
        'type'          => $request->type,
        'title'         => $request->title,
        'message'       => $request->message,
        'is_read'       => false,
    ]);

    // If no device token → just return
    if (!$receiver->device_token) {
        return response()->json([
            'success' => true,
            'message' => 'Receiver unavailable, notification stored',
        ]);
    }

    try {
        $this->fcm->sendNotification(
            [$receiver->device_token],
            [
                'title'          => $request->title,
                'body'           => $request->message,
                'type'           => $request->type,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Notification sent',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}
public function getUnreadCount(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|integer|exists:users,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation error',
        ], 422);
    }

    $count = Notification::where('user_id', $request->user_id)
        ->where('is_read', false)
        ->count();

    return response()->json([
        'status' => true,
        'unread_count' => $count,
        'last_checked' => now()->toDateTimeString(),
    ]);
}
    
    public function getNotificationsOld(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $notifications = Notification::where('user_id', $request->user_id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Notifications fetched successfully.',
            'data' => $notifications,
        ]);
    }
public function getNotifications(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|integer|exists:users,id',
        'limit' => 'sometimes|integer|min:1|max:100',
        'page' => 'sometimes|integer|min:1'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], 422);
    }

    $limit = $request->input('limit', 20);
    $page = $request->input('page', 1);
    
    $notifications = Notification::where('user_id', $request->user_id)
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->paginate($limit, ['*'], 'page', $page);

    return response()->json([
        'status' => true,
        'message' => 'Notifications fetched successfully.',
        'data' => $notifications->items(),
        'pagination' => [
            'total' => $notifications->total(),
            'per_page' => $notifications->perPage(),
            'current_page' => $notifications->currentPage(),
            'last_page' => $notifications->lastPage(),
        ]
    ]);
}
    public function markNotificationRead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:notifications,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $notification = Notification::find($request->id);
        $notification->update(['is_read' => 1]);

        return response()->json([
            'status' => true,
            'message' => 'Notification marked as read.',
        ]);
    }

    public function deleteNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:notifications,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        Notification::destroy($request->id);

        return response()->json([
            'status' => true,
            'message' => 'Notification deleted.',
        ]);
    }

    public function clearAllNotifications(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $deletedCount = Notification::where('user_id', $request->user_id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'All notifications cleared for the user.',
            'deleted_count' => $deletedCount,
        ]);
    }
    

}
