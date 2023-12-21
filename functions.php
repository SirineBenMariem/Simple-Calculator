<?php
function calculate_expression($expression) {
    $tokens = preg_split('/([+\-*\/])/', $expression, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    
    $values = [];
    $ops = [];
    $precedence = ['+' => 1, '-' => 1, '*' => 2, '/' => 2];
    
    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            $values[] = floatval($token);
        } else if (isset($precedence[$token])) {
            while (!empty($ops) && $precedence[$token] <= $precedence[end($ops)]) {
                $val2 = array_pop($values);
                $val1 = array_pop($values);
                $op = array_pop($ops);

                switch ($op) {
                    case '+':
                        $values[] = somme($val1, $val2);
                        break;
                    case '-':
                        $values[] = sous($val1, $val2);
                        break;
                    case '*':
                        $values[] = mult($val1, $val2);
                        break;
                    case '/':
                        $values[] = div($val1, $val2);
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
                $values[] = somme($val1, $val2);
                break;
            case '-':
                $values[] = sous($val1, $val2);
                break;
            case '*':
                $values[] = mult($val1, $val2);
                break;
            case '/':
                $values[] = div($val1, $val2);
                break;
        }
    }
    
    return array_pop($values);
}



function somme($a , $b ) { 
    return $a + $b;
}

function sous($a , $b ) { 
    return $a - $b;
}

function mult($a , $b ) { 
    return $a * $b;
}

function div($a, $b) { 
    if ($b == 0) {
        throw new Exception("Cannot divide by zero.");
    }
    return $a / $b;
}

?>
