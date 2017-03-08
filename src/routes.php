<?php
$GLOBALS['container'] = $app->getContainer();

$app->post('/solicitar-token', 'Usuario\Controller\TokenController:index');
$app->post('/adicionar-pin', 'Usuario\Controller\PabxController:adicionar')
    ->add(new Usuario\Auth\MiddlewareAuth());
$app->post('/adicionar-pin-lote', 'Usuario\Controller\PabxController:adicionarLote')
    ->add(new Usuario\Auth\MiddlewareAuth());