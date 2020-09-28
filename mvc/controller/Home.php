<?php
class Home extends Controller
{

    public function index()
    {
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "main_page.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts(),
                "most_sale" => Book::sort_selling(5),
                "most_rate" =>  Book::sort_rating(5),
                "newest_update" => Book::sort_date(0, 4),
                "coupons" => Coupon::get_all_data(),
                "news" => News::get_all_data(),
            ]
        );
        $this->view->render();
    }

    public function news($page)
    {
        $param = explode("=", $page);
        $current_page = $param[1];
        $number_of_record_per_page = 12;
        $start_record = ($current_page - 1) * $number_of_record_per_page;
        $number_of_record = count(News::get_all_data());
        $number_of_page = ceil($number_of_record / $number_of_record_per_page);
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "news_display.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts(),
                "news" => News::get_data_for_each_page($start_record, $number_of_record_per_page),
                "page" => $current_page,
                "number_of_page" => $number_of_page,
            ]
        );
        $this->view->render();
    }

    public function news_details($id)
    {
        $param = explode("=", $id);
        // print_r(News::get_a_news($param[1]));
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "news_details.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts(),
                "news" => News::get_a_news($param[1]),
            ]
        );
        $this->view->render();
    }

    public function login()
    {
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "login.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function do_login()
    {
        $request = $_POST;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "test.php",
            [
                "message" => User::do_login($request),
            ]
        );
        $this->view->render();
    }

    public function do_logout()
    {
        User::do_logout();
        header("Location: /DoAnTH02/Home/index/");
    }

    public function register()
    {
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "register.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "province" => Province::get_all_data(),
                "district" => District::get_all_data(),
                "ward" => Ward::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function get_district()
    {
        $request = $_POST;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "get_district.php",
            [
                "all_districts" => District::get_all_district_of_a_province($request["province_id"]),
            ]
        );
        $this->view->render();
    }

    public function get_ward()
    {
        $request = $_POST;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "get_ward.php",
            [
                "all_wards" => Ward::get_all_wards_of_a_district($request["district_id"]),
            ]
        );
        $this->view->render();
    }

    public function do_register()
    {
        $post = $_POST;
        $request = $post;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "test.php",
            [
                "message" => User::do_register($request),
            ]
        );
        $this->view->render();
    }

    public function introduction()
    {   
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "introduction.php",
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }
}
