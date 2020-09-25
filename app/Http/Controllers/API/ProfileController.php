<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update_bio(Request $request)
    {
        try {
            $user = User::find($request->user_id);

            $user->getBio->update([
                'gender' => $request->gender,
                'dob' => $request->dob,
                'phone' => preg_replace("![^a-z0-9+]+!i", "", $request->phone),
            ]);
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Berhasil Memperbarui Profil'
                ]
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $e->getMessage()
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }
    }

    public function add_address(Request $request)
    {
        try {
            if ($request->isUtama == 1) {
                Alamat::where('user_id', $request->uesr_id)->update(['isUtama' => false]);
            }

            Alamat::create([
                'user_id' => $request->uesr_id,
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
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Berhasil Menambahkan alamat'
                ]
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $e->getMessage()
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }
    }

    public function update_address(Request $request)
    {

    }

    public function delete_address($id)
    {
        try {
            $address = Alamat::find($id);
            $address->delete();
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Berhasil Menghapus alamat'
                ]
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $e->getMessage()
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }
    }


}
