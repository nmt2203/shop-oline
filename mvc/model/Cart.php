<?php
class Cart
{
    var $book_id;
    var $user_id;
    var $quantity;

    public function __construct($book_id, $user_id, $quantity)
    {
        $this->book_id = $book_id;
        $this->user_id = $user_id;
        $this->quantity = $quantity;
    }

    public static function get_all_carts()
    {
        $data = [];
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
            $config = include CONFIG . "config.php";
            $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
            foreach ($pdo->query("SELECT * from tbl_cart WHERE user_id = $user_id") as $row) {
                array_push($data, new Cart($row[0], $row[1], $row[2]));
            }
        }
        return $data;
    }

    public static function check_out()
    {
        $message = null;
        $cart = Cart::get_all_carts();
        foreach (Book::get_all_carts() as $book) {
            foreach (Cart::get_all_carts() as $cart) {
                if ($book->book_id == $cart->book_id) {
                    if (Book::check_out($cart->quantity, $book->book_id) == false) {
                        if ($book->quantity == 0) {
                            $message .= $book->name . ": Out of stock; ";
                        } else {
                            if ($book->quantity == 1) {
                                $message .= $book->name . ": The store has only " . $book->quantity . " book left ; ";
                            } else {
                                $message .= $book->name . ": The store has only " . $book->quantity . " books left ; ";
                            }
                        }
                    }
                }
            }
        }
        return $message;
    }

    public static function add_to_cart($book_id)
    {
        if (Book::check_status_of_a_book($book_id)) {
            if (Book::check_out(1, $book_id)) {
                if (isset($_SESSION["user_id"])) {
                    if (Cart::get_a_cart($book_id) == null) {
                        Cart::insert($book_id, 1);
                        return "Insert";
                    } else {
                        Cart::update($book_id, 1);
                        return "Update";
                    }
                }
            } else {
                return "Sold out!";
            }
        } else {
            return "The product that you demand is not available!";
        }
    }

    public static function get_total_cost()
    {
        $total_cost = 0;
        foreach (Cart::get_all_carts() as $cart) {
            if (isset($_SESSION["user_id"])) {
                $book = Book::get_a_book($cart->book_id);
            }
            $total_cost += $book->price * (1 - Coupon::get_coupon_of_a_book($book->book_id)) * $cart->quantity;
            $book = null;
        }
        return $total_cost;
    }

    public static function get_a_cart($book_id)
    {
        $user_id = $_SESSION["user_id"];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_cart WHERE book_id=? AND user_id = ?");
        $stmt->execute([$book_id, $user_id]);
        $row = $stmt->fetch();
        if ($row != null) {
            $cart = new Cart($row[0], $row[1], $row[2]);
            return $cart;
        } else {
            return null;
        }
    }

    public static function insert($book_id, $quantity)
    {
        $user_id = $_SESSION["user_id"];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_cart (book_id,user_id,quantity) VALUES (?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$book_id, $user_id, $quantity]);
    }

    public static function update($book_id, $quantity)
    {
        $user_id = $_SESSION["user_id"];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_cart SET quantity = quantity +  ?  WHERE book_id = ? AND user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$quantity, $book_id, $user_id]);
    }

    public static function change_quantity($request)
    {
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
            $config = include CONFIG . "config.php";
            $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
            $sql = "UPDATE tbl_cart SET quantity = ?  WHERE book_id = ? AND user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$request["quantity"], $request["book_id"], $user_id]);
        }
    }

    public static function do_delete_cart($request)
    {
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
            $config = include CONFIG . "config.php";
            $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
            $sql = "DELETE FROM tbl_cart WHERE book_id = ? AND user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$request, $user_id]);
        }
    }
}
