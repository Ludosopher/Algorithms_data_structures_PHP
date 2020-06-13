<?php
$a = '3';
$n = 3;
$multiplier = $a;
$interResult = '';
$memory = 0;
$stepMult = 0;

for ($i=1; $i < $n; $i++) {

    for ($j=strlen($multiplier) - 1; $j>=0; $j--) {
       $stepMult = $multiplier[$j] * $a;

       if ($stepMult + $memory < 10) {
           $interResult = (string)($stepMult + $memory) . $interResult;
           $memory = 0;
       } else {
           $stepMult += $memory;
           if ($j == 0) {
               $interResult = (string)$stepMult . $interResult;
           } else {
               $interResult = (string)($stepMult - floor($stepMult / 10) * 10) . $interResult;
           }
           $memory = floor($stepMult / 10);
       }
    }

    $multiplier = $interResult;
    $interResult = '';
    $memory = 0;
}

$file = fopen('./otvet.txt', "a") or die ("Не удалось открыть файл");
fwrite($file, $multiplier);


