<?php
require_once('database.php');

class RADICAL
{
    public $dbh;
    public $radicals_table = "radicals";

    public function __construct(DB $dbh)
    {
        $this->dbh = $dbh;
    }

    // Fetch radical data, ordering by id or other available column
    public function fetchRadicals()
    {
        // Select all data and order by id
        $sql = "SELECT * FROM " . $this->radicals_table . " ORDER BY id";
        $stmt = $this->dbh->execute($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
$myDB = new DB();
$Radical = new RADICAL($myDB);
