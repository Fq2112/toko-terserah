<?php

namespace App\Http\Controllers\Pages\Users;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use App\Models\OccupancyType;
use App\Models\Provinsi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AkunController extends Controller
{
    public function profil(Request $request)
    {
        $user = Auth::user();
        $bio = $user->getBio;
        $addresses = Alamat::where('user_id', Auth::id())->orderByDesc('id')->get();
        $address = Alamat::where('user_id', $user->id)->where('isUtama', true)->first();

        $provinces = Provinsi::all();
        $occupancy = OccupancyType::all();

        $check = $request->check;

        return view('pages.main.users.sunting-profil', compact('user', 'bio', 'addresses',
            'address', 'provinces', 'occupancy', 'check'));
    }

    public function updateProfil(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $user->update(['name' => $request->name]);
        $user->getBio->update([
            'gender' => $request->gender,
            'dob' => $request->dob,
            'phone' => preg_replace("![^a-z0-9+]+!i", "", $request->phone),
        ]);

        return redirect()->route('user.profil')->with('update', 'Data personal Anda berhasil diperbarui!');
    }

    public function createProfilAddress(Request $request)
    {
        if ($request->isUtama == 1) {
            Alamat::where('user_id', Auth::id())->update(['isUtama' => false]);
        }

        Alamat::create([
            'user_id' => Auth::id(),
            'nama' => $request->address_name,
            'telp' => preg_replace("![^a-z0-9+]+!i", "", $request->address_phone),
            'kecamatan_id' => $request->kecamatan_id,
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat,
            'lat' => $request->lat,
            'long' => $request->long,
            'occupancy_id' => $request->occupancy_id,
            'isUtama' => $request->has('isUtama') ? $request->isUtama : false,
        ]);

        return back()->with('add', 'Alamat [' . $request->alamat . '] berhasil ditambahkan ke daftar alamat Anda!');
    }

    public function updateProfilAddress(Request $request)
    {
        if ($request->isUtama == 1) {
            Alamat::where('user_id', Auth::id())->update(['isUtama' => false]);
        }

        $address = Alamat::find($request->id);
        $address->update([
            'nama' => $request->address_name,
            'telp' => preg_replace("![^a-z0-9+]+!i", "", $request->address_phone),
            'kecamatan_id' => $request->kecamatan_id,
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat,
            'lat' => $request->lat,
            'long' => $request->long,
            'occupancy_id' => $request->occupancy_id,
            'isUtama' => $request->has('isUtama') ? $request->isUtama : false,
        ]);

        return back()->with('update', 'Alamat [' . $address->alamat . '] berhasil diperbarui dari daftar alamat Anda!');
    }

    public function deleteProfilAddress(Request $request)
    {
        $address = Alamat::find($request->id);
        $address->delete();

        return back()->with('delete', 'Alamat [' . $address->alamat . '] berhasil dihapuskan dari daftar alamat Anda!');
    }

    public function pengaturan()
    {
        $user = Auth::user();
        $bio = $user->getBio;
        $alamat = Alamat::where('user_id', $user->id)->where('isUtama', true)->first();

        return view('pages.main.users.pengaturan-akun', compact('user', 'bio', 'alamat'));
    }

    public function updatePengaturan(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        if ($request->hasFile('ava')) {
            $this->validate($request, ['ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048']);

            $name = $request->file('ava')->getClientOriginalName();

            if ($user->getBio->ava != '') {
                Storage::delete('public/users/ava/' . $user->getBio->ava);
            }

            if ($request->file('ava')->isValid()) {
                $request->ava->storeAs('public/users/ava', $name);
                $user->getBio->update(['ava' => $name]);
                return asset('storage/users/ava/' . $name);
            }

        } elseif ($request->hasFile('background')) {
            $this->validate($request, ['background' => 'image|mimes:jpg,jpeg,gif,png|max:5120']);

            $name = $request->file('background')->getClientOriginalName();

            if ($user->getBio->background != '') {
                Storage::delete('public/users/background/' . $user->getBio->background);
            }

            if ($request->file('background')->isValid()) {
                $request->background->storeAs('public/users/background', $name);
                $user->getBio->update(['background' => $name]);
                return $name;
            }

        } else {
            if ($request->has('username')) {
                $check = User::where('username', $request->username)->first();

                if (!$check || $request->username == Auth::user()->username) {
                    $user->update(['username' => $request->username]);
                    return $user->username;
                } else {
                    return 0;
                }

            } else {
                if (!Hash::check($request->password, $user->password)) {
                    return 0;
                } else {
                    if ($request->new_password != $request->password_confirmation) {
                        return 1;
                    } else {
                        $user->update(['password' => bcrypt($request->new_password)]);
                        return 2;
                    }
                }
            }
        }
    }
}
