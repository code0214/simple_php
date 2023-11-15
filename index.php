<?php

// $matrix = array(
//     array('AB', 'CD', 'EF'),
//     array('GH', 'IJ', 'KL'),
//     array('MN', 'OP', 'QR'),
//     array('ST', 'UV', 'WX'),
//     array(null, 'YZ', null)
// );

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$number = $_POST["input_number"];
    
function leftCircularPush($shiftAmount)
{

    $array = range('A', 'Z');

    // Check if the shift amount is a valid numeric value
    if (!is_numeric($shiftAmount)) {
        echo "Invalid shift amount. Please enter a numeric value.";
        return;
    }

    // Ensure the shift amount is positive
    $shiftAmount = abs($shiftAmount);

    // Calculate the effective shift amount (to handle circular shifting)
    $shiftAmount = $shiftAmount % count($array);

    // Perform left circular push
    $slicedArray = array_slice($array, 0, $shiftAmount);
    $remainingArray = array_slice($array, $shiftAmount);
    $array = array_merge($remainingArray, $slicedArray);

    return $array;

}

function initiateArray($shiftAmount) 
{

    $matrix = array();

    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 3; $j++) {
            for ($k = 0; $k < 2; $k++) {
                $matrix[$i][$j][$k] = NULL;
            }
        }
    }

    $index = 0;
    $letters = leftCircularPush($shiftAmount);

    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 3; $j++) {
            for ($k = 0; $k < 2; $k++) {
                if (($i == 4 && $j == 0 && $k == 0) || ($i == 4 && $j == 0 && $k == 1) || ($i == 4 && $j == 2 && $k == 0) || ($i == 4 && $j == 2 && $k == 1)) {
                    $matrix[$i][$j][$k] = NULL;
                } else {
                    $matrix[$i][$j][$k] = $letters[$index];
                    $index++;
                }
            }
        }
    }

    return $matrix;

}

$resultArray = initiateArray($number);

function reverseTransformMatrix($matrix)
{
    $newMatrix = [];

    foreach ($matrix as $row) {
        $newRow = [];
        foreach ($row as $item) {
            if ($item[0] === null && $item[1] === null) {
                $newRow[] = null;
            } else {
                $newRow[] = $item[0] . $item[1];
            }
        }
        $newMatrix[] = $newRow;
    }

    return $newMatrix;
}


$newMatrix = reverseTransformMatrix($resultArray);

$result = null;

$string = $_POST['input_string'];
$string = strtoupper($string);
$sequence = str_split($string);

function getNumericalValue($letter, $matrix) {
    foreach ($matrix as $rowIndex => $row) {
        foreach ($row as $colIndex => $pair) {
            if ($pair !== null && (strpos($pair, $letter) !== false)) {
                $rowDigit = $colIndex + 1;
                $colDigit = $rowIndex + 1;
                $letterDigit = strpos($pair, $letter) + 1;
                return "{$rowDigit}{$colDigit}{$letterDigit}";
            }
        }
    }
    return null;
}

$result = array();
foreach ($sequence as $letter) {
    if (ctype_alpha($letter)) {
        $result[] = getNumericalValue($letter, $newMatrix);
    } else {
        $result[] = $letter;
    }
}
}
$resultValue = !empty($result) ? implode($result) : '';

?>
<div>
    <form method="POST" action="">
        <div>
            <label for="input_string">Input String:</label>
            <input style="width:400px; height: 30px; margin: 0 15px;" type="text" name="input_string" id="input_string" required>

            <label for="input_string">Input Number:</label>
            <input style="width:400px; height: 30px; margin: 0 15px;" type="Number" name="input_number" id="input_number" min="0" max="9" required>

            <button type="submit">Convert</button>    
        </div>      
        <br><br>
        <div>
            <label for="result">Result:</label>
            <input style="width:400px; height: 30px;" type="text" name="result" id="result" value="<?php echo $resultValue; ?>" readonly>    
        </div>
        
    </form>
</div>