<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org/
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace helpers;

use PHPMailer\PHPMailer\PHPMailer;

class Mail {

    public static function sendEmail($subject, $message, $from, $to) {
        if (empty($from) || empty($to)) {
            return;
        }

        $mail           = new PHPMailer();
        $mail->From     = $from;
        $mail->FromName = 'Issues Mirror';
        $mail->AddReplyTo($from);
        $mail->AddAddress($to);

        $mail->Subject  = $subject;
        $mail->Body     = $message;
        $mail->WordWrap = 90;

        $mail->Send();
    }
}