rm -r ./vendor/php*
rm -r ./vendor/nikic/
rm -r ./vendor/symfony/
composer dump-autoload
wget -O phpunit.phar https://phar.phpunit.de/phpunit-5.phar
php phpunit.phar --version
php phpunit.phar --bootstrap ./tests/bootstrap.php ./tests/functional