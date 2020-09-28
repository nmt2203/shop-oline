<?php
class Book
{
    var $book_id;
    var $name;
    var $description;
    var $quantity;
    var $price;
    var $date;
    var $image;
    var $status;
    var $author_id;
    var $category_id;
    var $publisher_id;
    var $coupon_id;

    public function __construct($book_id, $name, $description, $quantity, $price, $date, $image, $status, $author_id, $category_id, $publisher_id, $coupon_id)
    {
        $this->book_id = $book_id;
        $this->name = $name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->date = $date;
        $this->image = $image;
        $this->status = $status;
        $this->author_id = $author_id;
        $this->category_id = $category_id;
        $this->publisher_id = $publisher_id;
        $this->coupon_id = $coupon_id;
    }

    public static function get_all_books()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_book Where status != 2") as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function sort_a_to_z($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book ORDER BY name asc LIMIT $start_record,$record_limit");
        $stmt->execute();
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function sort_date($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book ORDER BY date desc LIMIT $start_record,$record_limit");
        $stmt->execute();
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function sort_sale_off($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE coupon_id IS NOT NULL LIMIT $start_record,$record_limit");
        $stmt->execute();
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function sort_rating($record_limit)
    {
        $data = [];
        foreach (Book::get_all_books() as $book) {
            array_push($data, $book->book_id);
            $data[$book->book_id] = Rating::average_score_of_a_book($book->book_id);
        }
        arsort($data);
        $delete = count($data) - $record_limit - 1;
        for ($i = 0; $i < $delete; $i++) {
            array_pop($data);
        }
        $books = [];
        foreach ($data as $id => $value) {
            array_push($books, Book::get_a_book($id));
        }
        return $books;
    }

    public static function sort_selling($record_limit)
    {
        $data = [];
        foreach (Book::get_all_books() as $book) {
            array_push($data, $book->book_id);
            $data[$book->book_id] = OrderDetails::sort_selling($book->book_id);
        }
        arsort($data);
        $delete = count($data) - $record_limit - 1;
        for ($i = 0; $i < $delete; $i++) {
            array_pop($data);
        }
        $books = [];
        foreach ($data as $id => $value) {
            array_push($books, Book::get_a_book($id));
        }
        return $books;
    }

    public static function get_data_according_to_publisher($publisher_id, $start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE publisher_id = ? LIMIT $start_record,$record_limit");
        $stmt->execute([$publisher_id]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function count_book_according_to_publisher($publisher_id)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE publisher_id=?");
        $stmt->execute([$publisher_id]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return count($data);
    }

    public static function count_book_of_each_publisher()
    {
        $data = [];
        foreach (Publisher::get_all_data() as $publisher) {
            array_push($data, array($publisher->publisher_id => Book::count_book_according_to_publisher($publisher->publisher_id)));
        }
        return $data;
    }

    public static function get_data_according_to_author($author_id, $start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE author_id = ? LIMIT $start_record,$record_limit");
        $stmt->execute([$author_id]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function count_book_according_to_author($author_id)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE author_id=?");
        $stmt->execute([$author_id]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return count($data);
    }

    public static function count_book_of_each_author()
    {
        $data = [];
        foreach (Author::get_all_data() as $author) {
            array_push($data, array($author->author_id => Book::count_book_according_to_author($author->author_id)));
        }
        return $data;
    }

    public static function get_data_according_to_category($category_id, $start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE category_id = ? LIMIT $start_record,$record_limit");
        $stmt->execute([$category_id]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function count_book_according_to_category($request)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE category_id=?");
        $stmt->execute([$request]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return count($data);
    }

    public static function count_book_of_each_category()
    {
        $data = [];
        foreach (Category::get_all_data() as $category) {
            array_push($data, array($category->category_id => Book::count_book_according_to_category($category->category_id)));
        }
        return $data;
    }

    public static function get_a_book($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE book_id=?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $book = new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]);
        return $book;
    }

    public static function get_data_according_to_search_name_for_each_page($search_name, $start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE status != 2 AND (name like '%$search_name%' OR name Like '$search_name%' OR name like '%$search_name' )LIMIT $start_record,$record_limit");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function get_data_according_to_search_name($search_name)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE name like '%$search_name%' OR name Like '$search_name%' OR name like '%$search_name'");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function get_data_for_restore_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE status = 2 LIMIT $start_record,$record_limit");
        $stmt->execute();
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE status = 2");
        $stmt->execute();
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function check_out($demand, $book_id)
    {
        $data = Book::get_a_book($book_id);
        if ($data->quantity <= $demand) {
            return false;
        } else {
            return true;
        }
    }

    public static function get_all_carts()
    {
        $data = [];
        if (isset($_SESSION["user_id"])) {
            $cart = Cart::get_all_carts();
            foreach ($cart as $row) {
                array_push($data, Book::get_a_book($row->book_id));
            }
        }
        return $data;
    }

    public static function get_all_comments($request)
    {
        $data = [];
        $array = [];
        foreach (Comment::get_all_comments_of_an_user($request) as $comment) {
            array_push($array, $comment->book_id);
        }
        foreach (array_unique($array) as $id) {
            array_push($data, Book::get_a_book($id));
        }
        return $data;
    }

    public static function get_all_carts_coupons()
    {
        $data = [];
        foreach (Book::get_all_carts() as $book) {
            array_push($data, array($book->book_id => Coupon::get_coupon_of_a_book($book->book_id)));
        }
        return $data;
    }

    public static function get_order_details($request)
    {
        $data = [];
        foreach (OrderDetails::get_order_details($request) as $order) {
            array_push($data, Book::get_a_book($order->book_id));
        }
        return $data;
    }

    public static function check_status_of_a_book($book_id)
    {
        $book = Book::get_a_book($book_id);
        if ($book->status == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_data_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_book WHERE status != 2 LIMIT $start_record,$record_limit") as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public function count_books()
    {
        $count = 0;
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT count(*) from tbl_book WHERE status != 2");
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

    public static function upload_image($destination)
    {
        $target_dir = $destination;
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        //check to see if this file is an image or not
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check != false) {
            $uploadOk = 1;
        } else {
            return "File is not an image!";
        }
        //check to see if this folder has a file which is the same as this one
        if (file_exists($target_file)) {
            $uploadOk = 0;
            return  "This image has already been used!";
        }
        // check to see if the size of this file is qualified or not
        if ($_FILES["image"]["size"] > 5000000) {
            $uploadOk = 0;
            return "The image is too large, > 5MB";
        }
        // check to see if the format of the file is qualified or not
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif") {
            // $error_message = "Only accept the file ends up with jpg, png or gif! ";
            $uploadOk = 0;
            return "Only accept the file ends up with jpg, png or gif! ";
        }
        if ($uploadOk != 0) {
            //     $error_message = "Error occurred!";
            // } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            } else {
                return "Oh god, why did you do this to me!";
            }
        }
    }

    public static function modify_quantity($request)
    {
        // $date = date("y-m-d");
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_book SET quantity = quantity + ?  WHERE book_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["quantity"], $request["book_id"]]);
    }

    public static function insert($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_book (name,description,quantity,price,date,image,status,author_id,category_id,publisher_id,coupon_id) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["description"], $request["quantity"], $request["price"], $request["date"], $request["image"], 1, $request["author_id"], $request["category_id"], $request["publisher_id"], $request["coupon_id"]]);
    }

    public static function add_new_book($request)
    {
        if (Book::upload_image(UPLOADS . "book_image" . DIRECTORY_SEPARATOR) == "") {
            Book::insert($request);
            return "Ok";
        } else {
            return Book::upload_image(UPLOADS . "book_image" . DIRECTORY_SEPARATOR);
        }
    }

    public static function update($request)
    {
        $date = date("y-m-d");
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_book SET name = ? , description = ? , quantity = ? , price = ? , date = ? , image = ? , status = ? , author_id = ? , category_id = ? , publisher_id = ? , coupon_id = ? WHERE book_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["description"], $request["quantity"], $request["price"], $date, $request["image"], $request["status"], $request["author_id"], $request["category_id"], $request["publisher_id"], $request["coupon_id"], $request["book_id"]]);
    }

    public static function do_remove($request) {
        $book = Book::get_a_book($request);
        if ($book->quantity > 0) {
            return $book->name.": there are " .$book->quantity." books left in the store; ";
        }
        else {
            Book::remove($request);
        }
    }
    public static function remove($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_book SET status = 2 WHERE book_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }
    public static function restore($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_book SET status = 1 WHERE book_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function delete($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_book WHERE book_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }
}
