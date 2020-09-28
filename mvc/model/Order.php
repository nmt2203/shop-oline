<?php
class Order
{
    var $order_id;
    var $order_date;
    var $order_delivery;
    var $status;
    var $cost;
    var $user_id;
    var $receiver;
    var $address;
    var $number;

    public function __construct($order_id, $order_date, $order_delivery, $status, $cost, $user_id, $receiver, $address, $number)
    {
        $this->order_id = $order_id;
        $this->order_date = $order_date;
        $this->order_delivery = $order_delivery;
        $this->status = $status;
        $this->cost = $cost;
        $this->user_id = $user_id;
        $this->receiver = $receiver;
        $this->address = $address;
        $this->number = $number;
    }

    public static function get_all_orders()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_order") as $row) {
            array_push($data, new Order($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]));
        }
        return $data;
    }


    public static function get_data_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_order ORDER BY status ASC LIMIT $start_record,$record_limit") as $row) {
            array_push($data, new Order($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]));
        }
        return $data;
    }

    public static function get_undone_order_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "SELECT * from tbl_order WHERE status < 3 LIMIT $start_record,$record_limit";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $orders = $stmt->fetchAll();
        foreach ($orders as $row) {
            array_push($data, new Order($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]));
        }
        return $data;
    }

    public static function get_all_undone_orders()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "SELECT * from tbl_order WHERE status < 3";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $orders = $stmt->fetchAll();
        foreach ($orders as $row) {
            array_push($data, new Order($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]));
        }
        return $data;
    }

    public static function get_all_done_orders_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "SELECT * from tbl_order WHERE status = 3 LIMIT $start_record,$record_limit";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $orders = $stmt->fetchAll();
        foreach ($orders as $row) {
            array_push($data, new Order($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]));
        }
        return $data;
    }

    public static function get_all_done_orders()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "SELECT * from tbl_order WHERE status == 3";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $orders = $stmt->fetchAll();
        foreach ($orders as $row) {
            array_push($data, new Order($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]));
        }
        return $data;
    }

    public static function get_undone_order_for_each_page_each_customer($request, $start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "SELECT * from tbl_order WHERE status < 3 AND user_id = ? LIMIT $start_record,$record_limit";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
        $orders = $stmt->fetchAll();
        foreach ($orders as $row) {
            array_push($data, new Order($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]));
        }
        return $data;
    }

    public static function get_all_undone_orders_each_customer($request)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "SELECT * from tbl_order WHERE status < 3 AND user_id = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
        $orders = $stmt->fetchAll();
        foreach ($orders as $row) {
            array_push($data, new Order($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]));
        }
        return $data;
    }

    public static function get_all_done_orders_for_each_page_each_customer($request, $start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "SELECT * from tbl_order WHERE status == 3 AND user_id = ? LIMIT $start_record,$record_limit";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
        $orders = $stmt->fetchAll();
        foreach ($orders as $row) {
            array_push($data, new Order($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]));
        }
        return $data;
    }

    public static function get_all_done_orders_each_customer($request)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "SELECT * from tbl_order WHERE status == 3 AND user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
        $orders = $stmt->fetchAll();
        foreach ($orders as $row) {
            array_push($data, new Order($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]));
        }
        return $data;
    }

    public static function get_an_order($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_order WHERE order_id=?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        if ($row != null) {
            $order = new Order($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]);
            return $order;
        } else {
            return null;
        }
    }

    public static function insert($request)
    {
        try {
            if (isset($_SESSION["user_id"])) {
                $user = User::get_an_user($request["user_id"]);
                $date = date("y-m-d");
                $config = include CONFIG . "config.php";
                $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
                $sql = "INSERT INTO tbl_order (order_date,cost,user_id,receiver,address,number) VALUES (?,?,?,?,?,?) ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$date, $request["cost"], $user->user_id, $request["receiver"], $request["address"], $request["number"]]);

                $lastest_order_id = $pdo->lastInsertId();
                foreach (Cart::get_all_carts() as $cart) {
                    $request = array("order_id" => $lastest_order_id, "book_id" => $cart->book_id, "quantity" => $cart->quantity);
                    // print_r($request);
                    OrderDetails::insert($request);
                }

                foreach (Cart::get_all_carts() as $cart) {
                    $request = array("book_id" => $cart->book_id, "quantity" => 0 - $cart->quantity);
                    Book::modify_quantity($request);
                }


                foreach (Cart::get_all_carts() as $cart) {
                    Cart::do_delete_cart($cart->book_id);
                }
            }
        } catch (PDOException $e) {
            print_r($sql . "<br>" . $e->getMessage());
        }
    }

    public static function do_delete_order($request)
    {
        try {
            Order::delete($request);
            OrderDetails::delete($request);
            return null;
        } catch (PDOException $e) {
            return ($e->getMessage());
        }
    }

    public static function process_order($request)
    {
        if ($request["status"]  == 3) {
            $date = date("y-m-d");
            $config = include CONFIG . "config.php";
            $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
            $sql = "UPDATE tbl_order SET status = ? , delivery_date = ? WHERE order_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$request["status"], $date, $request["order_id"]]);
        } else {
            $config = include CONFIG . "config.php";
            $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
            $sql = "UPDATE tbl_order SET status = ? WHERE order_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$request["status"], $request["order_id"]]);
        }
    }

    public static function delete($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_order WHERE order_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function all_orders_of_a_year($request) {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "SELECT * from tbl_order WHERE YEAR(order_date) = ? AND status = 3";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
        $orders = $stmt->fetchAll();
        foreach ($orders as $row) {
            array_push($data, new Order($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]));
        }
        return $data;
    }

    public static function report_chart($request) {
        $data = [];
        // $month = 12;
        for ($i = 1 ; $i <= 12 ; $i++) {
            $sales = 0;
            $orders = 0;
            foreach(Order::all_orders_of_a_year($request) as $item) {
                $month = date_create($item->order_date);
                if (date_format($month,"m") == $i) {
                    $sales += $item->cost;
                    $orders ++;
                }
            }
            array_push($data,array($i => array("sales"=>$sales,"orders"=>$orders)));
        }
        return $data;
    }
}
