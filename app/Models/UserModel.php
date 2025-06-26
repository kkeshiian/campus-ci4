<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id_user';
    protected $allowedFields    = [
        'nama', 'username', 'password', 'role', 'nomor_wa', 'email', 'is_verified'
    ];

    // 🔐 Login
    public function login($username)
    {
        return $this->where('username', $username)->first();
    }

    // 🔑 Update Password (umum)
    public function changePassword($id_user, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $this->update($id_user, ['password' => $hash]);
    }

    // 🔐 Update Password + Username
    public function updatePasswordPengguna($id_user, $username, $new_password)
    {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        return $this->update($id_user, [
            'username' => $username,
            'password' => $hash
        ]);
    }

    // 📧 Cek Email Terdaftar
    public function cekEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    // 🧾 Update profil umum
    public function updateProfile($id_user, $data)
    {
        return $this->update($id_user, $data); // isi $data bisa nama, nomor_wa, dsb
    }

    // 🧾 Update Email
    public function updateEmail($id_user, $email)
    {
        return $this->update($id_user, ['email' => $email]);
    }

    // 🧾 Update Nomor WA
    public function updateNomorWA($id_user, $nomor_wa)
    {
        return $this->update($id_user, ['nomor_wa' => $nomor_wa]);
    }

    // ✅ Verifikasi Akun via OTP
    public function verifyAccount($otp, $id_user)
    {
        $otpModel = new \App\Models\OtpVerificationModel();

        $otpData = $otpModel
            ->where('otp_code', $otp)
            ->where('id_user', $id_user)
            ->where('is_used', 0)
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->first();

        if ($otpData) {
            $otpModel->markOtpUsedById($otpData['id']);

            return $this->update($id_user, ['is_verified' => 1]);
        }

        return false;
    }

    // ✅ Verifikasi Akun untuk Reset Password
    public function verifyResetPassword($otp, $id_user)
    {
        $otpModel = new \App\Models\OtpVerificationModel();

        $otpData = $otpModel
            ->where('otp_code', $otp)
            ->where('id_user', $id_user)
            ->where('is_used', 0)
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->first();

        if ($otpData) {
            $otpModel->markOtpUsedById($otpData['id']);
            return true;
        }

        return false;
    }

    
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getIdPenjual($id_user)
    {
        return $this->db->table('penjual')->select('id_penjual')->where('id_user', $id_user)->get()->getRow('id_penjual');
    }

    public function getIdPembeli($id_user)
    {
        return $this->db->table('pembeli')->select('id_pembeli')->where('id_user', $id_user)->get()->getRow('id_pembeli');
    }

    public function getIdAdmin($id_user)
    {
        return $this->db->table('admin')->select('id_admin')->where('id_user', $id_user)->get()->getRow('id_admin');
    }
    public function emailExists($email)
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }

    public function createUser($data)
    {
        $this->insert($data);
        return $this->insertID();
    }
}
