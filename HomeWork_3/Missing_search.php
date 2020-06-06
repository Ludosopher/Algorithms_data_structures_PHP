<?php

$myArray = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,18,19,20]; // 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20

echo "<pre>";
print_r($myArray);
echo "</pre><br>";

echo missingSearch($myArray);

function missingSearch($myArray) // Определение числа пропущенного в массиве из n элементов, начиная с 1. Каждый следующий элемент равен (предыдущий + 1).
{
    if (count($myArray) == 0) { // Отработка ситуации, когда массив пустой.
        return "В массиве недостаёт числа 1.";
    }
    if (count($myArray) == $myArray[count($myArray) - 1]) { // Отработка ситуации, когда в массиве нет пропущеных значений.
        return "В массиве нет пропущенных значений.";
    }
    $start = 0;
    $end = count($myArray) - 1;
    $base = 0;
    while ($start <= $end) { // Бинарное приближение к пропущенному числу.
        $base = floor(($start + $end) / 2); // Индекс проверяемого числа.
        $half_array = array_slice($myArray, 0, $base + 1); // Массив от начала до проверяемого числа.
        $array_sum = array_sum($half_array); // Сумма значений данного массива.
        $coeff = $array_sum / $myArray[$base]; // Отношение суммы значений данного массива к проверяемому числу.
        if (($coeff / 0.5 - 1) == $myArray[$base]) { // Если проверяемое число находится ДО пропущенного числа, то будет иметь место данное равенство.
            $start = $base + 1;
        }
        if (($coeff / 0.5 - 1) != $myArray[$base]) { // Если проверяемое число находится ПОСЛЕ пропущенного числа, то будет иметь место данное НЕравенство.
            $end = $base - 1;
        }
    }
    if (($coeff / 0.5 - 1) == $myArray[$base]) { // Определение пропущенного числа в случае завершения его поиска на участке ДО него.
        $missingNum = $myArray[$base] + 1;
        return "В массиве пропущено число $missingNum.";
    }
    if (($coeff / 0.5 - 1) != $myArray[$base]) { // Определение пропущенного числа в случае завершения его поиска на участке ПОСЛЕ него.
        $missingNum = $myArray[$base] - 1;
        return "В массиве пропущено число $missingNum.";
    }
}
