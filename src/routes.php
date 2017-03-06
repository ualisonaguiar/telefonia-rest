<?php
$app->post('/solicitar-token', 'Usuario\Controller\TokenController:index');
$app->post('/adicionar-pabx', 'Usuario\Controller\PabxController:adicionar');
    $app->post('/adicionar-pabx-lote', 'Usuario\Controller\PabxController:adicionarLote');