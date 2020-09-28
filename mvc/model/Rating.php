<?php 
class Rating {
    var $rating_id;
    var $score;
    var $book_id;
    

    public function __construct($rating_id,$score,$book_id)
    {
        $this->rating_id = $rating_id;
        $this->score = $score;
        $this->book_id = $book_id;
    }

    public static function insert($book_id,$score)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_rating (book_id,score) VALUES (?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$book_id, $score]);
    }

    public static function count_all_reviews_of_a_book($request)
    {
        // $data = 0;
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT count(*) as reivews from tbl_rating WHERE book_id = ?");
        $stmt->execute([$request]);
        $count = $stmt->fetchColumn();
        return $count;
    }
    public static function total_score_of_a_book($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT sum(score) as total from tbl_rating WHERE book_id = ?");
        $stmt->execute([$request]);
        $total = $stmt->fetchColumn();
        return $total;
    }
    public static function average_score_of_a_book($request)
    {
        if (Rating::count_all_reviews_of_a_book($request) != 0)
        $average_score = Rating::total_score_of_a_book($request) / Rating::count_all_reviews_of_a_book($request);
        else 
        $average_score = 0;
        return number_format($average_score, 2);
    }

}