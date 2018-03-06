<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 2/14/2018
 * Time: 9:17 AM
 */

class LogWriter
{
    private static $outputError = true;
    private static $connectPath = "admin/dbConnect.php";  //need to make this more dynamic
    private static $conn;

    public static $LOG_LEVEL_DEBUG = 1;
    public static $LOG_LEVEL_INFO = 2;
    public static $LOG_LEVEL_ERROR = 3;
    public static $LOG_LEVEL_FATAL = 9;

    public function __construct($conn = null) {
        self::$conn = $conn;
        if($conn == null) {
            throw new Exception("The database connection object was null.");
        }
    }

    public static function Write($logMessage, $sourcePage, $logLevel = 3, $attemptedSQL = '') {
        if(null === self::$conn) {
            try {
                $conn = null;
                require(self::$connectPath);
                self::$conn = $conn;
            } catch (Exception $ex) {
                print $ex;
                exit();
            }

        } else {
            $conn = self::$conn;
        }

        $gotSQL = $attemptedSQL == '' ? 'NULL' : $conn->quote($attemptedSQL);

        $sql = "INSERT INTO Log(LogLevel, SourcePage, `SQL`, Message, Generated) VALUES(" . $logLevel . "," . $conn->quote($sourcePage) . "," . $gotSQL . "," . $conn->quote($logMessage) . ",'" . date('Y-m-d H:i:s') . "')";

        self::$conn->query($sql);
        if(self::$conn->errorCode() != "00000") {
            $arryErr = self::$conn->errorInfo();
            print $sql . "<p>";
            throw new Exception($arryErr[2]);
        }

        if(self::$outputError && ($logLevel == self::$LOG_LEVEL_ERROR || $logLevel == self::$LOG_LEVEL_FATAL)) {
            print $logMessage;
        }
    }

    public function OutputError($output) {
        self::$outputError = $output;
    }
}