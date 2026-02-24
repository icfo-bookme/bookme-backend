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
        $notifications = Notification::where('isActive', 1)
    ->orderBy('created_at', 'desc')
    ->get();

return response()->json([
    'success' => true,
    'count'   => $notifications->count(),
    'data'    => $notifications,
]);

    }
}
