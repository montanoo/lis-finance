<?php

class ConnectionMysql
{
  public $servername = "localhost";
  public $username = "root";
  public $password = "";
  function connect_to_database()
  {
    try {
      $conn = new PDO("mysql:host=$this->servername;dbname=lis_dashboard", $this->username, $this->password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    } catch (PDOException $e) {
      return $this->create_database();
    }
  }

  function create_database()
  {
    try {
      $conn = new PDO("mysql:host=$this->servername", $this->username, $this->password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "CREATE DATABASE lis_dashboard";
      // use exec() because no results are returned
      $conn->exec($sql);
    } catch (PDOException $e) {
      // echo $sql . "<br>" . $e->getMessage();
    }
  }
}
