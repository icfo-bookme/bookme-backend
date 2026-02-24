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
    
'paths' => ['api/*', 'sanctum/csrf-cookie'],

'allowed_origins' => [
    'http://localhost:8000',
    'http://localhost:3000',
    'https://bdships.com',
    'https://www.bdships.com',
    'http://bdships.com',
    'https://bookme.com.bd',
    'https://www.bookme.com.bd',
    'http://bookme.com.bd',
    'http://bojraboat.com',
    'https://www.bojraboat.com',
    'https://bojraboat.com',
    'http://sundarbanships.com',
    'https://sundarbanships.com',
    'https://bojra.vercel.app',
    'https://traveltangua.com',
    'https://mv-the-crown-ve9l.vercel.app',
    'http://corporatesolutionsbd.com',
    'https://corporatesolutionsbd.com',
    'https://www.corporatesolutionsbd.com'
],


'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => true,





];
