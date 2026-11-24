# Log viewer for LaveroAdmin

A log file viewer extension for LaveroAdmin.

Repository: [https://github.com/LaveroAdmin/log-viewer](https://github.com/LaveroAdmin/log-viewer)

## Installation

```bash
composer require laveroadmin/log-viewer

php artisan admin:import log-viewer
```

Open `/admin/logs` in your browser.

## Configuration

If your server blocks requests containing `.log` in the URL, you can enable the bypass function in `config/admin.php`:

```php
'extensions' => [
    'log-viewer' => [
        'bypass_protected_urls' => true,
        //'bypass_protected_urls_find' => ['.'],          // default ['.']
        //'bypass_protected_urls_replace' => ['[dot]'],   // default ['[dot]']
    ]
]
```

## License

Licensed under [The MIT License (MIT)](LICENSE).

## Thanks

- Special thanks to [open-admin](https://github.com/open-admin-org/open-admin) for open-admin development.
- Special thanks to [z-song](https://github.com/z-song) for original development.
