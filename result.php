<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Result</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link rel="stylesheet" href="css/css.css">

</head>
<body>
<div class="container">
<?php

error_reporting(0);

$a = Array(10, 20, 50, 100, 200, 500, 1000, 5000);
$c = count($a);
$digit = $_POST['digit'];


$MAX_VAL = PHP_INT_MAX;
//$MAXDIGIT = 1000000;
$BankArr = array_fill(1, $digit+1, 0);
$BankArr[0] = 0;
for($x = 1; $x <= $digit; ++$x) {
    $BankArr[$x] = $MAX_VAL;
    for($i = 0; $i < $c; ++$i){
        if($x >= $a[$i] && $BankArr[$x-$a[$i]] + 1<$BankArr[$x]) {
            $BankArr[$x] = $BankArr[$x-$a[$i]]+1;
        }
    }
}

echo "Сумма: " . $digit . "<br>";


if($BankArr[$digit] == $MAX_VAL) {
    echo "Выдача невозможна: сумма не кратна числу 100\r\n";
}
elseif ($BankArr[$digit] <= 0) {
    echo "Выдача невозможна: сумма меньше или равна 0\r\n";
}
//elseif ($BankArr[$digit] >= 150000) {
//    echo "Выдача невозможна: в банкомате недостаточно купюр\r\n";
//}
else {
    $res = Array();
    echo "Выдача возможна, число купюр:" . "<br>";

    while($digit > 0) {
        for($i = 0;$i < $c; ++$i) {
            if ($BankArr[$digit-$a[$i]] == $BankArr[$digit]-1) {
                array_push($res, $a[$i]);
                $digit-=$a[$i];
                break;
            }
        }
    }
    $arr = array_count_values($res);
        foreach ($arr as $key => $value) {
            echo "{$value}x{$key}\r\n";

    }
}

?>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


</body>
</html>
