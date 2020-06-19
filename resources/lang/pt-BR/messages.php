<?php

return [
    'hidden_data' => 'Dados omitidos do log',

    'routes' => [
        'error' => [
            '401' => 'Sem autorização.',
            '403' => 'Proibido.',
            '404' => 'Rota inexistente.',
            '405' => 'Esta rota não possui este método.',
            '419' => 'Página expirada.',
            '429' => 'Muitos requests.',
            '500' => 'Erro no servidor.',
            '503' => 'Servidor em manutenção.',
            'other_code' => 'Erro :code.'
        ],
        'esta_autenticado' => 'Você está autenticado.'
    ]
];
