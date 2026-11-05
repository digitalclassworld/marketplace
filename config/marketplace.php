<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Show Dummy / Curated Fallback Data
    |--------------------------------------------------------------------------
    |
    | When set to false (default on production servers), the application will
    | strictly display ONLY real records fetched from the database.
    | On local development and testing, curated UI fallback data is shown.
    |
    */
    'show_dummy_data' => env('SHOW_DUMMY_DATA', env('APP_ENV') === 'local' || env('APP_ENV') === 'testing'),
];

