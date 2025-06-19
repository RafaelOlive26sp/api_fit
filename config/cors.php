<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie','broadcasting/auth'], // Define os caminhos que serão afetados pelas configurações de CORS.

    'allowed_methods' => ['GET', 'POST', 'PUT','PATCH', 'DELETE', 'OPTIONS'], // Especifica os métodos HTTP permitidos para requisições cross-origin.

    'allowed_origins' => [
        'https://dash-teacher-fit.vercel.app',
        'https://new-landing-seven.vercel.app',
        'http://localhost:3000',
        'http://localhost:3001',

    ], // Define quais origens (domínios) podem acessar os recursos. '*' permite todas as origens.

    'allowed_origins_patterns' => [], // Permite especificar padrões de origens usando expressões regulares. '*' permite todas as origens.

    'allowed_headers' => ['Accept', 'Authorization', 'Content-Type', 'X-Requested-With', 'X-CSRF-TOKEN', 'X-Application-Source'],
    // Lista os cabeçalhos HTTP permitidos nas requisições.

    'exposed_headers' => [], // Define os cabeçalhos que podem ser expostos ao navegador na resposta.

    'max_age' => 0, // Especifica o tempo em segundos que o navegador deve armazenar em cache a resposta do preflight request.

    'supports_credentials' => true, // Indica se as credenciais (cookies, cabeçalhos de autenticação) são suportadas em requisições cross-origin.

];


