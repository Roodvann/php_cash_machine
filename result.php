<?php
header('Refresh: 6; URL=form.php');
?>
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
); // масив з результатом

$nominals = array();// допоміжний масив з номіналами
foreach ($a as $key => $value) {// перебір номіналів
  array_push($nominals,$key);
}
rsort($nominals); //сортуємо номінали за зменшенням

$n = filter_input(INPUT_POST, 'digit') ? filter_input(INPUT_POST, 'digit') : 0; // змінив "$digit = $_POST['digit']";

$money = $n; // результат

echo "Сумма: " . $n . "<br>\n";

if ($n >= 0){
  if ($n % 10 == 0){
    $i = 0; // ітератор номіналу
    $k = count($nominals);// кількість номіналів
    while($money > 0 && $i < $k){ // доки є кошти і не набрано необхідну суму
      $p = (int)($money/$nominals[$i]); // максимум купюр поточного номіналу
      if ( $p <= $a[$nominals[$i]]){ // меше максимуму
        $result[$nominals[$i]] = $p;
        $money -= $p*$nominals[$i]; // кошти, які можна видати
      }else{ // більше максимуму
        $result[$nominals[$i]] = $a[$nominals[$i]];
        $money -= $a[$nominals[$i]]*$nominals[$i]; //кошти, які можна видати
      }
      $i++;// перехід до меншого номіналу
    }
    if ($money == 0){
      foreach ($result as $key => $value) {
         print $value."x".$key." $unit <br>";
      }
    }else print "Требуемую сумму выдать невозможно: в банкомате недостаточно купюр";
  }else print "Требуемую сумму выдать невозможно: сумма не кратна числу 10";
}else print "Требуемую сумму выдать невозможно: сумма меньше 0";

?>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
