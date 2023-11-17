<?php

    $array = array('Z', 'B', 'C', 'D', 'X', 'N', 'G', 'R', 'I', 'J', 'K', 'L', 'M', 'F', 'O', 'P', 'Q', 'H', 'S', 'T', 'U', 'V', 'W', 'E', 'Y', 'A');

    $str = "Hello World";
    echo stringtonumber($str,2);
    
    $str2 = "232242222222131 241131312222112";
    echo numbertostring($str2,2);
    
    function initializeGlobalVariable(){
        global $array;

        $origianlArray = $array;
        return $origianlArray;
    }
    function leftCircularPush($shiftAmount)
    {
        $new_array = initializeGlobalVariable();

        if (!is_numeric($shiftAmount)) {
            echo "Invalid shift amount. Please enter a numeric value.";
            return;
        }

        $shiftAmount = abs($shiftAmount);
        $shiftAmount = $shiftAmount % count($new_array);
        $slicedArray = array_slice($new_array, 0, $shiftAmount);
        $remainingArray = array_slice($new_array, $shiftAmount);
        $new_array = array_merge($remainingArray, $slicedArray);

        return $new_array;


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

    function stringtonumber($str,$number){

        $resultArrayString = initiateArray($number);
        $newMatrix = reverseTransformMatrix($resultArrayString);

        $result = null;

        $string = strtoupper($str);
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

        return implode($result);
   }

    function numbertostring($str2, $number){

        $resultArray = initiateArray($number);
        $Matrix = reverseTransformMatrix($resultArray);
        $numericalValues = $str2;

        function getLetterValue($numericalValue, $matrix) {
            $rowDigit = $numericalValue[0];
            $colDigit = $numericalValue[1];
            $letterDigit = $numericalValue[2];

            $rowIndex = $colDigit - 1;
            $colIndex = $rowDigit - 1;

            if (isset($matrix[$rowIndex][$colIndex][$letterDigit - 1])) {
                return $matrix[$rowIndex][$colIndex][$letterDigit - 1];
            }
            return null;
        }


        $result = array();
        $numericalChunk = "";
        for ($i = 0; $i < strlen($numericalValues); $i += 1) {
            if (!is_numeric($numericalValues[$i])) {
                $result[] = $numericalValues[$i];
                continue;
            }
            $numericalChunk .= $numericalValues[$i];
            if (strlen($numericalChunk) == 3) {
                $result[] = getLetterValue($numericalChunk, $Matrix);
                $numericalChunk = "";
            }
        }
        return implode($result);
    }

?>