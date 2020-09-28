<?php

class OrderDetails
{
    var $order_id;
    var $book_id;
    var $quantity;

    public function __construct($order_id, $book_id, $quantity)
    {
        $this->order_id = $order_id;
        $this->book_id = $book_id;
        $this->quantity = $quantity;
    }

    public static function insert($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_order_details (order_id,book_id,quantity) VALUES (?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["order_id"], $request["book_id"], $request["quantity"]]);
    }

    public static function get_order_details($request) {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_order_details WHERE order_id=?");
        $stmt->execute([$request]);
        $order_details = $stmt->fetchAll();
        foreach ($order_details as $row) {
            array_push($data, new OrderDetails($row[0], $row[1], $row[2]));
        }
        return $data;
    }

    public static function delete($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_order_details WHERE order_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function sort_selling($request) {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT sum(quantity) as sell FROM tbl_order_details WHERE book_id = ? GROUP BY book_id ");
        $stmt->execute([$request]);
        $sum = $stmt->fetchColumn();
        return $sum;
        // return $data;
    }
}
