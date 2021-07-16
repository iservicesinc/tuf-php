<?php
/*
 *  ___    ____                  _               
 * |_ _|  / ___|  ___ _ ____   _(_) ___ ___  ___ 
 *  | |   \___ \ / _ \ '__\ \ / / |/ __/ _ \/ __|
 *  | |    ___) |  __/ |   \ V /| | (_|  __/\__ \
 * |___|  |____/ \___|_|    \_/ |_|\___\___||___/
 *             ...when IT matters!				
 *                                                 
 * https://iservicesinc.com https://iservicesinc.net
 * Copyright 2021 I Services, Inc. All rights reserved.
*/
namespace Iservicesinc\TufPhp;

class Utils {

    public static function random_str(int $length = 32, bool $isc = false) {
        $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($isc === true) {$x .= '~!@#$%^&*_+-=\|<>?,./';}
        return substr(str_shuffle(str_repeat($x, ceil($length/strlen($x)))), 1, $length);
    }
}
?>