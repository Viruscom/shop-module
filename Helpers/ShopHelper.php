<?php

    namespace Modules\Shop\Helpers;

    class ShopHelper
    {
        public static function setCookieSbuuid()
        {
            if (!isset($_COOKIE['sbuuid'])) {
                $sbuuid = uniqid(uniqid(uniqid(uniqid('', true) . "-", true) . "-", true) . "-", true);
            } else {
                $sbuuid = $_COOKIE['sbuuid'];
            }

            setcookie("sbuuid", $sbuuid, time() + (86400 * 365), "/");

            return $sbuuid;
        }
    }
