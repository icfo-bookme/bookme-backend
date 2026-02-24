<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of all notifications.
     */
    public function index()
    {
        // Get all notifications ordered by latest
        $activeNotifications = Notification::orderBy('created_at', 'desc')->where('isActive', 1)->get();
        
        $notifications = Notification::orderBy('created_at', 'desc')->take(50)->get();

        return response()->json([
            'success' => true,
            'count'   => $activeNotifications->count(),
            'data'    => $notifications,
        ]);
    }
    
  public function verify($id)
{
    $notify = Notification::find($id);

    if (!$notify) {
        abort(404);
    }
    $notify->update([
        'isActive' => 0
    ]);


    return redirect($notify->redirectUrl);
}

}
