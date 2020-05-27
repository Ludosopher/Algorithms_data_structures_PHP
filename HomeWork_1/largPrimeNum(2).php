<?php
//3* Простые делители числа 13195 - это 5, 7, 13 и 29.
// Каков самый большой делитель числа 600851475143, являющийся простым числом?
$start = microtime(true);
$divi = 600851475143;
divide($divi, 3);
echo "<br>";
echo microtime(true) - $start;

function divide($divided, $i)
{
    // Увеличиваем $i если не нашли делитель
    while ($i < $divided/3 AND $divided % $i != 0) {
        $i+=2;
    }
    // если наше число поделенное на делитель не простое, то вызваем рекурсию
    if (!primeCheck($divided / $i)) {
        divide($divided, $i+2);
    } else {
        // если простое то это и есть последний простой делитель
        echo $divided / $i;
    }
}

// проверка на просто число
function primeCheck($number)
{
    if ($number == 1)
        return 0;
    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i == 0)
            return 0;
    }
    return 1;

}