<?php
header('Refresh: 6; URL = form.php');
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

error_reporting(0);

$unit = 'грн.'; // валюта

// запас готівки (29850грн)
$a = Array(
        10 => 5,
        20 => 15,
        50 => 10,
        100 => 100,
        200 => 20,
        500 => 30
);

$n = filter_input(INPUT_POST, 'digit') ? filter_input(INPUT_POST, 'digit') : 0; // змінив "$digit = $_POST['digit']";

$BankArr = array_fill(0, $n+1, PHP_INT_MAX); // заповнення масиву $BankArr
$BankArr[0]=0;

 for($m=1; $m<=$n; ++$m) // m - сума, яку необхідно видати
 {
    foreach ($a AS $banknote_nominal => $banknote_stock){ // перебір всих номіналів банкнот
        if($m>= $banknote_nominal && $BankArr[$m-$banknote_nominal]+1<$BankArr[$m]) {
            $BankArr[$m] = $BankArr[$m-$banknote_nominal]+1; // змінюємо значення $BankArr[m], якщо знайшли
        }
    }
 }

$sum = 0; // змінна для запису суми коштів
foreach ($a as $key => $value) {
    $sum += $key * $value; // визначення суми коштів кожного номіналу
    $sumArr[] = array("value" => $key, "number" => $value);
}

$out_put = array_fill_keys (array_keys ($a)  , 0 ); // заповнюємо масив видачі ключами банкнот

echo "Сумма: " . $n . "<br>\n";

if ($BankArr[$n] == PHP_INT_MAX){
    echo "Требуемую сумму выдать невозможно: сумма не кратна числу 100<br>\n";
}elseif ($BankArr[$n] <= 0){
    echo "Требуемую сумму выдать невозможно: сумма меньше или равна 0<br>\n";
}elseif ($n > $sum){
    echo "Требуемую сумму выдать невозможно: в банкомате недостаточно купюр<br>\n";
}else{
    $iteration = 0;
    while($n>0){
        foreach ($a AS $banknote_nominal => $banknote_stock){ // перебір всих номіналів банкнот
            if(($n >= $banknote_nominal) AND ($BankArr[$n-$banknote_nominal]==$BankArr[$n]-1))
            {
                $out_put[$banknote_nominal] ++;
                $n -= $banknote_nominal;
                $iteration++;
                break;
            }
        }
    }
}

$out_text = '';
foreach ($out_put AS $banknote_nominal => $qty){
    if($qty){
        $out_text .= "{$banknote_nominal}{$unit}x{$qty}";
    }
}
echo $out_text;

?>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
