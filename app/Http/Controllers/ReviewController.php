<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Review;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function store(Request $request, $transaction_id)
    {
        // 1. Validasi input bintang & komentar
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        $transaction = Transaction::findOrFail($transaction_id);

        // 2. Cek apakah statusnya Success
        if (strtolower($transaction->status) !== 'success') {
            return back()->with('error', 'Hanya pemilik tiket yang valid yang dapat memberi ulasan.');
        }

        // 3. Cek apakah sudah pernah review (mencegah spam)
        $sudahReview = Review::where('transaction_id', $transaction->id)->exists();
        if ($sudahReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk tiket ini.');
        }

        // 4. Simpan ke database
        Review::create([
            'event_id' => $transaction->event_id,
            'transaction_id' => $transaction->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}