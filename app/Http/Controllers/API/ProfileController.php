<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update_bio(Request $request)
    {
        try {
            $user = User::find($request->user_id);

            $user->update([
               'name' => $request->name
            ]);

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

    public function upload_ava(Request $request)
    {
        try {
            $user = User::find($request->user_id);

            if ($request->hasFile('ava')) {
                $this->validate($request, ['ava' => 'required|image|mimes:jpg,jpeg,gif,png|max:5120']);
                $thumbnail = uniqid().$request->file('ava')->getClientOriginalName();
//            Storage::delete('public/blog/thumbnail/' . $thumbnail);
                $request->file('ava')->storeAs('public/users/ava/', $thumbnail);

                $user->getBio->update([
                    'ava' => $thumbnail
                ]);
            }

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

    public function upload_background(Request $request)
    {
        try {
            $user = User::find($request->user_id);

            if ($request->hasFile('ava')) {
                $this->validate($request, ['ava' => 'required|image|mimes:jpg,jpeg,gif,png|max:5120']);
                $thumbnail =uniqid().$request->file('ava')->getClientOriginalName();
//            Storage::delete('public/blog/thumbnail/' . $thumbnail);
                $request->file('ava')->storeAs('public/users/ava/', $thumbnail);

                $user->getBio->update([
                    'background' => $thumbnail
                ]);
            }

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

    public function change_password(Request $request)
    {
        try {

            $admin = User::find($request->user_id);

            if (!Hash::check($request->password, $admin->password)) {
                return response()->json([
                    'error' => true,
                    'data' => [
                        'message' => "Password Lama Salah"
                    ]
                ],500);

            } else {
                if ($request->new_password != $request->password_confirmation) {
                    return response()->json([
                        'error' => true,
                        'data' => [
                            'message' => "Password Konfirmasi tidak sama"
                        ]
                    ],500);

                } else {
                    $admin->update([
                        'password' => bcrypt($request->new_password)
                    ]);

                    return response()->json([
                        'error' => false,
                        'data' => [
                            'message' => "Password Berhasil Diubah"
                        ]
                    ],200);

                }
            }

        }catch (ModelNotFoundException $e) {
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
