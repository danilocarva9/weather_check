# Symfony Test Task


## Symfony/PHP Versions

```bash
PHP Version: v8.0.12 
Symfony Version: v5.3.12
```

## Installation
### Composer Install / Update
Run composer install on the project folder to install its dependencies
```bash
Composer Install
```

## Useful Commands

You can run the built-in php server using, on your project folder:
```
php -S localhost:8000 -t public/
```
Run Functional/Unit Tests:
```
php ./vendor/bin/phpunit ./tests/Unit/Service/OpenWeatherUnitTest.php

php ./vendor/bin/phpunit ./tests/Functional/Service/OpenWeatherFunctionalTest.php
```
