<?php
// DIC configuration

#@TODO verificar como implementar
$container = $app->getContainer();

$container['jwt'] = function() {
  return new \Usuario\Service\JWTManager('teste123443');
};