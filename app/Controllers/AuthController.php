<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OtpVerificationModel;
use App\Models\PembeliModel;
use App\Models\PenjualModel;

use App\Libraries\MailService;

class AuthController extends BaseController
{
    protected $session;
    protected $userModel;
    protected $otpModel;

    public function __construct()
    {
        $this->session    = session();
        $this->userModel  = new UserModel();
        $this->otpModel   = new OtpVerificationModel();
        $this->mailService = new MailService();
    }

    // GET /auth/login
    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $username = trim($this->request->getPost('username'));
            $password = trim($this->request->getPost('password'));

            if (empty($username) || empty($password)) {
                return redirect()->back()->with('error', 'Please fill in all fields!');
            }

            $model = new UserModel();
            $user = $model->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                session()->set([
                    'id_user'  => $user['id_user'],
                    'username' => $user['username'],
                    'Role'     => $user['role'],
                    'nama'     => $user['nama']
                ]);

                // Ambil role dan redirect
                switch (strtolower($user['role'])) {
                    case 'penjual':
                        $id_penjual = $model->getIdPenjual($user['id_user']);
                        session()->set('id_penjual', $id_penjual);
                        return redirect()->to(base_url("penjual/dashboard"));
                    case 'pembeli':
                        $id_pembeli = $this->userModel->getIdPembeli($user['id_user']);
                        session()->set('id_pembeli', $id_pembeli);
                        return redirect()->to(base_url("pembeli/canteen?id_pembeli=" . $id_pembeli));
                    case 'admin':
                        $id_admin = $model->getIdAdmin($user['id_user']);
                        if (!$id_admin) {
                            return redirect()->back()->with('error', 'Akun admin tidak ditemukan.');
                        }
                        session()->set('id_admin', $id_admin);
                        return redirect()->to(base_url("admin/dashboard"));
                    default:
                        return redirect()->to(base_url('/'));
                }
            } else {
                return redirect()->back()->with('error', 'Incorrect username or password!');
            }
        }

        return view('auth/login');
    }

    // POST /auth/login
    public function doLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->login($username);

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Username atau password salah');
        }

        if (!$user['is_verified']) {
            return redirect()->to('/auth/verif-otp')->with('error', 'Akun belum diverifikasi');
        }

        $this->session->set([
            'id_user' => $user['id_user'],
            'username' => $user['username'],
            'Role' => $user['role'],
            'is_logged_in' => true
        ]);

        // Redirect sesuai role
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        } elseif ($user['role'] === 'penjual') {
            return redirect()->to('/penjual/dashboard');
        } else {
            return redirect()->to('/pembeli/dashboard');
        }
    }

    // GET /auth/register
    public function register()
    {
        helper(['form', 'url']);
        $session = session();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'nama' => 'required',
                'username' => 'required',
                'email' => 'required|valid_email|',
                'nomor_wa' => 'required',
                'password' => 'required|min_length[8]|regex_match[/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_])/]',
                'konfirmasi_password' => 'required|matches[password]'
            ];

            $messages = [
                'email.regex_match' => 'Only email with domain @mhs.ulm.ac.id is allowed.',
                'password.regex_match' => 'Password must contain upper, lower, number, and symbol.'
            ];

            if (!$this->validate($rules, $messages)) {
                return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
            }

            $model = new \App\Models\UserModel();

            if ($model->emailExists($this->request->getPost('email'))) {
                return redirect()->back()->withInput()->with('error', 'Email already registered.');
            }

            $hashed = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            $id_user = $model->createUser([
                'nama' => $this->request->getPost('nama'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'nomor_wa' => $this->request->getPost('nomor_wa'),
                'password' => $hashed,
                'role' => 'pembeli'
            ]);

            if (!$id_user) {
                return redirect()->back()->with('error', 'Failed to create user. ID is null.');
            }

            // ✅ simpan ke session dengan key yang benar
            session()->set('id_user_pending', $id_user);

            // ✅ kirim OTP
            $otpModel = new \App\Models\OtpVerificationModel();
            if ($otpModel->sendOtp($id_user)) {
                return redirect()->to(base_url('auth/verif-otp'))->with('success', 'Register success! Please verify your email.');
            } else {
                return redirect()->back()->with('error', 'Failed to send OTP.');
            }

            return redirect()->back()->with('error', 'Registration failed.');
        }

        return view('auth/register');
    }


    // POST /auth/register
    public function doRegister()
    {
        $data = $this->request->getPost();

        $userData = [
            'nama'     => $data['nama'],
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => $data['role'],
            'email'    => $data['email'],
            'nomor_wa' => $data['nomor_wa'],
            'is_verified' => 0
        ];

        $id_user = $this->userModel->insert($userData);

        $otp_code = $this->otpModel->generateOTP();
        $this->otpModel->invalidateOldOtp($id_user);
        $this->otpModel->saveOtp($id_user, $otp_code);

        $mailer = new MailService();
        $mailer->sendOtpVerification($data['email'], $data['nama'], $otp_code);

        $this->session->set('id_user_pending', $id_user);

        return redirect()->to('/auth/verif-otp')->with('success', 'Silakan cek email untuk OTP');
    }

    // POST /auth/verif-otp
    public function verifOtp()
    {
        $id_user = $this->session->get('id_user_pending');
        session()->set('id_user_pending', $id_user);

        if ($this->request->getMethod() === 'get') {
            return view('auth/verif-otp', ['id_user' => $id_user]);
        }

        $otp = $this->request->getPost('otp');

        if (empty($otp)) {
            return redirect()->back()->with('error', 'OTP is not allowed to empty');
        }

        $otpValid = $this->otpModel->verifyOtp($otp, $id_user);

        if ($otpValid) {
            $this->otpModel->markOtpUsedById($otpValid['id']);
            $this->userModel->update($id_user, ['is_verified' => 1]);

            $user = $this->userModel->find($id_user);

            if (!$user) {
                return redirect()->to('/auth/register')->with('error', 'User tidak ditemukan');
            }

            if ($user['role'] === 'pembeli') {
                (new PembeliModel())->tambahPembeli($id_user, $user['nama']);
            } elseif ($user['role'] === 'penjual') {
                (new PenjualModel())->tambahPenjual($id_user, [
                    'nama' => $user['nama'],
                    'nama_kantin' => null,
                ]);
            }

            $this->session->remove('id_user_pending');
            return redirect()->to('/auth/login')->with('success', 'Verifikasi is succesfullt. Please login.');
        } else {
            return redirect()->back()->with('error', 'OTP code is note valid or already expired');
        }
    }



    // GET /auth/logout
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/auth/login');
    }
    
    public function resendRegisterOtp()
    {
        $id_user = $this->session->get('id_user_pending') ?? $this->request->getPost('user_id');

        if (!$id_user) {
            return redirect()->back()->with('error', 'No active registration verification request.');
        }

        $user = $this->userModel->find($id_user);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Generate dan simpan OTP baru
        $newOtpCode = $this->otpModel->generateOTP();
        $this->otpModel->invalidateOldOtp($id_user); // Invalidate OTP lama
        $this->otpModel->saveOtp($id_user, $newOtpCode, date('Y-m-d H:i:s', strtotime('+5 minutes')));

        // Kirim email OTP baru
        if ($this->mailService->sendOtpVerification($user['email'], $user['nama'], $newOtpCode)) {
            return redirect()->back()->with('success', 'New OTP has been sent to your email.');
        } else {
            log_message('error', 'Failed to resend registration OTP email for user ID: ' . $id_user);
            return redirect()->back()->with('error', 'Failed to resend OTP. Please try again later.');
        }
    }


    // --- Fitur Reset Password ---

    // GET /auth/forgot-password (Tampilkan form lupa password)
    public function forgotPassword()
    {
        return view('auth/input_email');
    }

    // POST /auth/send-reset-link (Proses permintaan lupa password, kirim OTP)
    public function sendResetLink()
    {
        $rules = [
            'email' => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $user = $this->userModel->getUserByEmail($email);

        if (!$user) {
            // Pesan umum untuk keamanan agar tidak memberitahu apakah email ada atau tidak
            return redirect()->back()->with('success', 'If your email is in our system, a password reset OTP has been sent.');
        }

        // Generate dan simpan OTP untuk reset password
        $otpCode = $this->otpModel->generateOTP();
        $this->otpModel->invalidateOldOtp($user['id_user']); // Invalidate OTP lama untuk user ini
        $this->otpModel->saveOtp($user['id_user'], $otpCode, date('Y-m-d H:i:s', strtotime('+5 minutes')));

        // Kirim email OTP reset password
        if ($this->mailService->sendOtpResetPassword($user['email'], $user['nama'], $otpCode)) {
            // Simpan ID user di sesi untuk verifikasi OTP reset password
            $this->session->set('id_user_pending_reset_password', $user['id_user']);
            return redirect()->to(base_url('auth/verif-otp-reset'))->with('success', 'Password reset OTP has been sent to your email.');
        } else {
            log_message('error', 'Failed to send password reset OTP email for user ID: ' . $user['id_user']);
            return redirect()->back()->withInput()->with('error', 'Failed to send password reset OTP. Please try again later.');
        }
    }

    public function resetPasswordPages(){
        return view('auth/reset_password'); 
    }

    // GET & POST /auth/verif-otp-reset (Verifikasi OTP untuk reset password)
    public function verifOtpReset()
    {
        $id_user = $this->session->get('id_user_pending_reset_password');

        if (!$id_user) {
            return redirect()->to(base_url('auth/forgot-password'))->with('error', 'Please request a password reset first.');
        }

        // Tampilkan form jika request GET
        if ($this->request->getMethod() === 'get') {
            return view('auth/verif-otp-reset', ['id_user' => $id_user]);
        }

        // Proses verifikasi OTP jika request POST
        $otp = $this->request->getPost('otp');

        if (empty($otp)) {
            return redirect()->back()->withInput()->with('error', 'Please enter the OTP code.');
        }

        $otpRecord = $this->otpModel->verifyOtp($otp, $id_user);
        session()->set('reset_user_id', $otpRecord['id_user']);

        if ($otpRecord) {
            $this->otpModel->markOtpUsedById($otpRecord['id']); // Mark OTP as usedl

            // Hapus sesi OTP pending reset password
            $this->session->remove('id_user_pending_reset_password');

            // Redirect ke form reset password dengan token
            return redirect()->to(base_url('auth/reset-password/'))->with('success', 'OTP verified. Please set your new password.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Incorrect or expired OTP Code!');
        }
    }

    // POST /auth/resend-otp-reset (Resend OTP untuk reset password)
    public function resendOtpReset()
    {
        $id_user = $this->session->get('id_user_pending_reset_password') ?? $this->request->getPost('user_id');

        if (!$id_user) {
            return redirect()->back()->with('error', 'No active password reset request.');
        }

        $user = $this->userModel->find($id_user);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Generate dan simpan OTP baru
        $newOtpCode = $this->otpModel->generateOTP();
        $this->otpModel->invalidateOldOtp($id_user); // Invalidate OTP lama
        $this->otpModel->saveOtp($id_user, $newOtpCode, date('Y-m-d H:i:s', strtotime('+5 minutes')));

        // Kirim email OTP baru untuk reset password
        if ($this->mailService->sendOtpResetPassword($user['email'], $user['nama'], $newOtpCode)) {
            return redirect()->back()->with('success', 'New OTP has been sent to your email.');
        } else {
            log_message('error', 'Failed to resend password reset OTP email for user ID: ' . $id_user);
            return redirect()->back()->with('error', 'Failed to resend OTP. Please try again later.');
        }
    }


    // GET & POST /auth/reset-password/{token} (Tampilkan dan proses form reset password)
    public function resetPassword()
    {
        // Tampilkan form saat GET
        if ($this->request->getMethod() === 'get') {
            return view('auth/reset_password');
        }

        // Validasi input
        $rules = [
            'password' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/]',
            'konfirmasi_password' => 'required|matches[password]',
        ];

        $messages = [
            'password' => [
                'regex_match' => 'Password harus mengandung huruf besar, kecil, angka, dan karakter khusus.'
            ],
            'konfirmasi_password' => [
                'matches' => 'Konfirmasi password tidak cocok.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil user dari session
        $id_user = session()->get('reset_user_id'); // pastikan ini sudah diset setelah verif OTP

        if (!$id_user) {
            return redirect()->to(base_url('auth/forgot-password'))->with('error', 'Sesi reset tidak valid.');
        }

        $newPassword = $this->request->getPost('password');

        // Ganti password
        if ($this->userModel->changePassword($id_user, $newPassword)) {
            // Clear session dan redirect
            session()->remove('reset_user_id');
            return redirect()->to(base_url('auth/login'))->with('success', 'Password berhasil direset. Silakan login.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mereset password. Silakan coba lagi.');
        }
    }

}
