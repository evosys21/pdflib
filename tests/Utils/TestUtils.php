<?php

/** @noinspection PhpUnused */

namespace EvoSys21\PdfLib\Tests\Utils;

/**
 * Testing Utilities and Helpers
 */
class TestUtils
{
    protected static bool $notified = false;

    /**
     * Saves the $data in the specified file.
     *
     * @param string $file File to be saved to
     * @param string|array $data Data to be written
     * @param bool $force Force write to file
     */
    public static function toFile(string $file, $data, bool $force = false): void
    {
        if (! static::generateOn($force)) {
            return;
        }
        if (! static::$notified) {
            print_r(PHP_EOL . str_repeat('x', 80));
            print_r(PHP_EOL . '!!! TESTS_FILE_GENERATE - ON !!!');
            print_r(PHP_EOL . str_repeat('x', 80));
            print_r(PHP_EOL);
            static::$notified = true;
        }
        $md5 = is_readable($file) ? md5_file($file) : null;
        if (! is_string($data)) {
            $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } else {
            if (file_exists($data)) {
                $data = file_get_contents($data);
            }
        }
        static::mkdir($file);
        file_put_contents($file, $data);

        // check if the file changed
        if ($md5 !== md5_file($file)) {
            print_r(PHP_EOL . "Updated $file" . PHP_EOL);
        }
    }

    /**
     * Reads the $data from the specified file
     */
    public static function fromFile(string $file, bool $decode = false): mixed
    {
        $content = file_get_contents($file);
        if ($decode) {
            return json_decode($content, true);
        }

        return $content;
    }

    public static function tmpFile(string $prefix = 'pdf_test', string $suffix = ''): string
    {
        return tempnam(sys_get_temp_dir(), $prefix) . $suffix;
    }

    public static function generateOn(bool $force = false): bool
    {
        return $force || (getenv('RESULT_WRITE'));
    }

    public static function isDebug(): bool
    {
        return boolval(getenv('DEBUG'));
    }

    public static function copy($src, $dst): bool
    {
        static::mkdir($dst);

        return copy($src, $dst);
    }

    public static function mkdir(string $dir): bool
    {
        $dir = dirname($dir);
        if (! is_dir($dir)) {
            return mkdir($dir, 0777, true);
        }

        return true;
    }

    public static function relativePath(string $path): string
    {
        $path = realpath($path);

        return str_replace(TEST_PATH, '', $path);
    }

    public static function failPath(string $path): string
    {
        return str_replace('_files', '_failed', $path);
    }

    public static function coreName(string $path): string
    {
        $pathInfo = pathinfo($path);

        return $pathInfo['filename'];
    }

    public static function replaceExtension($path, $ext): string
    {
        $pathInfo = pathinfo($path);

        return $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $pathInfo['filename'] . '.' . $ext;
    }

    public static function execRequire($require): string
    {
        ob_start();
        require $require;
        $content = ob_get_clean();

        //CreationDate (D:20240101010000)
        $content = preg_replace("#CreationDate \(D:[0-9]+#", 'CreationDate (D:20240101010000', $content);
        $content = preg_replace("#LastModified \(D:[0-9]+#", 'LastModified (D:20240101010000', $content);

        return $content;
    }
}
