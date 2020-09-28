<?php
class Author
{
    var $author_id;
    var $name;
    var $address;
    var $description;
    var $status;

    function __construct($author_id, $name,$address, $description, $status)
    {
        $this->author_id = $author_id;
        $this->name = $name;
        $this->address = $address;
        $this->description = $description;
        $this->status = $status;
    }

    public function get_data_for_each_page()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_author  LIMIT $start_record,$record_limit WHERE status = 1") as $row) {
            array_push($data, new Author($row[0], $row[1],$row[2], $row[3], $row[4]));
        }
        return $data;
    }

    public static function get_all_data() {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_author WHERE status = 1") as $row) {
            array_push($data, new Author($row[0], $row[1], $row[2],$row[3], $row[4]));
        }
        return $data;
    }
    

    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_author WHERE status = 0") as $row) {
            array_push($data, new Author($row[0], $row[1], $row[2], $row[3], $row[4]));
        }
        return $data;
    }
    
    public static function get_data_for_restore_for_each_page($start_record,$record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_author WHERE status = 0 LIMIT $start_record,$record_limit ") as $row) {
            array_push($data, new Author($row[0], $row[1], $row[2], $row[3], $row[4]));
        }
        return $data;
    }

    public static function get_data_according_to_search_name($search_name)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_author WHERE name like '%$search_name%' OR name Like '$search_name%' OR name like '%$search_name'");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Author($row[0], $row[1], $row[2], $row[3], $row[4]));
        }
        return $data;
    }


    public static function get_data_according_to_search_name_for_each_page($search_name, $start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_author WHERE status = 1 AND (name like '%$search_name%' OR name Like '$search_name%' OR name like '%$search_name' )LIMIT $start_record,$record_limit");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Author($row[0], $row[1], $row[2], $row[3], $row[4]));
        }
        return $data;
    }

    public static function get_author_for_filter($author_id) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_author WHERE author_id=?");
        $stmt->execute([$author_id]);
        $row = $stmt->fetch();
        $category = new Author($row[0], $row[1], $row[2], $row[3],$row[4]);
        return $category;
    } 

    public static function insert($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_author (name,address,description,status) VALUES (?,?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"],$request["address"], $request["description"],1]);
    }

    public static function update($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_author SET name = ? ,address = ?, description = ? , status = ?  WHERE author_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"],$request["address"], $request["description"],$request["status"],$request["author_id"]]);
    }

    public static function remove($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_author SET status = 0 WHERE author_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function delete($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_author WHERE author_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function restore($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_author SET status = 1 WHERE author_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }



}
