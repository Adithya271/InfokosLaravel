<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPemilik;
use App\Models\UserPencari;
use App\Models\UserAdmin;
use Validator;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Mail\MailRegisterPemilikConfirm;
use App\Mail\MailRegisterPencariConfirm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;



class AuthController extends Controller
{
    public function registerpemilik(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'nomorHp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ada kesalahan',
                'data' => $validator->errors()
            ]);
        }

        $signature = Str::uuid();

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['remember_token'] = $signature;
        $input['role'] = 'pemilik';
        $userpemilik = UserPemilik::create($input);

        $confirmationUrl = url('/api/registerpemilik/confirmationpemilik/' . $userpemilik->id) . '?signature=' . $signature;

        Mail::to($userpemilik->email)->queue(new MailRegisterPemilikConfirm($userpemilik, $confirmationUrl));

        return response()->json([
            'success' => true,
            'message' => 'Sukses register, silahkan cek email anda untuk verifikasi',
        ]);
    }

    public function registerpencari(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'nomorHp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ada kesalahan',
                'data' => $validator->errors()
            ]);
        }

        $signature = Str::uuid();
        Log::info('Generated Signature: ' . $signature);

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['remember_token'] = $signature;
        $input['role'] = 'pencari';
        $userpencari = UserPencari::create($input);

        $confirmationUrl = url('/api/registerpencari/confirmation/' . $userpencari->id) . '?signature=' . $signature;

        Mail::to($userpencari->email)->queue(new MailRegisterPencariConfirm($userpencari, $confirmationUrl));

        return response()->json([
            'success' => true,
            'message' => 'Sukses register, silahkan cek email anda untuk verifikasi',
        ]);
    }


    public function confirmationpencari(Request $request, $id)
    {
        $key = $request->query('signature');

        Log::info('ID: ' . $id);
        Log::info('Signature: ' . $key);
        $user = UserPencari::where('id', $id)->where('remember_token', $key)->first();

        if ($user) {
            $user->email_verified_at = Carbon::now();
            $user->save();

            return view('confirmation.success', ['message' => 'Verifikasi email telah berhasil, silahkan login menggunakan email ini']);
        }
        Log::info('User: ' . $user);

        return view('confirmation.failure', ['message' => 'Verifikasi gagal, terjadi kesalahan']);
    }

    public function confirmationpemilik(Request $request, $id)
    {
        $key = $request->query('signature');

        Log::info('ID: ' . $id);
        Log::info('Signature: ' . $key);
        $user = UserPemilik::where('id', $id)->where('remember_token', $key)->first();

        if ($user) {

            $user->email_verified_at = Carbon::now();
            $user->save();

            return view('confirmation.success', ['message' => 'Verifikasi email telah berhasil, silahkan login menggunakan email ini']);
        }
        Log::info('User: ' . $user);

        return view('confirmation.failure', ['message' => 'Verifikasi gagal, terjadi kesalahan']);
    }

    public function loginpemilik(Request $request)
    {
        $userpemilik = UserPemilik::where('email', $request->email)->first();


        if (!$userpemilik || !Hash::check($request->password, $userpemilik->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Cek Email dan password lagi',
                'data' => null
            ]);
        }

        if (!$userpemilik->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Email belum diverifikasi. Silakan verifikasi email Anda.',
                'data' => null
            ]);
        }

        $token = $userpemilik->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Sukses Login',
            'data' => [
                'token' => $token,
                'id' => $userpemilik->id,
                'nama' => $userpemilik->nama,
                'email' => $userpemilik->email,
                'nomorHp' => $userpemilik->nomorHp,
                'profilGambar' => $userpemilik->profilGambar,
                'namaBank' => $userpemilik->namaBank,
                'noRek' => $userpemilik->noRek,
                'atasNama' => $userpemilik->atasNama
            ]
        ]);
    }


    public function loginpencari(Request $request)
    {
        $userpencari = UserPencari::where('email', $request->email)->first();

        if (!$userpencari || !Hash::check($request->password, $userpencari->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Cek Email dan password lagi',
                'data' => null
            ]);
        }

        if (!$userpencari->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Email belum diverifikasi. Silakan verifikasi email Anda.',
                'data' => null
            ]);
        }

        $token = $userpencari->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Sukses Login',
            'data' => [
                'token' => $token,
                'id' => $userpencari->id,
                'nama' => $userpencari->nama,
                'email' => $userpencari->email,
                'nomorHp' => $userpencari->nomorHp,
                'profilGambar' => $userpencari->profilGambar
            ]
        ]);
    }


    public function showLoginAdminForm()
    {
        return view('login');
    }



    public function loginadmin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect()->route('dashboard');
        } else {

            return redirect()->route('login')->with([
                'error' => 'Cek Email dan password lagi',
            ]);
        }
    }

    public function logoutadmin(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();

            return redirect()->route('login')->with([
                'success' => 'Successfully logged out.',
            ]);
        } else {
            return redirect()->route('login')->with([
                'error' => 'You are not logged in.',
            ]);
        }
    }


    public function logout(Request $request)
    {
        if (Auth::check()) {

            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You are not logged in.',
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ada kesalahan',
                'data' => $validator->errors()
            ]);
        }

        // Cek jika user exists  UserPemilik dan UserPencari
        $userpemilik = UserPemilik::where('email', $request->email)->first();
        $userpencari = UserPencari::where('email', $request->email)->first();

        // jika ada user, update  password
        if ($userpemilik) {
            $userpemilik->update([
                'password' => bcrypt($request->password)
            ]);
        } elseif ($userpencari) {
            $userpencari->update([
                'password' => bcrypt($request->password)
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'User dengan email tersebut tidak ditemukan.',
                'data' => null
            ]);
        }


        return response()->json([
            'success' => true,
            'message' => 'Sukses mengubah password.',
        ]);
    }
}
