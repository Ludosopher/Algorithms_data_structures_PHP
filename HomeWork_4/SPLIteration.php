<?php
$a = 9;
$n = 4;
$arr = [$a];
$interResult = [];
$memory = 0;
$stepMult = 0;

for ($i=1; $i < $n; $i++) {

    $obj = new ArrayObject($arr);
    $iter = $obj->getIterator();

    while( $iter->valid() ) {

        $interResult = new SplStack();
        $stepMult = $iter->current() * $a;

       if ($stepMult + $memory < 10) {
           $interResult->push((string)($stepMult + $memory) . $interResult->current());
           $memory = 0;
       } else {
           $stepMult += $memory;
           if ($iter->key() === count($arr) - 1) {
               $interResult->push((string)$stepMult . $interResult->current());
           } else {
               $interResult->push((string)($stepMult - floor($stepMult / 10) * 10) . $interResult->current());
           }
           $memory = floor($stepMult / 10);
       }
       $iter->next();
    }
    $arr = $interResult;
    $interResult = [];
    $memory = 0;
}

//$file = fopen('./otvet.txt', "a") or die ("Не удалось открыть файл");
//fwrite($file, $arr);

