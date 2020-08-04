<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        $data = Pesanan::when($request->period, function ($query) use ($request) {
            $query->whereBetween('updated_at', [Carbon::now()->subDay($request->period), Carbon::now()]);
        })->when($request->status, function ($query) use ($request) {
            $query->where('isLunas', $request->status);
        })->orderBy('updated_at', 'DESC')->get();
        return view('pages.main.admins.payment', [
            'data' => $data
        ]);
    }

    public function update_resi(Request $request)
    {
        try {
            $data = Pesanan::find($request->id);
            $data->update([
               'resi' => $request->resi
            ]);
            return back()->with('success' , 'Pesanan '.$data->uni_code. 'Berhasil Di berikan Resi');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function create_label(Request $request)
    {
        try {
            $data = Pesanan::where('uni_code',$request->code)->first();

            $labelname = $data->uni_code . '.pdf';
            $labelPdf = PDF::loadView('exports.shipping', [
                'data' => $data,
            ]);
            $labelPdf->setPaper('a5', 'potrait');
            Storage::put('public/users/order/invoice/owner/label/' . $data->uni_code . '/' . $labelname, $labelPdf->output());

            dd($labelPdf);
            return \response()->json([
                'message' => 'pdf tersimpan'
            ],201);
        }catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function download_label(Request $request)
    {
        $filename = $request->code . '.pdf';
        $file_path = storage_path('app/public/users/order/invoice/owner/label/' . $request->code . '/' . $filename);
        if (file_exists($file_path)) {
            return Response::download($file_path, 'Shipping_Label_' . $filename, [
                'Content-length : ' . filesize($file_path)
            ]);
        } else {
            return \response()->json([
                'message' => "Oops! The current file you are looking for is not available "
            ], 404);
        }
    }

    public function download_invoice(Request $request)
    {
        $filename = $request->code . '.pdf';
        $file_path = storage_path('app/public/users/invoice/' . $request->user_id . '/' . $filename);
        if (file_exists($file_path)) {
            return Response::download($file_path, 'Invoice_' . $filename, [
                'Content-length : ' . filesize($file_path)
            ]);
        } else {
            return response()->json([
                'message' => "Oops! The current file you are looking for is not available "
            ], 404);
        }
    }
}
