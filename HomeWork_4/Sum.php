<?php

sumBigNumbers ('./chisla.txt');

function sumBigNumbers ($filePath)
{
    $file = fopen($filePath, "r") or die ("Не удалось открыть файл");
    $numArr = [];

    while (!feof($file)) {
        array_push($numArr, fgets($file));
    }

    $end_arr = [];
    $memory = 0;

    $arr_1 = array_reverse(str_split(substr_replace($numArr[0], '', -2)));
    $arr_2 = array_reverse(str_split($numArr[1]));

    if (count($arr_1) > count($arr_2)) $count = count($arr_1);
    else $count = count($arr_2);

    for ($i = 0; $i < $count; $i++) {
        $subtotal = $arr_1[$i] + $arr_2[$i];

        if ($subtotal + $memory < 10) {
            array_push($end_arr, $subtotal + $memory);
            $memory = 0;
        } else {
            $subtotal += $memory;
            if ($i == $count - 1) {
                array_push($end_arr, $subtotal);
            } else {
                array_push($end_arr, $subtotal - floor($subtotal / 10) * 10);
            }
            $memory = floor(($subtotal + $memory) / 10);
        }
    }

    $sum = implode('', array_reverse($end_arr));
    $file = fopen($filePath, "a") or die ("Не удалось открыть файл");
    fwrite($file, "\r\n" . $sum);
}