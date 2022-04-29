rm -r ./vendor/php*
rm -r ./vendor/nikic/
rm -r ./vendor/symfony/
composer dump-autoload
wget --no-check-certificate -O phpunit.phar https://phar.phpunit.de/phpunit-6.phar
php phpunit.phar --bootstrap ./tests/bootstrap.php ./tests/Functional
