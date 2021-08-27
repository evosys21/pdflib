<?php

$dir = __DIR__;

$is = $dir . '/data/is';
$expected = $dir . '/data/expected/';

if (is_dir($is)) {
    exec("cp -R $dir/data/is/* $dir/data/");
    exec("rm -r $dir/data/is/");
}
if (is_dir($expected)) {
    exec("rm -r $expected");
}

echo 'APPROVED';