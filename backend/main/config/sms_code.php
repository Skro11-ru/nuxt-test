<?php

return [
    'debug' => env('SMS_CODE_DEBUG', false), # не отправлять смс, кидать в респонс
    'fake_code' => env('SMS_CODE_FAKE', null), # фейковый всегда одинаковый код
    'message' => 'Код подтверждения: %s Никому не сообщайте его.', # текст смс-сообщения
    'block_rules' => [
        'repeats' => 3, # количество попыток до блокировки
        'attempts' => 2, # количество блокировок для следующего уровня
        'repeats_cache_ttl' => 1, # срок жизни кеша повторов в минутах
        'attempts_cache_ttl' => 60 * 24, # срок жизни кеша блокировок в минутах
        'level_cache_ttl' => 60 * 24, # срок жизни кеша уровней блокировок в минутах
    ],
];
