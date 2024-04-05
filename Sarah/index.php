<?php
$expression = isset($_POST['input']) ? $_POST['input'] : '';

if (isset($_POST['num'])) {
    if ($_POST['num'] == 'c') {
        $expression = ""; // Clear the expression
    } elseif ($_POST['num'] == '.') {
        // Check if the decimal point already exists in the input
        if (strpos($expression, '.') === false) {
            $expression .= $_POST['num'];
        }
    } elseif ($_POST['num'] == '+/-') {
        // Toggle positive/negative sign
        if (!empty($expression) && is_numeric($expression)) {
            $expression = -$expression;
        }
    } else {
        $expression .= $_POST['num'];
    }
} elseif (isset($_POST['op'])) {
    // Append the clicked operator if it's different from the last one
    $lastChar = substr($expression, -1);
    if (!in_array($lastChar, ['+', '-', '*', '/', '%'])) {
        $expression .= $_POST['op'];
    } else {
        // If the last character is already an operator, it is replaced with the clicked operator
        $expression = substr($expression, 0, -1) . $_POST['op'];
    }
} elseif (isset($_POST['ce'])) {
    // Clear just the recent input
    $expression = substr($expression, 0, -1);
} elseif (isset($_POST['c'])) {
    // Clear the entire expression
    $expression = "";
}

// Check if there is a valid expression
$validExpression = preg_match('/\d[+\-*\/%]\d/', $expression);

// Evaluate the expression if the equals button is clicked and the expression is valid
if (isset($_POST['equal']) && $validExpression) {
    $result = eval("return $expression;");
    $expression = $result;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loki Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
    <h1 class="Loki">Mischievious Calculator</h1>
    </center>
    <div class="calc">
        <form action="" method="post">
            <br>
            <input type="text" class="maininput" name="input" value="<?php echo htmlspecialchars($expression); ?>" readonly> <br> <br>

            <input type="submit" class="calbtn" name="op" value="+">
            <input type="submit" class="calbtn" name="op" value="-">
            <input type="submit" class="calbtn" name="op" value="*">
            <input type="submit" class="calbtn" name="op" value="/"><br><br>
            
            <input type="submit" class="numbtn" name="num" value="7">
            <input type="submit" class="numbtn" name="num" value="8">
            <input type="submit" class="numbtn" name="num" value="9">
            <input type="submit" class="calbtn modulo" name="op" value="%"><br><br>
            
            <input type="submit" class="numbtn" name="num" value="4">
            <input type="submit" class="numbtn" name="num" value="5">
            <input type="submit" class="numbtn" name="num" value="6">
            <input type="submit" class="ce" name="ce" value="CE"><br><br>
            
            <input type="submit" class="numbtn" name="num" value="1">
            <input type="submit" class="numbtn" name="num" value="2">
            <input type="submit" class="numbtn" name="num" value="3">
            <input type="submit" class="c" name="c" value="C">
            
            <input type="submit" class="numbtn decimal" name="num" value=".">
            <input type="submit" class="numbtn" name="num" value="0">
            <input type="submit" class="equal" name="equal" value="=" <?php if (!$validExpression) echo 'disabled'; ?>>
            <input type="submit" class="calbtn toggle" name="num" value="+/-">
        </form>
    </div>
</body>
</html>
