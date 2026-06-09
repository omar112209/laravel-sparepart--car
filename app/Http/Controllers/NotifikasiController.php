<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = Notifikasi::latest()->take(20)->get();
        $unreadCount = Notifikasi::unread()->count();
        return response()->json([
            'notifikasis' => $notifikasis,
            'unread_count' => $unreadCount,
        ]);
    }

    public function unreadCount()
    {
        return response()->json([
            'unread_count' => Notifikasi::unread()->count(),
        ]);
    }

    public function markRead($id)
    {
        $notif = Notifikasi::findOrFail($id);
        $notif->update(['is_read' => true]);
        return response()->json(['ok' => true]);
    }

    public function markAllRead()
    {
        Notifikasi::unread()->update(['is_read' => true]);
        return response()->json(['ok' => true]);
    }
}
