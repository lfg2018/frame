<?php
/**
 * 数据库基类
 * User: lfg
 * Date: 19-4-26
 * Time: 下午3:24
 */

namespace fastphp\db;
use fashphp\db\Db;
use \PDOStatement;


class Sql{
    protected $table;
    protected $primary = 'id';
    protected $filter = '';
    protected $param = array();

    public function where($where = array(),$param = array()){
        if($where){
            $this->filter .= ' WHERR ';
            $this->filter .= implode(' ',$where);
            $this->param = $param;
        }
        return $this;
    }

    public function order($order = array()){
        if($order){
            $this->filter .= ' ORDER ';
            $this->filter .= implode(',',$order);
        }
        return $this;
    }

    public function fetchAll(){
        $sql = sprintf(' select * from `%s` %s ', $this->table,$this->filter);
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth,$this->param);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function fetch(){
        $sql = sprintf('select * from `%s` %s',$this->table,$this->filter);
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth,$this->param);
        $sth->execute();
        return $sth->fetch();
    }

    public function add($data){
        $sql = sprintf("insert into `%s` %s",$this->table,$this->formatInsert($data));
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth,$data);
        $sth = $this->formatParam($sth,$this->param);
        $sth->execute();
        return $sth->rowCount();
    }

    public function update($data){
        $sql = sprintf("update `%s` set %s %s",$this->table, $this->formatUpdate($data),$this->filter);
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth,$data);
        $sth = $this->formatParam($sth,$this->param);
        $sth->execute();
        return $sth->rowCount();
    }

    public function delete($id){
        $sql = sprintf("delete from `%s` where `%s` %s",$this->table,$this->primary,$this->primary);
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth,[$this->primary => $id]);
        $sth->execute();
        return $sth->rowCount();
    }

    private function formatParam(PDOStatement $sth,$parms = array()){
        foreach($parms as $parm => $value){
            $parm = is_int($parm)?$parm+1 : ':'.ltrim($parm,':');
            $sth->bindParam($parm,$value);
        }
        return $sth;
    }

    private  function formatInsert($data){
        $fields = array();
        $names = array();
        foreach($data as $key=> $value){
            $fields[] = sprintf("`%s`",$key);
            $names[] = sprintf(":%s",$value);
        }
        $field = implode(',',$fields);
        $name = implode(',',$names);
        return sprintf("(%s) values (%s)",$field,$name);
    }

    private function formatUpdate($data){
        $files = array();
        foreach($data as $key => $value){
            $files[] = sprintf("`%s` = :%s",$key,$value);
        }
        return implode(',',$files);
    }
}