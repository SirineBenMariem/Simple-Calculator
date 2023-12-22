<?php
session_start(); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'functions.php';

$result = '';
$display = $_POST['display'] ?? '';
$pressed = $_POST['pressed'] ?? '';

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = []; 
}

if ($pressed == '=') {
    try {
        $result = calculate_expression($display);
        $_SESSION['history'][] = $display . " = " . $result;
    } catch (Exception $e) {
        $result = $e->getMessage(); 
    }
} elseif ($pressed == 'C') {
    $display = '';
    $result = '';
} elseif ($pressed == '←') {
    $display = substr($display, 0, -1);
} else {
    $display .= $pressed;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="calc">
    <form action="" method="post">
        <div class="input">
            <input type="text" id="inp" name="display" value="<?php if ($result!=''){echo htmlspecialchars($result);}else{echo htmlspecialchars($display);} ?>" readonly>
        </div>
        <div class="row">
            <input type="submit" name="pressed" value="C" class="key">
            <input type="submit" name="pressed" value="&leftarrow;" class="key">
            <input type="submit" name="pressed" value="%" >
            <input type="submit" name="pressed" value="/">
        </div>
        <div class="row">
            <input type="submit" name="pressed" value="7">
            <input type="submit" name="pressed" value="8">
            <input type="submit" name="pressed" value="9">
            <input type="submit" name="pressed" value="*">
        </div>
        <div class="row">
            <input type="submit" name="pressed" value="4">
            <input type="submit" name="pressed" value="5">
            <input type="submit" name="pressed" value="6">
            <input type="submit" name="pressed" value="-">
        </div>
        <div class="row">
            <input type="submit" name="pressed" value="1">
            <input type="submit" name="pressed" value="2">
            <input type="submit" name="pressed" value="3">
            <input type="submit" name="pressed" value="+">
        </div>
        <div class="row">
            <input type="submit" name="pressed" value="0">
            <input type="submit" name="pressed" value="00">
            <input type="submit" name="pressed" value=".">
            <input type="submit" name="pressed" value="=" class="key eql">
        </div>
    </form>
</div>

<div class="history">
    <h2>History</h2>
    <ul>
        <?php foreach (array_reverse($_SESSION['history']) as $historyItem): ?>
            <li><?php echo htmlspecialchars($historyItem); ?></li>
        <?php endforeach; ?>
    </ul>
</div>

</body>
</html>
