<?php
class Ward
{
    var $ward_id;
    var $name;
    var $prefix;
    var $province_id;
    var $district_id;

    public function __construct($ward_id, $name, $prefix, $province_id,$district_id)
    {
        $this->ward_id = $ward_id;
        $this->name = $name;
        $this->prefix = $prefix;
        $this->province_id = $province_id;
        $this->district_id = $district_id;
    }

    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_ward") as $row) {
            array_push($data, new Ward($row[0], $row[1],$row[2],$row[3],$row[4]));
        }
        return $data;
    }
    public static function get_all_wards_of_a_district($district_id) {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_ward WHERE district_id = ?
        ");
        $stmt->execute([$district_id]);
        $district = $stmt->fetchAll();
        foreach ($district as $row) {
            array_push($data, new Ward($row[0], $row[1], $row[2], $row[3],$row[4]));
        }
        return $data;
    }
    public static function get_a_ward($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_ward WHERE ward_id=?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $ward = new Ward($row[0], $row[1],$row[2],$row[3],$row[4]);
        return $ward;
    }
}
