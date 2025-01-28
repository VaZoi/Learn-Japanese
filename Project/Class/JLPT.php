<?php
require_once('database.php');

class JLPT
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

    public function fetchKanjiWithDetails($jlpt = 'JLPT N5')
    {
        // SQL query to fetch the kanji and related details
        $sql = "
            SELECT k.id AS kanji_id, k.kanji, k.meaning AS kanji_meaning, k.stroke_order, k.jlpt, 
                   GROUP_CONCAT(DISTINCT r.radical) AS radicals, 
                   GROUP_CONCAT(DISTINCT o.reading) AS onyomi_readings, 
                   GROUP_CONCAT(DISTINCT ku.reading) AS kunyomi_readings
            FROM {$this->kanji_table} k
            LEFT JOIN {$this->kanji_radicals_table} kr ON k.id = kr.kanji_id
            LEFT JOIN {$this->radicals_table} r ON kr.radical_id = r.id
            LEFT JOIN {$this->onyomi_table} o ON k.id = o.kanji_id
            LEFT JOIN {$this->kunyomi_table} ku ON k.id = ku.kanji_id
            WHERE k.jlpt = :jlpt
            GROUP BY k.id
        ";

        // Call the execute method
        $stmt = $this->dbh->execute($sql, ['jlpt' => $jlpt]);

        // Fetch the results
        $kanjiDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $kanjiDetails;
    }
}
$myDB = new DB();
$JLPT = new JLPT($myDB);
