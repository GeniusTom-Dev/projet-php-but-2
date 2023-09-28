<?php

/*
 * @author GeniusTom
 * @date = 28/09/20230
 * @title Class DataBase
 * @desc Create connection to database and actions
 */

use utilities\GReturn;

class db{

    // Host of db server
    private string $host;

    // Username of server
    private string $username;

    // Password of server
    private string $password;

    // Name of database
    private string $db;

    // Connection of db
    private \mysqli $conn;

    public function __construct($host, $username, $password, $db){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
    }

    public function getConnection(): GReturn
    {
        $connection = new \mysqli($this->host, $this->username, $this->password, $this->db);

        if ($connection->connect_error) {
            new GReturn("ko", $connection->connect_error);
        }
        $this->conn = $connection;
        return new GReturn("ok", content: $connection);
    }
}