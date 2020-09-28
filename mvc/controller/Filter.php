<?php
class Filter extends Controller
{
    public function index()
    {
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "error.php",
            ]
        );
        $this->view->render();
    }

    public function according_to_category($id, $page)
    {

        $category_id =  explode("=", $id)[1];
        $current_page = explode("=", $page)[1];
        $number_of_book_per_page = 12;
        $start_record = ($current_page - 1) * $number_of_book_per_page;
        $number_of_book = Book::count_book_according_to_category($category_id);
        $number_of_page = ceil($number_of_book / $number_of_book_per_page);

        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "filter_category.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "count_book_of_each_category" => Book::count_book_of_each_category(),
                "selected_category" => Category::get_category_for_filter($category_id),
                "books" => Book::get_data_according_to_category($category_id, $start_record, $number_of_book_per_page),
                "page" => $current_page,
                explode("=", $id)[0] => $category_id,
                explode("=", $page)[0] => explode("=", $page)[1],
                "number_of_page" => $number_of_page,
                "authors" => Author::get_all_data(),
                "coupons" => Coupon::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function according_to_author($id, $page)
    {

        $author_id =  explode("=", $id)[1];
        $current_page = explode("=", $page)[1];
        $number_of_book_per_page = 12;
        $start_record = ($current_page - 1) * $number_of_book_per_page;
        $number_of_book = Book::count_book_according_to_author($author_id);
        $number_of_page = ceil($number_of_book / $number_of_book_per_page);

        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "filter_author.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "count_book_of_each_author" => Book::count_book_of_each_author(),
                "selected_author" => Author::get_author_for_filter($author_id),
                "books" => Book::get_data_according_to_author($author_id, $start_record, $number_of_book_per_page),
                "page" => $current_page,
                explode("=", $id)[0] => $author_id,
                explode("=", $page)[0] => explode("=", $page)[1],
                "number_of_page" => $number_of_page,
                "authors" => Author::get_all_data(),
                "coupons" => Coupon::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function according_to_publisher($id, $page)
    {

        $publisher_id =  explode("=", $id)[1];
        $current_page = explode("=", $page)[1];
        $number_of_book_per_page = 12;
        $start_record = ($current_page - 1) * $number_of_book_per_page;
        $number_of_book = Book::count_book_according_to_publisher($publisher_id);
        $number_of_page = ceil($number_of_book / $number_of_book_per_page);
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "filter_publisher.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "count_book_of_each_publisher" => Book::count_book_of_each_publisher(),
                "selected_publisher" => Publisher::get_publisher_for_filter($publisher_id),
                "books" => Book::get_data_according_to_publisher($publisher_id, $start_record, $number_of_book_per_page),
                "page" => $current_page,
                explode("=", $id)[0] => $publisher_id,
                explode("=", $page)[0] => explode("=", $page)[1],
                "number_of_page" => $number_of_page,
                "authors" => Author::get_all_data(),
                "coupons" => Coupon::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function sort_a_to_z($page)
    {
        $param = explode("=", $page);
        $current_page = $param[1];
        $number_of_record_per_page = 12;
        $start_record = ($current_page - 1) * $number_of_record_per_page;
        $number_of_record = count(Book::get_all_books());
        $number_of_page = ceil($number_of_record / $number_of_record_per_page);
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "sort_page.php",
                "title" => "Sort: A to Z",
                "sort_type" => "sort_a_to_z",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "books" => Book::sort_a_to_z($start_record, $number_of_record_per_page),
                "page" => $current_page,
                "number_of_page" => $number_of_page,
                "coupons" => Coupon::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function sort_date($page)
    {
        $param = explode("=", $page);
        $current_page = $param[1];
        $number_of_record_per_page = 12;
        $start_record = ($current_page - 1) * $number_of_record_per_page;
        $number_of_record = count(Book::get_all_books());
        $number_of_page = ceil($number_of_record / $number_of_record_per_page);
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "sort_page.php",
                "sort_type" => "sort_date",
                "title" => "Sort: newest update date",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "books" => Book::sort_date($start_record, $number_of_record_per_page),
                "page" => $current_page,
                "number_of_page" => $number_of_page,
                "coupons" => Coupon::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function sort_sale_off($page)
    {
        $param = explode("=", $page);
        $current_page = $param[1];
        $number_of_record_per_page = 12;
        $start_record = ($current_page - 1) * $number_of_record_per_page;
        $number_of_record = count(Book::get_all_books());
        $number_of_page = ceil($number_of_record / $number_of_record_per_page);
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "sort_page.php",
                "sort_type" => "sort_sale_off",
                "title" => "Sort: sale off books ",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "books" => Book::sort_sale_off($start_record, $number_of_record_per_page),
                "page" => $current_page,
                "number_of_page" => $number_of_page,
                "coupons" => Coupon::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function sort_sale($page)
    {
        $param = explode("=", $page);
        $current_page = $param[1];
        $number_of_record_per_page = 12;
        $start_record = ($current_page - 1) * $number_of_record_per_page;
        $number_of_record = count(Book::get_all_books());
        $number_of_page = ceil($number_of_record / $number_of_record_per_page);
        // Book::sort_sale();
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "sort_page.php",
                "sort_type" => "sort_sale",
                "title" => "Sort: most sale books",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "books" => Book::sort_selling(count(Book::get_all_books())),
                "page" => $current_page,
                "number_of_page" => $number_of_page,
                "coupons" => Coupon::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function sort_rate($page)
    {
        $param = explode("=", $page);
        $current_page = $param[1];
        $number_of_record_per_page = 10;
        $start_record = ($current_page - 1) * $number_of_record_per_page;
        $number_of_record = count(Book::get_all_books());
        $number_of_page = ceil($number_of_record / $number_of_record_per_page);
        // Book::sort_rating(count(Book::get_all_books()));
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "sort_page.php",
                "sort_type" => "sort_rate",
                "title" => "Sort: most rating books",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "books" =>  Book::sort_rating(count(Book::get_all_books())),
                "page" => $current_page,
                "number_of_page" => $number_of_page,
                "coupons" => Coupon::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }



    public function according_to_search_name()
    {
        if (!isset($_POST["search_button"])) {
            header("location: /DoAnTH02/Home/");
        } else {
            $request = $_POST;
            $search_name = $request["search_name"];
            $current_page = $request["page"];
            $number_of_book_per_page = 12;
            $start_record = ($current_page - 1) * $number_of_book_per_page;
            $number_of_book = count(Book::get_data_according_to_search_name($search_name));
            $number_of_page = ceil($number_of_book / $number_of_book_per_page);
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "filter_search.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "books" => Book::get_data_according_to_search_name_for_each_page($search_name, $start_record, $number_of_book_per_page),
                    "page" => $current_page,
                    "search_name" => $search_name,
                    "count_book_according_to_search_name" => count(Book::get_data_according_to_search_name($search_name)),
                    "page" => $current_page,
                    "number_of_page" => $number_of_page,
                    "authors" => Author::get_all_data(),
                    "coupons" => Coupon::get_all_data(),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
            $this->view->render();
        }
    }

    public function live_search()
    {
        $request = $_POST;
        $message = "";
        if ($request["search_name"] != "" || $request["search_name"] != null) {
            $data = Book::get_data_according_to_search_name($request["search_name"]);
            // $message = '<div style="height:100px;overflow:auto;">';
            foreach ($data as $book) {
             $message .=    '<li class="list-group-item">
                                <a href="/DoAnTH02/Details/index/id='.$book->book_id.'">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img style="float:left;width:50px;height:70px;" src="http://localhost:8080/DoAnTH02/public/uploads/book_image/' . $book->image . '">
                                        </div>
                                        <div class="col-md-9">
                                            <p class="text-primary">' . $book->name . '</p>
                                            <p class="text-danger">Price :' . $book->price . '<small> vnd</small></p>
                                        </div>
                                    </div>
                                </a>
                            </li>';
            }
            // $message = '</div>';
        }
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "test.php",
            [
                "message" => $message,
            ]
        );
        $this->view->render();
    }
}
