<?php

namespace App\Models;

use CodeIgniter\Model;

class OtpVerificationModel extends Model
{
    protected $table            = 'otp_verifications';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_user', 'otp_code', 'expires_at', 'is_used'];

    // 🔄 Generate OTP (6 angka + 2 huruf kapital)
    public function generateOTP()
    {
        $digits = '';
        for ($i = 0; $i < 6; $i++) {
            $digits .= mt_rand(0, 9);
        }

        $letters = '';
        for ($i = 0; $i < 2; $i++) {
            $letters .= chr(mt_rand(65, 90));
        }

        return $digits . $letters;
    }

    public function sendOtp($id_user)
    {
        $user = model('UserModel')->find($id_user);
        if (!$user) return false;

        $this->invalidateOldOtp($id_user);
        $otp_code = $this->generateOTP();
        $this->saveOtp($id_user, $otp_code);

        $mailService = new \App\Libraries\MailService();
        return $mailService->sendOtpVerification($user['email'], $user['nama'], $otp_code);
    }

    // 💾 Simpan OTP Baru
    public function saveOtp($id_user, $otp_code)
    {
        return $this->insert([
            'id_user'    => $id_user,
            'otp_code'   => $otp_code,
            'expires_at' => date("Y-m-d H:i:s", strtotime("+5 minutes")),
            'is_used'    => 0
        ]);
    }

    // 🧹 Tandai semua OTP aktif sebelumnya sebagai used
    public function invalidateOldOtp($id_user)
    {
        return $this->where('id_user', $id_user)
                    ->where('is_used', 0)
                    ->where('expires_at >=', date('Y-m-d H:i:s'))
                    ->set('is_used', 1)
                    ->update();
    }

    // ✅ Verifikasi OTP (untuk register atau reset password)
    public function verifyOtp($otp, $id_user)
    {
        return $this->where('otp_code', $otp)
                    ->where('id_user', $id_user)
                    ->where('is_used', 0)
                    ->where('expires_at >=', date('Y-m-d H:i:s'))
                    ->first();
    }

    public function markOtpUsedById($id)
    {
        return $this->update($id, ['is_used' => 1]);
    }

    // 🔁 Resend OTP (dengan generate ulang dan simpan)
    public function resendOtp($id_user, $nama_user, $email_user, $isReset = false)
    {
        $this->invalidateOldOtp($id_user);
        $otp_code = $this->generateOTP();
        $this->saveOtp($id_user, $otp_code);

        $mailService = new \App\Libraries\MailService();
        if ($isReset) {
            return $mailService->sendOtpResetPassword($email_user, $nama_user, $otp_code);
        } else {
            return $mailService->sendOtpVerification($email_user, $nama_user, $otp_code);
        }
    }
}
