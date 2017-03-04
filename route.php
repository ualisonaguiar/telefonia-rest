<?php
define('GET', 'GET');
define('POST', 'POST');
define('PUT', 'PUT');
define('DELETE', 'DELETE');

return [
    'solicitar-token' => [
        POST => [
            'controller' => '\Usuario\Controller\AutenticacaoController',
            'action' => 'login'
        ]
    ],
    'usuario' => [
        GET => [
            'controller' => '\Usuario\Controller\UsuarioController',
            'action' => 'index'
        ]
    ]
];