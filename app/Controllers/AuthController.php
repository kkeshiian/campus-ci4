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

        if ($this->request->getMethod() === 'get') {
            return view('auth/verif-otp', ['id_user' => $id_user]);
        }

        $otp = $this->request->getPost('otp');

        if (empty($otp)) {
            return redirect()->back()->with('error', 'OTP tidak boleh kosong');
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
            return redirect()->to('/auth/login')->with('success', 'Verifikasi berhasil. Silakan login.');
        } else {
            return redirect()->back()->with('error', 'OTP tidak valid atau sudah kadaluarsa');
        }
    }



    // GET /auth/logout
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/auth/login');
    }
}
