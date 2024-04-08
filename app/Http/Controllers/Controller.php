<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sanitize($text){
        if (strlen($text) == 0) {
            $text = "";
        }else {
            $text = trim($text);
            $text = htmlspecialchars(stripslashes(trim($text, '-')));
            $text = strip_tags($text);
            // Conservar els octets escapats
            $text = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $text);
            // Elimina els signes de percentatge que no formen part d'un octet
            $text = str_replace('%', '', $text);
            // Restaura octets
            $text = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $text);
        }
        return $text;
    }
}
