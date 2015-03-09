<?php
/**
 * This class provides static function to
 * log the errors occuring in other scripts.
 *
 * @author pratyush
 */
class Logger
{
    public static function write_log($source, $message)
    {
        $log_file = fopen("log.txt", "a") or die("Unable to open log file.");
        fwrite($log_file, date("d/m/Y")." ");
        fwrite($log_file, $source.": ");
        fwrite($log_file, $message."\n");
        fclose($log_file);
    }
}
