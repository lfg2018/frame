<?php
/**
 *  数据库操作类。
 * User: lfg
 * Date: 19-4-26
 * Time: 下午4:20
 */

namespace fashphp\db;
use PDO;
use PDOException;

class Db{
    private static $pdo = null;
    public static function pdo(){
        if(self::$pdo !== null) return self::$pdol;

        try{
            $dsn = sprintf('mysql:host=%s;dbname=%s,charset=utf8',DB_HOST,DB_NAME);
            $option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
            return self::$pdo = new PDO($dsn,DB_USER,DB_PASS,$option);
        }catch(PDOException $e){
            exit($e->getMessage());
        }
    }
}