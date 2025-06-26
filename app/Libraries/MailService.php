<?php

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // Konfigurasi SMTP Gmail
        $this->mailer->isSMTP();
        $this->mailer->Host       = 'smtp.gmail.com';
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = 'campuseats.company@gmail.com';
        $this->mailer->Password   = 'aederepvtrzykzdp'; // gunakan App Password Gmail
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->Port       = 587;

        $this->mailer->setFrom('campuseats.company@gmail.com', 'Campuseats');
        $this->mailer->isHTML(true);
    }

    public function sendOtpVerification($toEmail, $toName, $otp)
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($toEmail, $toName);
            $this->mailer->Subject = '[Do not share this code] OTP Code Registration Campuseats';
            $this->mailer->Body = $this->getVerificationBody($toName, $otp);

            return $this->mailer->send();
        } catch (Exception $e) {
            log_message('error', 'Email gagal: ' . $this->mailer->ErrorInfo);
            return false;
        }
    }

    public function sendOtpResetPassword($toEmail, $toName, $otp)
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($toEmail, $toName);
            $this->mailer->Subject = '[Reset Password] OTP Code Campuseats';
            $this->mailer->Body = $this->getResetPasswordBody($toName, $otp);

            return $this->mailer->send();
        } catch (Exception $e) {
            log_message('error', 'Email gagal: ' . $this->mailer->ErrorInfo);
            return false;
        }
    }

    // 🔧 Template Email: OTP Verifikasi Akun
    private function getVerificationBody($name, $otp)
    {
        return '
            <div style="font-family: Arial, sans-serif; font-size: 16px;">
                <p>Hi ' . htmlspecialchars($name) . ',</p>
                <p>Thank you for registering at <strong>Campuseats</strong>! Use this OTP code:</p>
                <div style="text-align: center; margin: 20px 0;">
                    <span style="padding: 15px 25px; font-size: 24px; font-weight: bold; letter-spacing: 4px; border: 1px solid #ccc; border-radius: 8px;">
                        ' . $otp . '
                    </span>
                </div>
                <p>Code valid for <strong>5 minutes</strong>. Don’t share it with anyone.</p>
                <p>Regards,<br><strong>Campuseats Team</strong></p>
            </div>';
    }

    // 🔧 Template Email: Reset Password
    private function getResetPasswordBody($name, $otp)
    {
        return '
            <div style="font-family: Arial, sans-serif; font-size: 16px;">
                <p>Hi ' . htmlspecialchars($name) . ',</p>
                <p>We received a request to reset your password. Use this OTP code:</p>
                <div style="text-align: center; margin: 20px 0;">
                    <span style="padding: 15px 25px; font-size: 24px; font-weight: bold; letter-spacing: 4px; border: 1px solid #ccc; border-radius: 8px;">
                        ' . $otp . '
                    </span>
                </div>
                <p>Code valid for <strong>5 minutes</strong>. Ignore this email if you didn’t request it.</p>
                <p>Best regards,<br><strong>Campuseats Team</strong></p>
            </div>';
    }
}
