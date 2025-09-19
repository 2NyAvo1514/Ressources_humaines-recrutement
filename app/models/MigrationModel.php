<?php
namespace app\models;
use PDO;

class MigrationModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}