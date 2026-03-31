<?php

function human_to_database($date)
{
    if(!$date) $date = date('d/m/Y');

    $dateObj = DateTime::createFromFormat("d/m/Y", $date);
    return $dateObj->format("Y-m-d");
}

function database_to_humam($date)
{
    if(!$date) $date = date('Y-m-d');

    $dateObj = DateTime::createFromFormat("Y-m-d", $date);
    return $dateObj->format("d/m/Y");
}

function datetime_to_view($date)
{
    if(!$date) $date = date('Y-m-d H:i:s');

    $dateObj = DateTime::createFromFormat("Y-m-d H:i:s", $date);
    return $dateObj->format("d/m/Y H:i:s");
}

function convert_to_timezone($date, $timezone = "America/Sao_Paulo")
{
    $fuso = new DateTimeZone($timezone);
    $data = new DateTime($date);
    $data->setTimezone($fuso);

    return $data;
}