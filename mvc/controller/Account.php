<?php
class Account extends Controller
{
    public function index()
    {
        if (isset($_SESSION["user_id"])) {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "personal_imformation.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "user" => User::get_an_user($_SESSION["user_id"]),
                    "province" => Province::get_all_data(),
                    "district" => District::get_all_data(),
                    "ward" => Ward::get_all_data(),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
        } else {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "error.php",
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
        }
        $this->view->render();
    }

    public function order_details($id)
    {
        if (isset($_SESSION["user_id"])) {
            $param = explode("=", $id);
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "personal_order_details.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts(),
                    "user" => User::get_an_user($_SESSION["user_id"]),
                    "order" => Order::get_an_order($param[1]),
                    "order_details" => OrderDetails::get_order_details($param[1]),
                    "book_order_details" => Book::get_order_details($param[1]),
                    "coupons" => Coupon::get_all_data()
                ]
            );
        } else {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "error.php",
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
        }
        $this->view->render();
    }

    public function do_change_imformation()
    {
        $request = $_POST;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "test.php",
            [
                "message" => User::do_update_account($request),
            ]
        );
        $this->view->render();
    }

    public function order_list($page)
    {
        if (isset($_SESSION["user_id"])) {
            $param = explode("=", $page);
            $current_page = $param[1];
            $number_of_order_per_page = 12;
            $start_record = ($current_page - 1) * $number_of_order_per_page;
            $number_of_order = count(Order::get_all_undone_orders_each_customer($_SESSION["user_id"]));
            $number_of_page = ceil($number_of_order / $number_of_order_per_page);

            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "personal_order.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "user" => User::get_an_user($_SESSION["user_id"]),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts(),
                    "orders" => Order::get_undone_order_for_each_page_each_customer($_SESSION["user_id"], $start_record, $number_of_order_per_page),
                    $param[0] => $param[1],
                    "number_of_page" => $number_of_page,
                ]
            );
        } else {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "error.php",
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
        }
        $this->view->render();
    }

    public function do_delete_order()
    {

        $request = $_POST;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "test.php",
            [
                "message" => Order::do_delete_order($request["order_id"]),
            ]
        );
        $this->view->render();
    }

    public function transaction_history($page)
    {
        if (isset($_SESSION["user_id"])) {

            $param = explode("=", $page);
            $current_page = $param[1];
            $number_of_order_per_page = 12;
            $start_record = ($current_page - 1) * $number_of_order_per_page;
            $number_of_order = count(Order::get_all_done_orders_each_customer($_SESSION["user_id"]));
            $number_of_page = ceil($number_of_order / $number_of_order_per_page);

            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "personal_history.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "user" => User::get_an_user($_SESSION["user_id"]),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts(),
                    "orders" => Order::get_all_done_orders_for_each_page_each_customer($_SESSION["user_id"], $start_record, $number_of_order_per_page),
                    $param[0] => $param[1],
                    "number_of_page" => $number_of_page,
                ]
            );
        } else {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "error.php",
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
        }
        $this->view->render();
    }

    public function comment_list($page)
    {
        if (isset($_SESSION["user_id"])) {
            $param = explode("=", $page);
            $current_page = $param[1];
            $number_of_record_per_page = 12;
            $start_record = ($current_page - 1) * $number_of_record_per_page;
            $number_of_record = count(Comment::get_all_comments_of_an_user($_SESSION["user_id"]));
            $number_of_page = ceil($number_of_record / $number_of_record_per_page);
            // print_r(Book::get_all_comments($_SESSION["user_id"]));
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "personal_comment.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "user" => User::get_an_user($_SESSION["user_id"]),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts(),
                    "comments" => Comment::get_all_comments_of_an_user_for_each_page($_SESSION["user_id"], $start_record, $number_of_record_per_page),
                    "books" => Book::get_all_comments($_SESSION["user_id"]),
                    "number_of_page" => $number_of_page,
                    "page" => $current_page
                ]
            );
        } else {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "error.php",
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
        }
        $this->view->render();
    }

    public function change_password()
    {
        if (isset($_SESSION["user_id"])) {

            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "personal_change_password.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "user" => User::get_an_user($_SESSION["user_id"]),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()

                ]
            );
        } else {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "error.php",
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
        }
        $this->view->render();
    }

    public function do_change_password()
    {
        $request = $_POST;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "test.php",
            [
                "message" => User::change_password($request),
            ]
        );
        $this->view->render();
    }
}
