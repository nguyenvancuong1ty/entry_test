<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Pagination Settings
    |--------------------------------------------------------------------------
    |
    | default_per_page: Number of items displayed per page by default.
    | options: Available options for the per-page selector dropdown.
    | on_each_side: Number of page links to show on each side of the current page.
    |
    */
    'default_per_page' => (int) env('PAGINATION_DEFAULT_PER_PAGE', 10),
    'options' => [10, 20, 30, 50, 100],
    'on_each_side' => 2,
];
