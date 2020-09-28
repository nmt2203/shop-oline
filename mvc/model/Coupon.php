<?php
class Coupon
{
    var $coupon_id;
    var $content;
    var $status;

    public function __construct($coupon_id, $content, $status)
    {
        $this->coupon_id = $coupon_id;
        $this->content = $content;
        $this->status = $status;
    }

    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_coupon WHERE status = 1") as $row) {
            array_push($data, new Coupon($row[0], $row[1], $row[2]));
        }
        return $data;
    }

    public static function get_data_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_coupon WHERE status = 1 LIMIT $start_record,$record_limit");
        $stmt->execute();
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Coupon($row[0], $row[1], $row[2]));
        }
        return $data;
    }

    public static function get_data_for_restore_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_coupon WHERE status = 0  LIMIT $start_record,$record_limit ") as $row) {
            array_push($data, new Coupon($row[0], $row[1], $row[2]));
        }
        return $data;
    }

    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_coupon WHERE status = 0") as $row) {
            array_push($data, new Coupon($row[0], $row[1], $row[2]));
        }
        return $data;
    }

    public static function get_a_coupon($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_coupon WHERE coupon_id=?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $coupon = new Coupon($row[0], $row[1], $row[2]);
        return $coupon;
    }

    public static function get_coupon_of_a_book($request)
    {
        $book = Book::get_a_book($request);
        $coupon = Coupon::get_a_coupon($book->coupon_id);
        if ($coupon != null)
            return $coupon->content;
        else
            return 0;
    }

    public static function insert($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_coupon (content,status) VALUES (?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["content"], 1]);
    }

    public static function update($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_coupon SET content = ? , status = ?  WHERE coupon_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["content"], $request["status"] ,$request["coupon_id"]]);
    }

    public static function remove($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_coupon SET status = 0 WHERE coupon_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function restore($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_coupon SET status = 1 WHERE coupon_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function delete($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_coupon WHERE coupon_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

}
