<?php
use CodeIgniter\I18n\Time;
function is_valid_date($date)
{
    $format = 'Y-m-d'; // Format de date attendu

    // Vérifier si la date correspond au format spécifié
    $dateTimeObj = \DateTime::createFromFormat($format, $date);
    if ($dateTimeObj && $dateTimeObj->format($format) === $date) {
        // La date correspond au format attendu, c'est valide
        return true;
    } else {
        // La date ne correspond pas au format attendu
        return false;
    }
}
function date_not_in_future(string $date): bool
    {
        $format='Y-m-d';
        $today = new DateTime();
        $inputDate = DateTime::createFromFormat($format, $date);

        // Si la date est postérieure à aujourd'hui, renvoie false
        return $inputDate <= $today;
    }
function is_before(string $time1, string $time2): bool
{
    $time1 = Time::parse($time1);
    $time2 = Time::parse($time2);

    if ($time1->isBefore($time2)) {
        return true;
    } else {
        return false;
    }
}
?>