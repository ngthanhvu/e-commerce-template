<?php
include "config.php";
define("HOST", "localhost");
define("DB_NAME", "baoveasm");
define("USERNAME", "root");
define("PASSWORD", "");
class DBUntil
{
     /**x
      * xay dung ham CRUD
      */
     private $connection = null;
     function __construct()
     {
          $db = new Database(HOST, USERNAME, PASSWORD, DB_NAME);
          $this->connection = $db->getConnection();
     }
     public function select($sql, $params = [])
     {
          $stmt = $this->connection->prepare($sql);
          $stmt->execute($params);
          $stmt->setFetchMode(PDO::FETCH_ASSOC);
          return $stmt->fetchAll();
     }
     public function insert($table, $data)
     {
          $keys = array_keys($data);
          $fields = implode(", ", $keys);
          $placeholders = ":" . implode(", :", $keys);
          $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
          $stmt = $this->connection->prepare($sql);

          foreach ($data as $key => $value) {
               $stmt->bindValue(":$key", $value);
          }

          $stmt->execute();
          return $this->connection->lastInsertId();
     }
     public function update($table, $data, $condition)
     {
          $updateFields = [];

          foreach ($data as $key => $value) {
               $updateFields[] = "$key = :$key";
          }
          $updateFields = implode(", ", $updateFields);
          $sql = "UPDATE $table SET $updateFields WHERE $condition";
          $stmt = $this->connection->prepare($sql);
          foreach ($data as $key => $value) {
               $stmt->bindValue(":$key", $value);
          }

          $stmt->execute();
          return $stmt->rowCount();
     }
     public function delete($table, $condition)
     {
          $sql = "DELETE FROM $table WHERE $condition";
          var_dump($sql);
          $stmt = $this->connection->prepare($sql);
          $stmt->execute();
          return $stmt->rowCount();
     }
     public function count($table)
     {
          $sql = "SELECT COUNT(*) as count FROM $table";
          $stmt = $this->connection->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          return $result['count'];
     }
}
