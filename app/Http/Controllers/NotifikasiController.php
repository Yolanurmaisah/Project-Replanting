<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $notifikasi = $request->user()->notifikasi()->with('kebun')->latest()->paginate(15);

        return view('notifikasi.index', compact('notifikasi'));
    }

    public function baca(Request $request, Notifikasi $notifikasi)
    {
        abort_unless($notifikasi->user_id === $request->user()->id, 403);
        $notifikasi->update(['sudah_dibaca' => true]);

        return back();
    }

    public function bacaSemua(Request $request)
    {
        $request->user()->notifikasi()->where('sudah_dibaca', false)->update(['sudah_dibaca' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
