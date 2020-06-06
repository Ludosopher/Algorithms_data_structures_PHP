<?php

$array = [1,2,3,4,4,4,4,4,4,4,4,4,4,5,6,7,8,6,10];
$num = 4;

echo "<pre>";
print_r($array);
echo "</pre><br>";

echo repeatableSearch($array, $num);

function leftSearch($leftArray, $num) // Расчёт количества единиц искомого числа в массиве, где все такие числа находятся с правой стороны.
{
    $start = 0;
    $end = count($leftArray) - 1;
        while ($start < $end) {
        $base = floor(($start + $end) / 2);
        if ($leftArray[$base] == $num) {
            $end = $base - 1;
        }
        elseif ($leftArray[$base] != $num) {
            $start = $base + 1;
        }
    }
    if ($leftArray[$end] == $num) return count($leftArray) - $end;
    if ($leftArray[$end] != $num) return count($leftArray) - ($end + 1);

}

function rightSearch($rightArray, $num) // Расчёт количества единиц искомого числа в массиве, где все такие числа находятся с левой стороны.
{
    $start = 0;
    $end = count($rightArray) - 1;
    $base = 0;
    while ($start < $end) {
        $base = floor(($start + $end) / 2);
        if ($rightArray[$base] == $num) {
            $start = $base + 1;
        }
        elseif ($rightArray[$base] != $num) {
            $end = $base - 1;
        }

    }
    if ($rightArray[$end] == $num) return $end + 1;
    if ($rightArray[$end] != $num) return $end;
}

function repeatableSearch($array, $num) // Расчёт количества единиц искомого числа в массиве, где каждый следующий элемент равен (предыдущий + 1) или просто предыдущему.
{
    $start = 0;
    $end = count($array) - 1;
    $leftArray = [];
    $rightArray = [];
    $countNum = 0;
    while ($start < $end) {
        $base = floor(($start + $end) / 2);
        if ($array[$base] == $num) {
            // В случае обнаружения искомого числа при бинарном поиске делим массив на левый и правый. В левом массиве искомые числа, таким образом, будут находиться справа, а в правом - слева.
            $leftArray = array_slice($array, 0, $base + 1);
            $rightArray = array_slice($array, $base + 1);
            $countNum = leftSearch($leftArray, $num) + rightSearch($rightArray, $num); // Подсчёт количества единиц искомого числа отдельно в левом и правом массивах и их суммирование.
            return "В данном массиве присутствует $countNum единиц(а,ы) числа $num.";
        }
        elseif ($array[$base] < $num) {
            $start = $base + 1;
        }
        else {
            $end = $base - 1;
        }
    }
}
