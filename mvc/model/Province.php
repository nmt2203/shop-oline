<?php
class Province
{
    var $province_id;
    var $name;

    public function __construct($province_id, $name)
    {
        $this->province_id = $province_id;
        $this->name = $name;
    }

    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_province") as $row) {
            array_push($data, new Province($row[0], $row[1]));
        }
        return $data;
    }
    public static function get_a_province($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_province WHERE province_id=?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $province = new Province($row[0], $row[1]);
        return $province;
    }
}
