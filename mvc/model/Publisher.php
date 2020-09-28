<?php
class Publisher
{
    var $publisher_id;
    var $name;
    var $address;
    var $email;
    var $number;
    var $status;

    public function __construct($publisher_id, $name, $address,$email,$number,$status)
    {
        $this->publisher_id = $publisher_id;
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
        $this->number = $number;
        $this->status = $status;
    }

    public function get_data_for_each_page($start_record,$record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_publisher  LIMIT $start_record,$record_limit WHERE status = 1") as $row) {
            array_push($data, new publisher($row[0], $row[1], $row[2],$row[3],$row[4],$row[5]));
        }
        return $data;
    }

    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_publisher WHERE status = 1") as $row) {
            array_push($data, new publisher($row[0], $row[1], $row[2],$row[3],$row[4],$row[5]));
        }
        return $data;
    }

    public static function get_data_according_to_search_name($search_name)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_publisher WHERE  status = 1 AND (name like '%$search_name%' OR name Like '$search_name%' OR name like '%$search_name')");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Publisher($row[0], $row[1], $row[2], $row[3],$row[4],$row[5]));
        }
        return $data;
    }


    public static function get_data_according_to_search_name_for_each_page($search_name, $start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_publisher WHERE status = 1 AND (name like '%$search_name%' OR name Like '$search_name%' OR name like '%$search_name' ) LIMIT $start_record,$record_limit");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Publisher($row[0], $row[1], $row[2], $row[3],$row[4],$row[5]));
        }
        return $data;
    }

    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_publisher WHERE status = 0") as $row) {
            array_push($data, new publisher($row[0], $row[1], $row[2],$row[3],$row[4],$row[5]));
        }
        return $data;
    }

    public static function get_data_for_restore_for_each_page($start_record,$record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_publisher WHERE status = 0  LIMIT $start_record,$record_limit ") as $row) {
            array_push($data, new publisher($row[0], $row[1], $row[2],$row[3],$row[4],$row[5]));
        }
        return $data;
    }

    public static function get_publisher_for_filter($publisher_id) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_publisher WHERE publisher_id=?");
        $stmt->execute([$publisher_id]);
        $row = $stmt->fetch();
        $publisher = new Publisher($row[0], $row[1], $row[2],$row[3],$row[4],$row[5]);
        return $publisher;
    } 

    public static function insert($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_publisher (name,address,email,number,status) VALUES (?,?,?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"],$request["address"],$request["email"], $request["number"],1]);
    }

    public static function update($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_publisher SET name = ? , address = ? , email = ? , number = ? , status = ?  WHERE publisher_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["address"],$request["email"],$request["number"],$request["status"],$request["publisher_id"]]);
    }

    public static function remove($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_publisher SET status = 0 WHERE publisher_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function restore($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_publisher SET status = 1 WHERE publisher_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function delete($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_publisher WHERE publisher_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

}
