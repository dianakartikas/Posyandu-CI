<?php

namespace App\Validation;

use DateTime;

class AgeRules
{

    public static function ultah($date)
    {
        if (empty($date) || $date == '0000-00-00')
            return false;

        if (preg_match('/^([0-9]{4})-((?:0?[1-9])|(?:1[0-2]))-((?:0?[1-9])|(?:[1-2][0-9])|(?:3[01]))([0-9]{2}:[0-9]{2}:[0-9]{2})?$/', $date, $birth_date)) {
            if (date('Y') - $birth_date[1] > 5 || date('Y') - $birth_date[1] < 0)
                return false;
            if ((((date('Y') == $birth_date[1] && (date('m') - $birth_date[2] < 0 &&  date('d') - $birth_date[3] = 0)) ||

                (date('Y') == $birth_date[1] && (date('m') == $birth_date[2]  &&  date('d') - $birth_date[3] < 0)) ||
                (date('Y') - $birth_date[1] == 5 && (date('m') - $birth_date[2] > 0  &&  date('d') - $birth_date[3] = 0))) ||
                (date('Y') - $birth_date[1] == 5 && (date('m') == $birth_date[2]  &&  date('d') - $birth_date[3] > 0))))
                return false;


            return true;
        }
        return false;
    }

    public static function kegiatanwaktu($date)
    {

        $kegiatan = new DateTime($date);
        $today = new DateTime('-1 day');
        if ($kegiatan < $today) {
            return false;
        }
    }
}
