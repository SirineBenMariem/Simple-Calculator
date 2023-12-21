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

<?php

include 'functions.php';


$result = '';
$display = $_POST['display'] ?? '';
$pressed = $_POST['pressed'] ?? '';

if ($pressed == '=') {
    try {
        $result = calculate_expression($display);
    } catch (Exception $e) {
        $result = $e->getMessage(); 
    }

} elseif ($pressed == 'C') {
    $display = '';
} else {
    $display .= $pressed;
}

?>

<div class="calc">
    <form action="" method="post">
        <div class="input">
            <input type="text" id="inp" name="display" value="<?php echo htmlspecialchars($display); ?>">
        </div>
        <div class="row">
            <input type="submit" name="pressed" value="C" class="key">
            <input type="submit" name="pressed" value="&leftarrow;" class="key">
            <input type="submit" name="pressed" value="%" >
            <input type="submit" name="pressed" value="/">
        </div>
        <div class="row">
            <!-- Repeat blocks like this for other rows of buttons -->
            <input type="submit" name="pressed" value="7">
            <input type="submit" name="pressed" value="8">
            <input type="submit" name="pressed" value="9">
            <input type="submit" name="pressed" value="*">
        </div>
        <div class="row">
            <!-- Repeat blocks like this for other rows of buttons -->
            <input type="submit" name="pressed" value="4">
            <input type="submit" name="pressed" value="5">
            <input type="submit" name="pressed" value="6">
            <input type="submit" name="pressed" value="-">
        </div>
        <div class="row">
            <!-- Repeat blocks like this for other rows of buttons -->
            <input type="submit" name="pressed" value="1">
            <input type="submit" name="pressed" value="2">
            <input type="submit" name="pressed" value="3">
            <input type="submit" name="pressed" value="+">
        </div>
        <!-- ... Other rows for 4-5-6-* and 1-2-3-+ -->
        <div class="row">
            <input type="submit" name="pressed" value="0">
            <input type="submit" name="pressed" value="00">
            <input type="submit" name="pressed" value=".">
            <input type="submit" name="pressed" value="=" class="key eql">
        </div>
    </form>
</div>

</body>

</html>
