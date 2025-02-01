<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class UserApiController extends Controller
{
    /**
     * GET Semua User (Public)
     */
    public function index()
    {
        try {
            $users = User::select('id', 'name', 'email', 'is_active', 'created_at')->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Daftar user berhasil diambil',
                'data' => $users
            ], 200);
        } catch (Exception $e) {
            return $this->serverErrorResponse('Gagal mengambil daftar user', $e);
        }
    }

    /**
     * REGISTER User Baru
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => "1", // Default aktif
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil didaftarkan',
                'data' => $user
            ], 201);
        } catch (Exception $e) {
            return $this->serverErrorResponse('Gagal melakukan registrasi', $e);
        }
    }

    /**
     * LOGIN User & Dapatkan Token JWT
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email atau password salah'
                ], 401);
            }

            $user = auth()->user();
            if ($user->is_active == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akun Anda belum aktif'
                ], 403);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_active' => $user->is_active,
                ]
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat token'
            ], 500);
        }
    }

    /**
     * LOGOUT User (Menghapus Token)
     */
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'status' => 'success',
                'message' => 'Logout berhasil'
            ], 200);
        } catch (Exception $e) {
            return $this->serverErrorResponse('Gagal logout', $e);
        }
    }

    /**
     * GET Data User yang Sedang Login
     */
    public function profile()
    {
        try {
            return response()->json([
                'status' => 'success',
                'message' => 'Data user ditemukan',
                'data' => auth()->user()
            ], 200);
        } catch (Exception $e) {
            return $this->serverErrorResponse('Gagal mengambil data user', $e);
        }
    }

    /**
     * Server Error Response
     */
    private function serverErrorResponse($message, $exception)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'error' => $exception->getMessage()
        ], 500);
    }
}
