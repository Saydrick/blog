<?php

namespace blog\Helper;

class Helper
{
    public static function dateFormat($date)
    {
        $annee = substr($date, 0, 4);
        $mois = substr($date, 5, 2);

        if (substr($date, 8, 1) == '0') {
            $jour = substr($date, 9);
        } else {
            $jour = substr($date, 8);
        }

        match ($mois) {
            '01' => $mois = 'Janvier',
            '02' => $mois = 'Février',
            '03' => $mois = 'Mars',
            '04' => $mois = 'Avril',
            '05' => $mois = 'Mai',
            '06' => $mois = 'Juin',
            '07' => $mois = 'Juillet',
            '08' => $mois = 'Août',
            '09' => $mois = 'Septembre',
            '10' => $mois = 'Octobre',
            '11' => $mois = 'Novembre',
            '12' => $mois = 'Décembre'
        };

        $date = $jour . " " . $mois . " " . $annee;

        return $date;
    }
}
