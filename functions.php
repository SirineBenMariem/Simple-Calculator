<?php
function calculate_expression($expression) {
    $expression = trim($expression);
    if (empty($expression)) return 0;

    if (!preg_match('~^[\+\-*/]?(\d+(\.\d+)?[\+\-*/%])*[\d]+$~', $expression)) {
        throw new Exception("Invalid expression format");
    }

    $tokens = preg_split('~([+\-*\/%])~', $expression, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    
    $values = [];
    $ops = [];
    $precedence = ['+' => 1, '-' => 1, '*' => 2, '/' => 2, '%' => 2];
    
    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            $values[] = floatval($token);
        } else if (isset($precedence[$token])) {
            while (!empty($ops) and $precedence[$token] <= $precedence[end($ops)]) {
                $val2 = array_pop($values);
                $val1 = array_pop($values);
                $op = array_pop($ops);

                switch ($op) {
                    case '+':
                        $values[] = add($val1, $val2);
                        break;
                    case '-':
                        $values[] = subtract($val1, $val2);
                        break;
                    case '*':
                        $values[] = multiply($val1, $val2);
                        break;
                    case '/':
                        $values[] = divide($val1, $val2);
                        break;
                    case '%':
                        $values[] = mod($val1, $val2);
                        break;
                }
            }
            $ops[] = $token;
        } else {
            throw new Exception("Invalid token: $token");
        }
    }
    
    while (!empty($ops)) {
        $val2 = array_pop($values);
        $val1 = array_pop($values);
        $op = array_pop($ops);

        switch ($op) {
            case '+':
                $values[] = add($val1, $val2);
                break;
            case '-':
                $values[] = subtract($val1, $val2);
                break;
            case '*':
                $values[] = multiply($val1, $val2);
                break;
            case '/':
                $values[] = divide($val1, $val2);
                break;
            case '%':
                $values[] = mod($val1, $val2);
                break;
        }
    }
    
    return array_pop($values);
}

function add($a, $b) { 
    return $a + $b;
}

function subtract($a, $b) { 
    return $a - $b;
}

function multiply($a, $b) { 
    return $a * $b;
}

function divide($a, $b) { 
    if ($b == 0) {
        throw new Exception("Cannot divide by zero.");
    }
    return $a / $b;
}

function mod($a, $b) {
    if ($b == 0) {
        throw new Exception("Cannot calculate modulo with divisor zero.");
    }

    return ($a % $b + $b) % $b;
}
?>
