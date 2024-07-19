$env:RESULT_WRITE='true'
phpunit $args
$env:RESULT_WRITE='false'
