$env:RESULT_WRITE='1'
phpunit $args
$env:RESULT_WRITE='0'
