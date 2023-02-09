<?php

function debug_to_console($output, $title = '')
{
    // if (is_array($output))
    // $output = implode(',', $output);
    if (is_object($output) || is_array($output)) {
        $output = preg_replace('~[\r\n]+~', '\n', print_r($output, true));
    }
    echo <<<SCRIPT
    <script>console.log('PHPDebug > $title : $output');</script>
    SCRIPT;
}

// TestDTC();

function TestDTC()
{
    $a = 10;
    $b = 'Adasd a ad asd';
    $c = [1, 2, 3, 4];
    $d = ["red" => "красный", "blue" => "синий", "green" => "зеленый"];
    $e = (object) array('1' => 'foo', '2' => 'booo');
    debug_to_console($a, 'A');
    debug_to_console($b, 'B');
    debug_to_console($c, 'C');
    debug_to_console($d, 'D');
    debug_to_console($e, 'E');
    die('Test end');
}
