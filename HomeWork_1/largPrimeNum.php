<?php

$start = microtime(true);

$base = 60085147513; // 13195 600851475143
$stack = new SplDoublyLinkedList();
//echo $stack->current();

$i=3;
while (true) { // цикл поиска чисел, которые делятся на заданное число без остатка, начиная с максимального
    if ($base%$i == 0) {
    $j = 3;
         while (true) // цикл проверки, является ли число простым
         {
            if (($base/$i)%$j == 0) {
                $is_prime_div = false;
                break;
            }
            if($j >= sqrt($base/$i)) {
                $is_prime_div = true;
                break;
            }
            $j+=2;
         }
    }
    if ($is_prime_div) {
        echo "Число " . $base/$i . " является самым большим делителем {$base}, являющимся простым числом!";
        echo "<br>";
        break;
    }
    $i+=2;
}
if (!$is_prime_div) {
    echo "У числа {$base} нет делителей, являющихся простыми числами";
}

echo microtime(true) - $start;




