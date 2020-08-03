<?php

namespace App\Http\Controllers\Pages\Admins\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\QnA;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QnAController extends Controller
{
    public function show(Request $request)
    {
        $data = QnA::when($request->period, function ($query) use ($request) {
            $query->whereBetween('updated_at', [Carbon::now()->subDay($request->period), Carbon::now()]);
        })->when($request->status, function ($query) use ($request) {
            $query->where('produk_id', $request->status);
        })->when($request->stat_jawab, function ($query) use ($request) {
               if ($request->stat_jawab == 'Belum')
                   $query->where('jawab','');
               elseif($request->stat_jawab == 'Terjawab')
                   $query->where('jawab','!=', '');

        })->orderBy('created_at', 'DESC')->get();

        return view('pages.main.admins.produk.qna', [
            'data' => $data
        ]);
    }

    public function jawab(Request $request)
    {
        $data = QnA::find($request->id);
        $data->update([
            'jawab' => $request->jawaban
        ]);
        return back()->with('success', 'Pertanyaan Customer Terjawab');
    }
}
