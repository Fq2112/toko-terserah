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

    public function print_order(Request $request)
    {

//        dd($request->all());
        $data = Pesanan::query()->when($request->start, function ($query) use ($request) {
            $query->whereBetween('updated_at', [Carbon::parse($request->start)->subDay(), Carbon::parse($request->end)->addDay()]);
        })->when($request->jenis, function ($query) use ($request) {
            if ($request->jenis == 'semua') {

            } elseif ($request->jenis == 'true') {
                $query->where('isLunas', true);
            } elseif ($request->jenis == 'false') {
                $query->where('isLunas', false);
            }
        })->orderBy('updated_at', 'DESC')->get();
//        dd($data);
        $pdf = PDF::loadView('exports.order',
            [
                'data' => $data
            ])
            ->setPaper('a4', 'landscape');


        return $pdf->stream('Laporan Pemesanan Periode' . $request->start . '.pdf');

    }

    public function show_order(Request $request)
    {
        $data = Pesanan::where('uni_code', $request->kode)->first();
        return view('pages.main.admins.detail_pesanan', [
            'data' => $data
        ]);
    }

    public function update_resi(Request $request)
    {
        try {
            $data = Pesanan::find(decrypt($request->id));
            $data->update([
                'resi' => $request->resi,
                'tgl_pengiriman' => Carbon::now()
            ]);
            return back()->with('success', 'Pesanan ' . $data->uni_code . 'Berhasil Di berikan Resi');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update_tgl_pengririman_toko_terserah(Request $request)
    {
        try {
            $data = Pesanan::find($request->id);
            $data->update([
                'tgl_pengiriman' => Carbon::now()
            ]);
            return back()->with('success', 'Pesanan ' . $data->uni_code . 'Berhasil Diperbarui');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update_resi_(Request $request)
    {
        try {
            $data = Pesanan::find($request->id);
            $data->update([
                'resi' => $request->resi,
                'tgl_pengiriman' => Carbon::now()
            ]);
            return back()->with('success', 'Pesanan ' . $data->uni_code . 'Berhasil Di berikan Resi');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function create_label(Request $request)
    {
        try {
            $data = Pesanan::where('uni_code', $request->code)->first();

            $labelname = $data->uni_code . '.pdf';
            $labelPdf = PDF::loadView('exports.shipping', [
                'data' => $data,
            ]);
            $labelPdf->setPaper('a5', 'potrait');
            Storage::put('public/users/order/invoice/owner/label/' . $data->uni_code . '/' . $labelname, $labelPdf->output());

            dd($labelPdf);
            return \response()->json([
                'message' => 'pdf tersimpan'
            ], 201);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function download_label($code)
    {
        $filename = $code . '.pdf';
        $file_path = storage_path('app/public/users/order/invoice/owner/label/' . $code . '/' . $filename);
        if (file_exists($file_path)) {
            return Response::download($file_path, 'Shipping_Label_' . $filename, [
                'Content-length : ' . filesize($file_path)
            ]);
        } else {
            return back()->with([
                'error' => "Oops! The current file you are looking for is not available "
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

    public function get_download_invoice($user_id, $code)
    {
        $filename = $code . '.pdf';
        $file_path = storage_path('app/public/users/invoice/' . $user_id . '/' . $filename);
        if (file_exists($file_path)) {
            return Response::download($file_path, 'Invoice_' . $filename, [
                'Content-length : ' . filesize($file_path)
            ]);
        } else {
            return back()->with('error', "Oops! The current file you are looking for is not available ");
        }
    }
}
