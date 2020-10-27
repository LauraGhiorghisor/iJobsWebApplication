<?php
namespace CSY2028;
interface Routes {
public function getRoutes($route) :array;
public function getAuthentication(): \CSY2028\Authentication;
}
