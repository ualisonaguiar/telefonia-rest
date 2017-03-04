<?php
return [
    'solicitar-token' => [
        'POST' => [
            'controller' => '\Usuario\Controller\AutenticacaoController',
            'action' => 'login'
        ]
    ],
    'usuario-listagem' => [
        'GET' => [
            'controller' => '\Usuario\Controller\UsuarioController',
            'action' => 'index'
        ]
    ],
    'usuario-adicionar' => [
        'POST' => [
            'controller' => '\Usuario\Controller\UsuarioController',
            'action' => 'adicionar'
        ]
    ],
];