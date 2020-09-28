<?php
class District
{
    var $district_id;
    var $name;
    var $prefix;
    var $province_id;

    public function __construct($district_id, $name, $prefix, $province_id)
    {
        $this->district_id = $district_id;
        $this->name = $name;
        $this->prefix = $prefix;
        $this->province_id = $province_id;
    }

    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_district") as $row) {
            array_push($data, new District($row[0], $row[1],$row[2],$row[3]));
        }
        return $data;
    }

    public static function get_all_district_of_a_province($province_id) {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_district WHERE province_id = ?");
        $stmt->execute([$province_id]);
        $district = $stmt->fetchAll();
        foreach ($district as $row) {
            array_push($data, new District($row[0], $row[1], $row[2], $row[3]));
        }
        return $data;
    }

    public static function get_a_district($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_district WHERE district_id=?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $district = new District($row[0], $row[1],$row[2],$row[3]);
        return $district;
    }
}

