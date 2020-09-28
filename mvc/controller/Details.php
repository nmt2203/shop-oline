<?php
class Details extends Controller
{

    public function index($id)
    {
        $book_id = explode("=", $id)[1];
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "customer" . DIRECTORY_SEPARATOR . "details.php",
                "book" => Book::get_a_book($book_id),
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "average_score" => Rating::average_score_of_a_book($book_id),
                "all_rating_reviews" => Rating::count_all_reviews_of_a_book($book_id),
                "comments" => Comment::get_all_comments_of_a_book($book_id),
                // "all_first_comments" => Comment::get_all_first_comments_of_a_book($book_id),
                "users" => User::get_all_data(),
                "coupons" => Coupon::get_all_data(),
                "display_comments" => Comment::display_all_comments($book_id),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }
    public function rating($id, $score)
    {
        $book_id = explode("=", $id)[1];
        $rating = explode("=", $score)[1];
        Rating::insert($book_id, $rating);
        header("Location: /DoAnTh02/Details/index/id=$book_id/");
    }

    public function add_comment()
    {
        $request = $_POST;
        // $book_id = $request["book_id"];
        // Comment::insert($request);
        // header("Location: /DoAnTh02/Details/index/id=$book_id/");
        $request = $_POST;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "test.php",
            [
                "message" => Comment::insert($request),
            ]
        );
        $this->view->render();
    }

}
