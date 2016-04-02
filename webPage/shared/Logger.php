<?php

/**
 * This class is used for management the errors
 */
class Logger {
    private $_LINE_LOG_STRUCTURE = array("date","error_code","error_message");
    public static function log($error_code,$error_message) {
        file_put_contents("log.csv", date(DATE_RFC822).":Error ".$error_code.":".$error_message.PHP_EOL,
                FILE_APPEND|LOCK_EX);
    }
    public static function get_log() {
        $logs = array();
        $fp = fopen("log.csv");
        while(!feof($fp)) {
            $logs[] = array_combine($this->_LINE_LOG_STRUCTURE,fgetcsv($fp, 0, ":"));
        }
        return $logs;
    }
}
