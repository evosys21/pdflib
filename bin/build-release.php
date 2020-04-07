#!/usr/bin/env php

<?php

$find = 'find';
$mkdir = 'mkdir';
$rm = 'rm';
$nameTable = "fpdf-table";
$nameMulticell = "fpdf-multicell";
$cwd = dirname(__FILE__) . '/..';
$eofind = "\\;";

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $find = 'C:\bin\bin\find';
    $mkdir = 'C:\bin\bin\mkdir';
    $rm = 'C:\bin\bin\rm';
    $eofind = ";";
}


/**
 * Executes the given command
 *
 * @param string $cmd
 * @return bool
 */
function execute($cmd)
{

    $result = array();

    stdout("Exec: $cmd");

    //execute the command
    exec($cmd, $result, $ress);

    if ($ress != 0) { //there was an error in the execution
        $error_str = implode(',', $result);
        trigger_error("Error executing command: $cmd Error: $error_str"); //write the real error
        die();
        return false;
    } //fi

    return true;
} //execute


function stdout($s)
{
    echo $s . "\n";
}

$versionTable = str_replace(["\r", "\n"], "", file_get_contents("version_table"));
$versionMulticell = str_replace(["\r", "\n"], "", file_get_contents("version_multicell"));

$tmpDir = "../" . uniqid("tmp-");
// $tmpDir = "../tmp-11";
$releaseDir = "$tmpDir/release";

execute("$mkdir -p {$tmpDir}");
execute("$rm -rf {$tmpDir}/*");

execute("$mkdir -p {$releaseDir}");
execute("$rm -rf {$releaseDir}/*");

$tmpDir = realpath($tmpDir);
$releaseDir = realpath($releaseDir);

execute("$find ./ -maxdepth 1 -type f -name '*.md' -exec cp -v {} $releaseDir $eofind");
execute("$find ./ -maxdepth 1 -type f -name '*.txt' -exec cp -v {} $releaseDir $eofind");
execute("cp autoload.php $releaseDir");
execute("cp composer-deploy.json $releaseDir/composer.json");
execute("cp -r ./examples $releaseDir");
execute("cp -r ./content $releaseDir");
execute("cp -r ./library $releaseDir");

chdir($releaseDir);
//remove all "dev" content
execute("$find ./ -type f -name '*dev*' -delete");
execute("composer install");

chdir($tmpDir);

$dirTable = "{$nameTable}-{$versionTable}";
$dirMulticell = "{$nameMulticell}-{$versionMulticell}";
execute("$mkdir -p {$dirTable}");
execute("$mkdir -p {$dirMulticell}");

execute("cp -r $releaseDir/* $dirTable");
execute("cp -r $releaseDir/* $dirMulticell");

$archive = "{$nameTable}-{$versionTable}.zip";
$tableRelease = $archive;
$tableReleaseMessage = "Automatic release #$versionTable";

stdout("Archive: $archive");
execute("rm -rf $archive");
execute("cd $tmpDir && zip -rq $archive $dirTable");

$archive = "{$nameMulticell}-{$versionMulticell}.zip";

//clean the table part
execute("$find $dirMulticell | grep -i table | xargs rm -rf");
execute("rm -rf {$dirMulticell}/examples/table");

stdout("Archive: $archive");

execute("rm -rf $archive");
execute("cd $tmpDir && zip -rq $archive $dirMulticell");

chdir($cwd);
execute("$mkdir -p ./release");
execute("rm -rf ./release/*");
execute("cp -v $tmpDir/*.zip ./release");
execute("rm -rf $tmpDir");

$multicellRelease = $archive;
$multicellReleaseMessage = "Automatic release #$versionMulticell";
