# Note To Browser backend

## Starting a new project

- Clone this repository
- Create a new database (utf8 charset)
- Create your `config/config.local.neon` based on `config.local.example.neon`
- Create directories `temp/cache`, `tests/temp` and `temp/sessions`
- Make directories `log/`,  `temp/` and `tests/temp` writable for web process
- Run migrations `php www/index.php migrations:reset`

## Tests

- run using `vendor/bin/phpunit --no-globals-backup --bootstrap tests/bootstrap.php tests/`
- use `--filter=XX` to run specific test only
