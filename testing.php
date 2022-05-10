<?php
    $ip = "10.32.6.1";
    echo utf8_encode(shell_exec("powershell -executionPolicy bypass -command ./script.ps1 \"$ip\""));
?>