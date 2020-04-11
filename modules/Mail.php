<?php

namespace Framework\Modules;

class Mail
{
    public static function send(string $to, string $subject, string $message, array $headers = [])
    {
        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";

        mail($to, $subject, $message, $headers);
    }
}