<?php
$GLOBALS['container'] = $app->getContainer();

$app->post('/solicitar-token', 'Telefonia\Controller\TokenController:index');
$app->post('/adicionar-pin', 'Telefonia\Controller\PabxController:salvar')->add(new Telefonia\Auth\MiddlewareAuth());
$app->post('/adicionar-pin-lote', 'Telefonia\Controller\PabxController:salvarLote')->add(new Telefonia\Auth\MiddlewareAuth());
$app->get('/', function ($request, $response, $args) {
	return $response->withStatus(200)
		->write(json_encode([
			'status' => true,
			'message' => 'Acesso nao autorizado!'
		]))
	->withAddedHeader('Content-Type', 'application/json');
});
