<?php

/** @noinspection PhpUnused */

namespace evosys21\PdfLib\Tests\Utils;


use App\Utils\Json;
use App\Utils\Validator;
use Illuminate\Support\Arr;
use function App\Utils\Testing\env;

/**
 * Testing Utilities and Helpers
 * @package App\Utils\Testing
 */
class TestUtils
{
    protected static bool $notified = false;

    /**
     * Saves the $data in the specified file.
     *
     * @param string $file File to be saved to
     * @param mixed $data Data to be written
     * @param bool $force Force write to file
     * @return void
     */
    public static function toFile(string $file, mixed $data, bool $force = false): void
    {
        if (static::generateOn($force)) {
            if (!static::$notified) {
                print_r(PHP_EOL . str_repeat('x', 80));
                print_r(PHP_EOL . "!!! TESTS_FILE_GENERATE - ON !!!");
                print_r(PHP_EOL . str_repeat('x', 80));
                print_r(PHP_EOL);
                static::$notified = true;
            }
            $md5 = is_readable($file) ? md5_file($file) : null;
            if (!is_string($data)) {
                $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
            file_put_contents($file, $data);

            // check if the file changed
            if ($md5 !== md5_file($file)) {
                print_r(PHP_EOL . "Updated $file" . PHP_EOL);
            }
        }
    }

    /**
     * Reads the $data from the specified file
     *
     * @param string $file
     * @param bool $decode
     * @return mixed
     */
    public static function fromFile(string $file, bool $decode = false): mixed
    {
        $content = file_get_contents($file);
        if ($decode) {
            return json_decode($content, true);
        }
        return $content;
    }

    public static function generateOn(bool $force = false): bool
    {
        return $force || getenv('RESULT_WRITE');
    }

}
