<?php
require __DIR__ . '/../vendor/autoload.php';

use Tornado\Bootstrapping;
use Tornado\Http\Request;

(new Bootstrapping())
    ->init()
    ->run(new Request());
