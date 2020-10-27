<?php
function autoload($name)
{
   $fileName = str_replace('\\', '/', $name) . '.php';
   $file = '../' . $fileName;

   require $file;
}
spl_autoload_register('autoload');
