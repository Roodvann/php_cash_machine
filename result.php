
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Result</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link rel="stylesheet" href="css/css.css">

</head>
<body>
<div class="container">
<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


$unit = 'грн'; // валюта

// запас готівки (20300грн)
//20300
$a = Array(
        10 => 50,
        20 => 15,
        50 => 10,
        100 => 0,
        200 => 20,
        500 => 30
);
$result = Array(
        10 => 0,
        20 => 0,
        50 => 0,
        100 => 0,
        200 => 0,
        500 => 0
); //массив з результатом

$nominals = array();//вспомогательный массив с номиналами
foreach ($a as $key => $value) {//перебор номиналов
  array_push($nominals,$key);
}
rsort($nominals); //сортируем номиналы по убыванию

$n = filter_input(INPUT_POST, 'digit') ? filter_input(INPUT_POST, 'digit') : 0; // змінив "$digit = $_POST['digit']";

$money = $n; //то что будем выдавать

if ($n >= 0){
  if ($n % 10 == 0){
    $i = 0; //итератор номинала
    $k = count($nominals);//количество номиналов
    while($money > 0 && $i < $k){ //пока есть деньги и не не набрали нужную сумму
      $p = (int)($money/$nominals[$i]); //максимум купюр текущего номинала.
      if ( $p <= $a[$nominals[$i]]){ //меньше максимума
        $result[$nominals[$i]] = $p;
        $money -= $p*$nominals[$i]; //вычитаем те деньги которые можно выдать
      }else{ //больше максимума
        $result[$nominals[$i]] = $a[$nominals[$i]];
        $money -= $a[$nominals[$i]]*$nominals[$i]; //вычитаем те деньги которые можно выдать
      }
      $i++;//переходим к меньшему номиналу
    }
    if ($money == 0){
      foreach ($result as $key => $value) {
         print $value." X ".$key."UAN<br>";
      }
    }else print "Мало денег";
  }else print "Вы ввели число не кратное 10";
}else print "Вы ввели отрицательно число";

?>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
