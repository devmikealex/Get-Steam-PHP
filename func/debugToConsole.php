<?php

// TODO Надо доделать для печати объектов
function debug_to_console($data, $title='')
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    if (is_object($output))
        $output = print_r($output, true);
    // echo "<script>console.log('PHPDebug> " . $output . "' );</script>";
    echo <<<SCRIPT
    <script>console.log('PHPDebug > $title : $output');</script>
    SCRIPT;
}