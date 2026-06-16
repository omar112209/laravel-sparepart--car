<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;

class CustomerController extends Controller
{
    public function showLoginForm()
    {
        return view('v_customer.login', [
            'judul' => 'Login Customer'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            if ($user->role != 2) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                return back()->with('error', 'Akun ini bukan akun customer.');
            }
            $request->session()->regenerate();
            return redirect()->intended('/beranda')->with('success', 'Selamat datang, ' . $user->nama . '!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('v_customer.register', [
            'judul' => 'Register Customer'
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email|max:255|unique:user,email',
            'hp' => 'nullable|min:10|max:13',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'hp' => $request->hp ?? '',
            'role' => '2',
            'status' => 1,
            'password' => Hash::make($request->password),
        ]);

        Customer::create([
            'user_id' => $user->id,
            'google_id' => '',
            'google_token' => '',
        ]);

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect('/beranda')->with('success', 'Akun berhasil dibuat, selamat datang ' . $user->nama . '!');
    }

    // Redirect ke Google
    public function redirect()
    {
        return Socialite::driver('google')
            ->redirectUrl(route('auth.callback'))
            ->redirect();
    }
    // Callback dari Google
    public function callback()
    {
        try {
            $socialUser = Socialite::driver('google')
                ->redirectUrl(route('auth.callback'))
                ->user();
            // Cek apakah email sudah terdaftar
            $registeredUser = User::where('email', $socialUser->email)->first();
            if (!$registeredUser) {
                // Buat user baru
                $user = User::create([
                    'nama' => $socialUser->name,
                    'email' => $socialUser->email,
                    'role' => '2', // Role customer
                    'hp' => '',
                    'status' => 1, // Status aktif
                    'password' => Hash::make(Str::random(32)),
                ]);
                // Buat data customer
                Customer::create([
                    'user_id' => $user->id,
                    'google_id' => $socialUser->id,
                    'google_token' => $socialUser->token
                ]);
                // Login pengguna baru
                Auth::guard('web')->login($user);
            } else {
                // Jika email sudah terdaftar, update google_id & token lalu login
                $registeredUser->customer->update([
                    'google_id' => $socialUser->id,
                    'google_token' => $socialUser->token,
                ]);
                Auth::guard('web')->login($registeredUser);
            }
            // Redirect ke halaman utama
            return redirect()->intended('beranda');
        } catch (\Exception $e) {
            // Redirect ke halaman utama jika terjadi kesalahan
            return redirect()->route('login')->with('error', 'Login dengan Google gagal: ' . $e->getMessage());
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // Logout pengguna
        $request->session()->invalidate(); // Hapus session
        $request->session()->regenerateToken(); // Regenerate token CSRF
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
    public function index()
    {
        $customer = Customer::orderBy('id', 'desc')->get();
        return view('backend.v_customer.index', [
            'judul' => 'Customer',
            'sub' => 'Halaman Customer',
            'index' => $customer
        ]);
    }
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('backend.customer.index')->with('success', 'Customer berhasil dihapus.');
    }
    public function akun($id)
    {
        $loggedInCustomerId = Auth::guard('web')->user()->id;
        // Cek apakah ID yang diberikan sama dengan ID customer yang sedang login
        if ($id != $loggedInCustomerId) {
            // Redirect atau tampilkan pesan error
            return redirect()->route('customer.akun', ['id' => $loggedInCustomerId])->with('msgError', 'Anda tidak berhak mengakses akun ini.');
        }
        $customer = Customer::where('user_id', $id)->firstOrFail();
        return view('v_customer.edit', compact('customer'));
    }
    public function updateAkun(Request $request, $id)
    {
        $loggedInCustomerId = Auth::guard('web')->user()->id;
        if ($id != $loggedInCustomerId) {
            return redirect()->route('customer.akun', ['id' => $loggedInCustomerId])->with('msgError', 'Anda tidak berhak mengakses akun ini.');
        }
        $customer = Customer::where('user_id', $id)->firstOrFail();
        $rules = [
            'nama' => 'required|max:255',
            'hp' => 'required|min:10|max:13',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ];
        $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.'
        ];
        if ($request->email != $customer->user->email) {
            $rules['email'] = 'required|max:255|email|unique:customer';
        }
        if ($request->pos != $customer->pos) {
            $rules['pos'] = 'required';
        }
        $validatedData = $request->validate($rules, $messages);
        // menggunakan ImageHelper
        if ($request->file('foto')) {
            //hapus gambar lama
            if ($customer->user->foto) {
                $oldImagePath = public_path('storage/img-customer/') . $customer->user->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-customer/';
            // Simpan gambar dengan ukuran yang ditentukan
            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400); //null (jika tinggi otomatis)
            // Simpan nama file asli di database
            $validatedData['foto'] = $originalFileName;
        }
        $customer->user->update($validatedData);
        $customer->update([
            'detail_alamat' => $request->input('detail_alamat'),
            'provinsi'      => $request->input('provinsi'),
            'provinsi_id'   => $request->input('provinsi_id'),
            'kota_kabupaten'=> $request->input('kota_kabupaten'),
            'kota_id'       => $request->input('kota_id'),
            'kecamatan'     => $request->input('kecamatan'),
            'kecamatan_id'  => $request->input('kecamatan_id'),
            'pos'           => $request->input('pos'),
        ]);
        return redirect()->route('customer.akun', $id)->with('success', 'Data berhasil diperbarui');
    }
}
