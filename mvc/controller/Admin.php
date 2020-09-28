<?php
class Admin extends Controller
{

    public function index()
    {
        $search_year = 0;
        $date = date("yy");
        // print_r($date);
        if (isset($_POST["year"])) {
            $search_year = $_POST["search_year"];
        } else {
            $search_year = date("yy");
        }
        $this->view(
            "admin" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "report" . DIRECTORY_SEPARATOR . "report.php",
                "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                "report_chart" => Order::report_chart($search_year),
                "year" => $search_year,
                "books" => Book::get_all_books(),
                "news" => News::get_all_data(),
                "comments" => Comment::get_all_first_comments(),
                "orders" => Order::get_all_undone_orders(),
            ]
        );
        $this->view->render();
    }
    public function book($action)
    {
        switch ($action) {
            case "index":
                $search_name = "";
                if (isset($_POST["search"])) {
                    $search_name = $_POST["search_name"];
                } else {
                    $search_name = "";
                }
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Book::get_data_according_to_search_name($search_name));
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "book" . DIRECTORY_SEPARATOR . "book_management.php",
                        "books" => Book::get_data_according_to_search_name_for_each_page($search_name, $start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "add":
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "book" . DIRECTORY_SEPARATOR . "book_add.php",
                        "authors" => Author::get_all_data(),
                        "publishers" => Publisher::get_all_data(),
                        "coupons" => Coupon::get_all_data(),
                        "categories" => Category::get_all_data(),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        // ""
                    ]
                );
                $this->view->render();
                break;
            case "do_add":
                $request = $_POST;
                $request["image"] = $_FILES["image"]["name"];
                if ($_POST["coupon_id"] == "" || $_POST["coupon_id"] == null) {
                    $request["coupon_id"] = null;
                }
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Book::add_new_book($request),
                    ]
                );
                $this->view->render();
                break;
            case "update":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $book_id = explode("=", explode("/", $_GET["url"])[3])[1];
                }
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "book" . DIRECTORY_SEPARATOR . "book_update.php",
                        "book" => Book::get_a_book($book_id),
                        "authors" => Author::get_all_data(),
                        "publishers" => Publisher::get_all_data(),
                        "coupons" => Coupon::get_all_data(),
                        "categories" => Category::get_all_data(),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        // "action" => "update",
                    ]
                );
                $this->view->render();
                break;
            case "do_update":
                $request = $_POST;
                if ($_FILES["image"]["name"] != null) {
                    $request["image"] = $_FILES["image"]["name"];
                    Book::upload_image(UPLOADS . "book_image" . DIRECTORY_SEPARATOR);
                } else {
                    $request["image"] = $_POST["current_image"];
                }
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Book::update($request),

                    ]
                );
                $this->view->render();
                break;
            case "do_remove":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Book::do_remove($request["book_id"]),

                    ]
                );
                $this->view->render();
                break;
            case "do_mass_remove":
                $request = $_POST;
                $message = "";
                if (!empty($request["mass_remove_list"])) {
                    foreach ($request["mass_remove_list"] as $remove_list) {
                        $message .= Book::do_remove($remove_list);
                    }
                } else {
                    $message = "You have yet selected any product to delete.";
                }
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => $message,

                    ]
                );
                $this->view->render();
                break;
            case "do_delete":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Book::delete($request["book_id"]),

                    ]
                );
                $this->view->render();
                break;
            case "restore":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                // print_r(Book::get_data_for_restore());
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Book::get_data_for_restore());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "book" . DIRECTORY_SEPARATOR . "book_restore.php",
                        "books" => Book::get_data_for_restore_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_restore":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Book::restore($request["book_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "import":
                if (isset($_POST["go"])) {
                    $import_number = $_POST["import_number"];
                } else {
                    $import_number = 0;
                }
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "book" . DIRECTORY_SEPARATOR . "book_import.php",
                        "import_number" => $import_number,
                        "books" => Book::get_all_books(),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),


                    ]
                );
                $this->view->render();
                break;
            case "do_import":
                $request = $_POST;
                $message = null;
                for ($n = 0; $n < $request["import_number"]; $n++) {
                    $request["book_id"] = $request["book_id$n"];
                    $request["quantity"] = $request["quantity$n"];
                    $message = Book::modify_quantity($request);
                    $request["book_id"] = null;
                    $request["quantity"] = null;
                }
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => $message,
                    ]
                );
                $this->view->render();
                break;
            default:
                $search_name = "";
                if (isset($_POST["search"])) {
                    $search_name = $_POST["search_name"];
                } else {
                    $search_name = "";
                }
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Book::get_data_according_to_search_name($search_name));
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "book" . DIRECTORY_SEPARATOR . "book_management.php",
                        "books" => Book::get_data_according_to_search_name_for_each_page($search_name, $start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
        }
    }

    public function category($action)
    {
        switch ($action) {
            case "index":
                $search_name = "";
                if (isset($_POST["search"])) {
                    $search_name = $_POST["search_name"];
                } else {
                    $search_name = "";
                }
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 5;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Category::get_data_according_to_search_name($search_name));
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "category" . DIRECTORY_SEPARATOR . "category_management.php",
                        "categories" => Category::get_data_according_to_search_name_for_each_page($search_name, $start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "add":
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "category" . DIRECTORY_SEPARATOR . "category_add.php",
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_add":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Category::insert($request),
                    ]
                );
                $this->view->render();
                break;
            case "update":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $category_id = explode("=", explode("/", $_GET["url"])[3])[1];
                }
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "category" . DIRECTORY_SEPARATOR . "category_update.php",
                        "category" => Category::get_category_for_filter($category_id),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_update":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Category::update($request),
                    ]
                );
                $this->view->render();
                break;
            case "do_remove":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Category::remove($request["category_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "do_mass_remove":
                $request = $_POST;
                $message = "";
                if (!empty($request["mass_remove_list"])) {
                    foreach ($request["mass_remove_list"] as $remove_list) {
                        $message .= Category::remove($remove_list);
                    }
                } else {
                    $message = "You have yet selected any product to delete.";
                }
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => $message,
                    ]
                );
                $this->view->render();
                break;
            case "restore":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Category::get_data_for_restore());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "category" . DIRECTORY_SEPARATOR . "category_restore.php",
                        "categories" => Category::get_data_for_restore_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_restore":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Category::restore($request["category_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "do_delete":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Category::delete($request["category_id"]),
                    ]
                );
                $this->view->render();
                break;
            default:
                $search_name = "";
                if (isset($_POST["search"])) {
                    $search_name = $_POST["search_name"];
                } else {
                    $search_name = "";
                }
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 5;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Category::get_data_according_to_search_name($search_name));
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "category" . DIRECTORY_SEPARATOR . "category_management.php",
                        "categories" => Category::get_data_according_to_search_name_for_each_page($search_name, $start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
        }
    }

    public function author($action)
    {
        switch ($action) {
            case "index":
                $search_name = "";
                if (isset($_POST["search"])) {
                    $search_name = $_POST["search_name"];
                } else {
                    $search_name = "";
                }
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 5;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Author::get_data_according_to_search_name($search_name));
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "author" . DIRECTORY_SEPARATOR . "author_management.php",
                        "authors" => Author::get_data_according_to_search_name_for_each_page($search_name, $start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "add":
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "author" . DIRECTORY_SEPARATOR . "author_add.php",
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_add":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Author::insert($request),
                    ]
                );
                $this->view->render();
                break;
            case "update":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $author_id = explode("=", explode("/", $_GET["url"])[3])[1];
                }
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "author" . DIRECTORY_SEPARATOR . "author_update.php",
                        "author" => Author::get_author_for_filter($author_id),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_update":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Author::update($request),
                    ]
                );
                $this->view->render();
                break;
            case "do_remove":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Author::remove($request["author_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "do_mass_remove":
                $request = $_POST;
                $message = "";
                if (!empty($request["mass_remove_list"])) {
                    foreach ($request["mass_remove_list"] as $remove_list) {
                        $message .= Author::remove($remove_list);
                    }
                } else {
                    $message = "You have yet selected any product to delete.";
                }
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => $message,
                    ]
                );
                $this->view->render();
                break;
            case "do_delete":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Author::delete($request["author_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "restore":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Author::get_data_for_restore());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "author" . DIRECTORY_SEPARATOR . "author_restore.php",
                        "authors" => Author::get_data_for_restore_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_restore":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Author::restore($request["author_id"]),
                    ]
                );
                $this->view->render();
                break;
            default:
                $search_name = "";
                if (isset($_POST["search"])) {
                    $search_name = $_POST["search_name"];
                } else {
                    $search_name = "";
                }
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 5;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Author::get_data_according_to_search_name($search_name));
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "author" . DIRECTORY_SEPARATOR . "author_management.php",
                        "authors" => Author::get_data_according_to_search_name_for_each_page($search_name, $start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
        }
    }

    public function publisher($action)
    {
        switch ($action) {
            case "index":
                $search_name = "";
                if (isset($_POST["search"])) {
                    $search_name = $_POST["search_name"];
                } else {
                    $search_name = "";
                }
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 5;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Publisher::get_data_according_to_search_name($search_name));
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "publisher" . DIRECTORY_SEPARATOR . "publisher_management.php",
                        "publishers" => Publisher::get_data_according_to_search_name_for_each_page($search_name, $start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "add":
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "publisher" . DIRECTORY_SEPARATOR . "publisher_add.php",
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_add":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Publisher::insert($request),
                    ]
                );
                $this->view->render();
                break;
            case "update":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $publisher_id = explode("=", explode("/", $_GET["url"])[3])[1];
                }
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "publisher" . DIRECTORY_SEPARATOR . "publisher_update.php",
                        "publisher" => Publisher::get_publisher_for_filter($publisher_id),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_update":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Publisher::update($request),
                    ]
                );
                $this->view->render();
                break;
            case "do_remove":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Publisher::remove($request["publisher_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "do_mass_remove":
                $request = $_POST;
                $message = "";
                if (!empty($request["mass_remove_list"])) {
                    foreach ($request["mass_remove_list"] as $remove_list) {
                        $message .= Publisher::remove($remove_list);
                    }
                } else {
                    $message = "You have yet selected any product to delete.";
                }
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => $message,
                    ]
                );
                $this->view->render();
                break;
            case "do_delete":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Publisher::delete($request["publisher_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "restore":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Publisher::get_data_for_restore());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "publisher" . DIRECTORY_SEPARATOR . "publisher_restore.php",
                        "publishers" => Publisher::get_data_for_restore_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_restore":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Publisher::restore($request["publisher_id"]),
                    ]
                );
                $this->view->render();
                break;
            default:
                $search_name = "";
                if (isset($_POST["search"])) {
                    $search_name = $_POST["search_name"];
                } else {
                    $search_name = "";
                }
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 5;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Publisher::get_data_according_to_search_name($search_name));
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "publisher" . DIRECTORY_SEPARATOR . "publisher_management.php",
                        "publishers" => Publisher::get_data_according_to_search_name_for_each_page($search_name, $start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
        }
    }
    public function coupon($action)
    {
        switch ($action) {
            case "index":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Coupon::get_all_data());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "coupon" . DIRECTORY_SEPARATOR . "coupon_management.php",
                        "coupons" => Coupon::get_data_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "add":
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "coupon" . DIRECTORY_SEPARATOR . "coupon_add.php",
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_add":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Coupon::insert($request),
                    ]
                );
                $this->view->render();
                break;
            case "update":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $coupon_id = explode("=", explode("/", $_GET["url"])[3])[1];
                }
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "coupon" . DIRECTORY_SEPARATOR . "coupon_update.php",
                        "coupon" => Coupon::get_a_coupon($coupon_id),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_update":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Coupon::update($request),
                    ]
                );
                $this->view->render();
                break;
            case "do_remove":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Coupon::remove($request["coupon_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "do_mass_remove":
                $request = $_POST;
                $message = "";
                if (!empty($request["mass_remove_list"])) {
                    foreach ($request["mass_remove_list"] as $remove_list) {
                        $message .= Coupon::remove($remove_list);
                    }
                } else {
                    $message = "You have yet selected any product to delete.";
                }
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => $message,
                    ]
                );
                $this->view->render();
                break;
            case "do_delete":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Coupon::delete($request["coupon_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "restore":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Coupon::get_data_for_restore());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "coupon" . DIRECTORY_SEPARATOR . "coupon_restore.php",
                        "coupons" => Coupon::get_data_for_restore_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_restore":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Coupon::restore($request["coupon_id"]),
                    ]
                );
                $this->view->render();
                break;
            default:
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Coupon::get_all_data());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "coupon" . DIRECTORY_SEPARATOR . "coupon_management.php",
                        "coupons" => Coupon::get_data_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
        }
    }
    public function user($action)
    {
        switch ($action) {
            case "index":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(User::get_all_data());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "user" . DIRECTORY_SEPARATOR . "user_management.php",
                        "users" => User::get_data_for_each_page($start_record, $number_of_record_per_page),
                        "wards" => Ward::get_all_data(),
                        "districts" => District::get_all_data(),
                        "provinces" => Province::get_all_data(),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "update":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $user_id = explode("=", explode("/", $_GET["url"])[3])[1];
                }
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "user" . DIRECTORY_SEPARATOR . "user_details.php",
                        "user" => User::get_an_user($user_id),
                        "wards" => Ward::get_all_data(),
                        "districts" => District::get_all_data(),
                        "provinces" => Province::get_all_data(),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "restore":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(User::get_data_for_restore());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "user" . DIRECTORY_SEPARATOR . "user_restore.php",
                        "users" => User::get_data_for_restore_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_restore":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => User::restore($request["user_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "do_remove":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => User::remove($request["user_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "do_mass_remove":
                $request = $_POST;
                $message = "";
                if (!empty($request["mass_remove_list"])) {
                    foreach ($request["mass_remove_list"] as $remove_list) {
                        $message .= User::remove($remove_list);
                    }
                } else {
                    $message = "You have yet selected any user to delete.";
                }
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => $message,
                    ]
                );
                $this->view->render();
                break;
            case "do_grant_rights":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => User::grant_right_for_user($request),
                    ]
                );
                $this->view->render();
                break;
            default:
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(User::get_all_data());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "user" . DIRECTORY_SEPARATOR . "user_management.php",
                        "users" => User::get_data_for_each_page($start_record, $number_of_record_per_page),
                        "wards" => Ward::get_all_data(),
                        "districts" => District::get_all_data(),
                        "provinces" => Province::get_all_data(),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
        }
    }
    public function order($action)
    {
        switch ($action) {
            case "index":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Order::get_all_undone_orders());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "order" . DIRECTORY_SEPARATOR . "order_management.php",
                        "orders" => Order::get_undone_order_for_each_page($start_record, $number_of_record_per_page),
                        "users" => User::get_all_data(),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "details":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $order_id = explode("=", explode("/", $_GET["url"])[3])[1];
                }
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "order" . DIRECTORY_SEPARATOR . "order_details.php",
                        "categories" => Category::get_all_data(),
                        "publishers" => Publisher::get_all_data(),
                        "authors" => Author::get_all_data(),
                        "total_cost" => Cart::get_total_cost(),
                        "get_all_carts" => Book::get_all_carts(),
                        "users" => User::get_all_data(),
                        "order" => Order::get_an_order($order_id),
                        "order_details" => OrderDetails::get_order_details($order_id),
                        "book_order_details" => Book::get_order_details($order_id),
                        "coupons" => Coupon::get_all_data(),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "history":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Order::get_all_done_orders());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "order" . DIRECTORY_SEPARATOR . "order_history.php",
                        "orders" => Order::get_all_done_orders_for_each_page($start_record, $number_of_record_per_page),
                        "users" => User::get_all_data(),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                    ]
                );
                $this->view->render();
                break;
            case "do_remove":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Order::do_delete_order($request["order_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "do_process_order":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Order::process_order($request),
                    ]
                );
                $this->view->render();
                break;
            default:
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Order::get_all_undone_orders());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "order" . DIRECTORY_SEPARATOR . "order_management.php",
                        "orders" => Order::get_undone_order_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
        }
    }
    public function comment($action)
    {
        switch ($action) {
            case "index":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Comment::get_all_comments());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "comment" . DIRECTORY_SEPARATOR . "comment_management.php",
                        "books" => Book::get_all_books(),
                        "comments" => Comment::get_all_comments_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "reply":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $comment_id = explode("=", explode("/", $_GET["url"])[3])[1];
                }
                $comment = Comment::get_a_comment($comment_id);
                $book_id = $comment->book_id;
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "comment" . DIRECTORY_SEPARATOR . "comment_reply.php",
                        "comment" => $comment,
                        "book" => Book::get_a_book($book_id),
                        "authors" => Author::get_all_data(),
                        "publishers" => Publisher::get_all_data(),
                        "coupons" => Coupon::get_all_data(),
                        "categories" => Category::get_all_data(),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_reply":
                $_SESSION["user_id"] = 1;
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Comment::insert($request),
                    ]
                );
                $this->view->render();
                break;
            case "do_remove":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Comment::remove($request["comment_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "do_mass_remove":
                $request = $_POST;
                $message = "";
                if (!empty($request["mass_remove_list"])) {
                    foreach ($request["mass_remove_list"] as $remove_list) {
                        $message .= Comment::remove($remove_list);
                    }
                } else {
                    $message = "You have yet selected any product to delete.";
                }
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => $message,
                    ]
                );
                $this->view->render();
                break;
            case "restore":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Comment::get_all_comments_for_restore());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "comment" . DIRECTORY_SEPARATOR . "comment_restore.php",
                        "books" => Book::get_all_books(),
                        "comments" => Comment::get_all_comments_for_restore_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_restore":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => Comment::restore($request["comment_id"]),
                    ]
                );
                $this->view->render();
                break;
            default:
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(Comment::get_all_comments());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "comment" . DIRECTORY_SEPARATOR . "comment_management.php",
                        "books" => Book::get_all_books(),
                        "comments" => Comment::get_all_comments_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
        }
    }
    public function news($action)
    {
        switch ($action) {
            case "index":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(News::get_all_data());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "news" . DIRECTORY_SEPARATOR . "news_management.php",
                        "news" => News::get_data_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "add":
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "news" . DIRECTORY_SEPARATOR . "news_add.php",
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_add":
                $request = $_POST;
                $request["image"] = $_FILES["image"]["name"];
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => News::add_new_news($request),
                    ]
                );
                $this->view->render();
                break;
            case "update":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $news_id = explode("=", explode("/", $_GET["url"])[3])[1];
                }
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "news" . DIRECTORY_SEPARATOR . "news_update.php",
                        "news" => News::get_a_news($news_id),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_update":
                $request = $_POST;
                if ($_FILES["image"]["name"] != null) {
                    $request["image"] = $_FILES["image"]["name"];
                    Book::upload_image(UPLOADS . "news_image" . DIRECTORY_SEPARATOR);
                } else {
                    $request["image"] = $_POST["current_image"];
                }
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => News::update($request),
                    ]
                );
                $this->view->render();
                break;
            case "do_remove":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => News::remove($request["news_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "do_mass_remove":
                $request = $_POST;
                $message = "";
                if (!empty($request["mass_remove_list"])) {
                    foreach ($request["mass_remove_list"] as $remove_list) {
                        $message .= News::remove($remove_list);
                    }
                } else {
                    $message = "You have yet selected any product to delete.";
                }
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => $message,
                    ]
                );
                $this->view->render();
                break;
            case "do_delete":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => News::delete($request["news_id"]),
                    ]
                );
                $this->view->render();
                break;
            case "restore":
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(News::get_data_for_restore());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "news" . DIRECTORY_SEPARATOR . "news_restore.php",
                        "news" => News::get_data_for_restore_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                    ]
                );
                $this->view->render();
                break;
            case "do_restore":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => News::restore($request["news_id"]),
                    ]
                );
                $this->view->render();
                break;
            default:
                if (isset(explode("=", explode("/", $_GET["url"])[3])[1])) {
                    $current_page = explode("=", explode("/", $_GET["url"])[3])[1];
                } else {
                    $current_page = 1;
                }
                $number_of_record_per_page = 10;
                $start_record = ($current_page - 1) * $number_of_record_per_page;
                $number_of_record = count(News::get_all_data());
                $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "comment" . DIRECTORY_SEPARATOR . "comment_management.php",
                        "news" => News::get_data_for_each_page($start_record, $number_of_record_per_page),
                        "page" => $current_page,
                        "number_of_page" => $number_of_page,
                    ]
                );
                $this->view->render();
                break;
        }
    }
    public function administrator($action)
    {
        switch ($action) {
            case "index":
                $_SESSION["user_id"] = 1;
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "admin" . DIRECTORY_SEPARATOR . "admin_details.php",
                        "user" => User::get_an_user($_SESSION["user_id"]),
                        "wards" => Ward::get_all_data(),
                        "districts" => District::get_all_data(),
                        "provinces" => Province::get_all_data(),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                    ]
                );
                $this->view->render();
                break;
            case "do_update":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => User::do_update_account($request),
                    ]
                );
                $this->view->render();
                break;
            case "do_logout":
                User::do_logout();
                header("location: /DoAnTH02/Admin/");
                break;
            case "login":
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "admin/admin_login.php",
                    []
                );
                $this->view->render();
                break;
            case "do_login":
                $request = $_POST;
                $this->view(
                    "customer" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => User::admin_do_login($request),
                    ]
                );
                $this->view->render();
                break;
            default:
                $_SESSION["user_id"] = 1;
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "index.php",
                    [
                        "component" => "admin" . DIRECTORY_SEPARATOR . "admin_details.php",
                        "user" => User::get_an_user($_SESSION["user_id"]),
                        "wards" => Ward::get_all_data(),
                        "districts" => District::get_all_data(),
                        "provinces" => Province::get_all_data(),
                        "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                    ]
                );
                $this->view->render();
                break;
        }
    }
}
