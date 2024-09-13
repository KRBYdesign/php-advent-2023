<?php
/**
 * Your calculation isn't quite right. It looks like some of the digits are actually spelled out with letters: one, two, three, four, five, six, seven, eight, and nine also count as valid "digits".
 *
 * Equipped with this new information, you now need to find the real first and last digit on each line. For example:
 *
 * two1nine
 * eightwothree
 * abcone2threexyz
 * xtwone3four
 * 4nineeightseven2
 * zoneight234
 * 7pqrstsixteen
 * In this example, the calibration values are 29, 83, 13, 24, 42, 14, and 76. Adding these together produces 281.
 *
 * What is the sum of all of the calibration values?
 */

// read the full text file
$file = fopen("../day1/puzzle_input.txt", "r") or die("Unable to open puzzle_input.txt!");

$foundNumbers = array();

// loop through the whole file
while (!feof($file)) {
    $line = fgets($file);

    $line = replaceTextWithNumbers($line);

    $numbersArr = preg_grep("/[0-9]+/", str_split($line));
    $foundNumbers[] = $numbersArr;
}

for ($i = 0; $i < count($foundNumbers); $i++) {
    $count = count($foundNumbers[$i]);
    $tempArray = array();

    foreach($foundNumbers[$i] as $key => $number) {
        $tempArray[] = $number;
    }

    // replace the source array with the temp array
    $foundNumbers[$i] = [$tempArray[0], $tempArray[count($tempArray) - 1]];
}

// creat the two-digit numbers
$sum = 0;
foreach ($foundNumbers as $numberArr) {
    $intVal = intval(implode('', $numberArr));

    $sum += $intVal;
}

// sum together for total
echo "\n\nSUM: $sum"; //52712
echo "\nTotal Lines: ".count($foundNumbers);

function replaceTextWithNumbers($line) {
    $textNumbers = [
        "one" => 1,
        "two" => 2,
        "three" => 3,
        "four" => 4,
        "five" => 5,
        "six" => 6,
        "seven" => 7,
        "eight" => 8,
        "nine" => 9,
    ];

    // there are occurrences of "eighthree" and "sevenine" which is throwing off translation
    $line = str_replace("twone", "twoone", $line);
    $line = str_replace("oneight", "oneeight", $line);
    $line = str_replace("threeight", "threeeight", $line);
    $line = str_replace("eighthree", "eightthree", $line);
    $line = str_replace("sevenine", "sevennine", $line);
    $line = str_replace("eightwo", "eighttwo", $line);
    $line = str_replace("fiveight", "fiveeight", $line);

    foreach($textNumbers as $key => $value) {
        $strPos = strpos($line, $key);

        if ($strPos !== false) {
            $line = str_replace($key, $value, $line);
        }

    }

    return $line;
}