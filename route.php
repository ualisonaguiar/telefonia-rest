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
    ],
    'telefone' => [
        'POST' => [
            'controller' => '\Usuario\Controller\TelefoneController',
            'action' => 'adicionar'
        ]
    ],
    'telefone-lote' => [
        'POST' => [
            'controller' => '\Usuario\Controller\TelefoneController',
            'action' => 'adicionarEmLote'
        ]
    ]
];