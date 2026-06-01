<?php
session_start();
function myAutoload($c) {require_once
__DIR__. '/classes/' .$c. '.php';}
spl_autoload_register('myAutoload');