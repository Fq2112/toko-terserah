<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Banner;
use App\Models\Setting;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function show_setting()
    {
        return view('pages.main.admins.setting');
    }

    public function show_general()
    {
        $data = \App\Models\Setting::where('id', '!=', 0)->first();
        return view('pages.main.admins.setting.general', compact('data'));
    }

    public function update_general(Request $request)
    {
        $data = Setting::find($request->id);
        $data->update([
            'email' => $request->site_email,
            'phone' => $request->site_phone,
            'address' => $request->address
        ]);

        if ($request->hasFile('site_logo')) {
            $this->validate($request, ['site_logo' => 'required|image|mimes:jpg,jpeg,gif,png|max:5120']);
            $thumbnail = uniqid() . $request->file('site_logo')->getClientOriginalName();
            $request->file('site_logo')->move('images/', $thumbnail);
            $data->update([
                'logo' => 'images/' . $thumbnail
            ]);
        } else {
            $thumbnail = "";
        }

        return back()->with('success', 'Data Successfully Updated');
    }

    public function activeMaintenance(Request $request)
    {
        $owner = Admin::where('email', 'vincent.chang@terserah.com')->first();
        if (!Hash::check($request->password, $owner->password)) {
            return back()->with([
                'error' => 'Wrong Password Please Try Again!!'
            ]);
        } else {
            $data = Setting::find($request->id);
            if ($data->is_maintenance == 0) {
                $data->update([
                    'is_maintenance' => 1
                ]);
                return back()->with('success', 'Printshop Maintenance Mode Active');
            } else {
                $data->update([
                    'is_maintenance' => 0
                ]);
                return back()->with('success', 'Printshop Maintenance Done');
            }

        }
    }

    public function rule(Request $request)
    {
        $data = \App\Models\Setting::where('id', '!=', 0)->first();
        return view('pages.main.admins.setting.rules', compact('data'));
    }

    public function rules_update(Request $request)
    {
        $data = Setting::find($request->id);
        $data->update([
            'harga_pengiriman' => $request->harga_pengiriman,
            'min_pembelian' => $request->min_pembelian,
            'min_transaction' => $request->min_transaction,
            'packing' => $request->packing,
            'packing_desc' => $request->packing_desc,
            'percent_weight' => $request->percent_weight,
        ]);

        return back()->with('success', 'Berhasil Update Data');
    }

    public function show_maintenance()
    {
        $data = \App\Models\Setting::where('id', '!=', 0)->first();
        return view('pages.main.admins.setting.maintenance', compact('data'));
    }

    public function show_qna()
    {
        $data = Template::all();
        return view('pages.main.admins.pertanyaan', [
            'data' => $data
        ]);
    }

    public function show_banner()
    {
        $data = Banner::all();
        return view('pages.main.admins.banner', [
            'data' => $data
        ]);
    }
}
