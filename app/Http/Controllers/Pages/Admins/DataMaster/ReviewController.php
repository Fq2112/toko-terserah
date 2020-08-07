<?php

namespace App\Http\Controllers\Pages\Admins\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show(Request $request)
    {
        $data = Ulasan::when($request->period, function ($query) use ($request) {
            $query->whereBetween('updated_at', [Carbon::now()->subDay($request->period), Carbon::now()]);
        })->when($request->status, function ($query) use ($request) {
            $query->where('produk_id', $request->status);
        })->orderBy('updated_at', 'DESC')->get();

        return view('pages.main.admins.produk.ulasan', [
            'data' => $data
        ]);
    }
}
