<?php
require_once('database.php');

class Practice
{
    public $dbh;
    public $kanji_table = "kanji";
    public $onyomi_table = "onyomi";
    public $kunyomi_table = "kunyomi";
    public $radicals_table = "radicals";
    public $kanji_radicals_table = "kanji_radicals";

    public function __construct(DB $dbh)
    {
        $this->dbh = $dbh;
    }

}
$myDB = new DB();
$Practice = new Practice($myDB);
