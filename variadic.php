<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

$calc = new Calculator();
echo $calc->add(10, 20) . ' ' . $calc->add(10, 20, 30);