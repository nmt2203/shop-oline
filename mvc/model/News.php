<?php
class News
{
    var $news_id;
    var $name;
    var $content;
    var $image;
    var $date;
    var $status;

    public function __construct($news_id, $name, $content, $image, $date, $status)
    {
        $this->news_id = $news_id;
        $this->name = $name;
        $this->content = $content;
        $this->image = $image;
        $this->date = $date;
        $this->status = $status;
    }

    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_news Where status = 1") as $row) {
            array_push($data, new News($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]));
        }
        return $data;
    }

    public static function get_data_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_news WHERE status = 1 LIMIT $start_record,$record_limit");
        $stmt->execute();
        $news = $stmt->fetchAll();
        foreach ($news as $row) {
            array_push($data, new News($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]));
        }
        return $data;
    }

    public static function get_a_news($request)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_news WHERE news_id = ? ");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $news =  new News($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
        return $news;
    }

    public static function get_data_for_restore_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_news WHERE status = 0 LIMIT $start_record,$record_limit");
        $stmt->execute();
        $news = $stmt->fetchAll();
        foreach ($news as $row) {
            array_push($data, new News($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]));
        }
        return $data;
    }
    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_news WHERE status = 0");
        $stmt->execute();
        $news = $stmt->fetchAll();
        foreach ($news as $row) {
            array_push($data, new News($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]));
        }
        return $data;
    }

    public static function add_new_news($request) {
        if (Book::upload_image(UPLOADS . "news_image" . DIRECTORY_SEPARATOR) == "") {
            News::insert($request);
            return "";
        } else {
            return Book::upload_image(UPLOADS . "news_image" . DIRECTORY_SEPARATOR);
        }
    }

    public static function insert($request) {
        $date = date("y-m-d");
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_news (name,content,image,date,status) VALUES (?,?,?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["content"], $request["image"], $date, 1]);
    }

    public static function update($request)
    {
        $date = date("y-m-d");
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_news SET name = ? , content = ? , date = ? , image = ? , status = ? WHERE news_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["content"], $date, $request["image"], $request["status"], $request["news_id"]]);
    }

    public static function remove($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_news SET status = 0 WHERE news_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    
    public static function restore($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_news SET status = 1 WHERE news_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

        
    public static function delete($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_news WHERE news_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }
}
