<?php

namespace App;

class Model
{
    protected $db;

    protected $table = '';

    protected $columns;

    public $errors;

    protected $unique;

    public function __construct()
    {
        $database = 'auth';
        $dsn = 'mysql:host=localhost;dbname=crud';
        $user = 'root';
        $pass = '';

        try{
            $this->db = new \PDO($dsn,$user,$pass);
        }catch (\PDOException $e){
            echo 'Failed To Connect ' . $e->getMessage();
        }
    }

    public  function create($data)
    {
        $sql = 'INSERT INTO '. $this->table . '   '  . $this->columns($data) . ' VALUES ' . $this->values($data);
        if(empty($this->errors)){
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return 'Created Successfully';
            }else {
                return 'Failed';
            }
        }
    }

    public function update($id,$data)
    {
        $sql = 'UPDATE ' . $this->table . ' SET ' . $this->getSelectedData($id,$data) . ' WHERE id= ?';
        if(empty($this->errors)){
            $stmt = $this->db->prepare($sql);
            $stmt->execute($this->getSelectedValues($id,$data));
            if($stmt->rowCount() > 0){
                return 'Updated Successfully';
            }else {
                return 'Failed';
            }
        }

    }

    public function delete($id)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));

    }
    public function get($id)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));
        $row = $stmt->fetch();

        return $row;
    }

    public function all()
    {
         $sql = 'SELECT * FROM ' . $this->table ;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();

        return $row;
    }

    private function getSelectedData($id,$data)
    {
        $formed_data = [];

        $this->validateSelectedValues($id,$data);

        foreach ($data as $key => $value){
            $formed_data[] = $key . '= ?';
        }

        return implode(', ',$formed_data);
    }

    private function getSelectedValues($id,$data)
    {
        $values = [];

        foreach ($data as $value){
            $values[] = $value;
        }
        $values[] = $id;

//

        return $values;
    }

    private function columns($data)
    {
        $col_arr = [];

        foreach ($data as  $key => $value){
            $col_arr[] = $key;
        }

        $this->validateColumns($col_arr);

        $columns = implode(',',$col_arr);

        return '(' . $columns . ')';
    }

    private function validateColumns($col_arr)
    {
        sort($col_arr);
        sort($this->columns);

        if($col_arr != $this->columns){
            $exists_columns = array_intersect($col_arr,$this->columns);
            foreach ($this->columns as $col){
                if(!in_array($col,$exists_columns)){
                    $this->errors[$col] = $col . ' Can`t Be Empty';
                }
            }
        }
    }

    private function values($data)
    {
        $values = [];

        foreach ($data as $value){
            $values[] =  '"'. $value . '"';
        }

        $this->validateValues($data);

        $vals = implode(',',$values);

        return '(' . $vals . ')';
    }

    private function validateValues($data)
    {
        foreach ($data as $key => $value){
            $keys[] = $key;
            if($value == null){
                $this->errors[$key] =  $key . ' is Required';
            }
        }
        if(!empty($this->unique)){
            foreach ($this->unique as $unique){
                if(in_array($unique,$keys)){
                    if($this->unique($unique,$data[$unique])){
                        $this->errors[$unique] = $unique .' exists in database';
                    }
                }
            }
        }
    }

    private function validateSelectedValues($id,$data)
    {
        foreach ($data as $key => $value){
            $keys[] = $key;
            if($value == null){
                $this->errors[$key] =  $key . ' is Required';
            }
        }
        if(!empty($this->unique)){
            foreach ($this->unique as $unique){
                if(in_array($unique,$keys)){
                    if($this->uniqueExcept($id,$unique,$data[$unique])){
                        $this->errors[$unique] = $unique .' exists in database';
                    }
                }
            }
        }
    }

    private function uniqueExcept($id,$key,$value)
    {
        $sql = 'SELECT * FROM ' .  $this->table .' WHERE id !=' . $id . ' AND ' . $key . ' = ?' ;
        $stmt = $this -> db -> prepare($sql);
        $stmt -> execute(array($value));
        $row = $stmt->fetch();
        if($stmt -> rowCount() > 0 ){
            return $row;
        }else{
            return false;
        }
    }

    private function unique($key,$value)
    {
        $sql = 'SELECT * FROM ' .  $this->table .' WHERE ' . $key . ' = ?' ;
        $stmt = $this -> db -> prepare($sql);
        $stmt -> execute(array($value));
        $row = $stmt->fetch();
        if($stmt -> rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

}