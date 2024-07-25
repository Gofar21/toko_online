<?php

namespace App\Helpers;

class Tanggal
{
    public static function indonesianDate($date)
    {
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $timestamp = strtotime($date);
        $day = date('l', $timestamp);
        $dateNum = date('d', $timestamp);
        $month = date('n', $timestamp);
        $year = date('Y', $timestamp);

        return $days[$day] . ', ' . $dateNum . ' ' . $months[$month] . ' ' . $year;
    }
}
