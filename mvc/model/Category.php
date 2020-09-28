<?php
class Category
{
    var $category_id;
    var $name;
    var $description;
    var $status;

    public function __construct($category_id, $name, $description, $status)
    {
        $this->category_id = $category_id;
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
    }

    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_category WHERE status = 1") as $row) {
            array_push($data, new Category($row[0], $row[1], $row[2], $row[3]));
        }
        return $data;
    }

    public function get_data_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_category WHERE status = 1  LIMIT $start_record,$record_limit ") as $row) {
            array_push($data, new Category($row[0], $row[1], $row[2], $row[3]));
        }
        return $data;
    }

    public static function get_data_for_restore_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_category WHERE status = 0  LIMIT $start_record,$record_limit ") as $row) {
            array_push($data, new Category($row[0], $row[1], $row[2], $row[3]));
        }
        return $data;
    }

    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_category WHERE status = 0") as $row) {
            array_push($data, new Category($row[0], $row[1], $row[2], $row[3]));
        }
        return $data;
    }

    public static function get_data_according_to_search_name($search_name)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_category WHERE name like '%$search_name%' OR name Like '$search_name%' OR name like '%$search_name'");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Category($row[0], $row[1], $row[2], $row[3]));
        }
        return $data;
    }


    public static function get_data_according_to_search_name_for_each_page($search_name, $start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_category WHERE status = 1 AND (name like '%$search_name%' OR name Like '$search_name%' OR name like '%$search_name' )LIMIT $start_record,$record_limit");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Category($row[0], $row[1], $row[2], $row[3]));
        }
        return $data;
    }

    public static function get_category_for_filter($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_category WHERE category_id=?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $category = new Category($row[0], $row[1], $row[2], $row[3]);
        return $category;
    }

    public static function insert($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_category (name,description,status) VALUES (?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["description"], 1]);
    }

    public static function update($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_category SET name = ? , description = ? , status = ?  WHERE category_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["description"], $request["status"], $request["category_id"]]);
    }

    public static function remove($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_category SET status = 0 WHERE category_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function restore($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_category SET status = 1 WHERE category_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function delete($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_category WHERE category_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }
}
