<?php
return [
    'solicitar-token' => [
        'POST' => [
            'controller' => '\Usuario\Controller\AutenticacaoController',
            'action' => 'login'
        ]
    ],
    'usuario' => [
        'GET' => [
            'controller' => '\Usuario\Controller\UsuarioController',
            'action' => 'index'
        ],
        'POST' => [
            'controller' => '\Usuario\Controller\UsuarioController',
            'action' => 'adicionar'
        ],
        'PUT' => [
            'controller' => '\Usuario\Controller\UsuarioController',
            'action' => 'alterar'
        ],
        'DELETE' => [
            'controller' => '\Usuario\Controller\UsuarioController',
            'action' => 'excluir'
        ]
    ]
];