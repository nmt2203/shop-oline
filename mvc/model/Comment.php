<?php
class Comment
{
    var $comment_id;
    var $description;
    var $date;
    var $reply;
    var $book_id;
    var $user_id;
    var $status;

    public function __construct($comment_id, $description, $date, $reply, $book_id, $user_id, $status)
    {
        $this->comment_id = $comment_id;
        $this->description = $description;
        $this->date = $date;
        $this->reply = $reply;
        $this->book_id = $book_id;
        $this->user_id = $user_id;
        $this->status = $status;
    }

    public static function get_all_comments_of_an_user($request)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_comment WHERE user_id=? ORDER BY date desc");
        $stmt->execute([$request]);
        foreach ($stmt as $row) {
            array_push($data, new Comment($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]));
        }
        return $data;
    }

    public static function get_all_comments_of_an_user_for_each_page($request, $start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_comment WHERE user_id=? ORDER BY date desc LIMIT $start_record,$record_limit");
        $stmt->execute([$request]);
        foreach ($stmt as $row) {
            array_push($data, new Comment($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]));
        }
        return $data;
    }

    public static function get_all_comments_of_a_book($request)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_comment WHERE book_id=? ORDER BY date desc");
        $stmt->execute([$request]);
        foreach ($stmt as $row) {
            array_push($data, new Comment($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]));
        }
        return $data;
    }

    public static function get_all_first_comments_of_a_book($request)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_comment WHERE book_id=? AND reply = 0 ORDER BY date desc");
        $stmt->execute([$request]);
        foreach ($stmt as $row) {
            array_push($data, new Comment($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]));
        }
        return $data;
    }

    public static function get_all_first_comments()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_comment WHERE reply = 0 ORDER BY date desc");
        $stmt->execute();
        foreach ($stmt as $row) {
            array_push($data, new Comment($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]));
        }
        return $data;
    }

    public static function get_reply_of_a_comment($request)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_comment WHERE  reply = ? ORDER BY date desc");
        $stmt->execute([$request]);
        foreach ($stmt as $row) {
            array_push($data, new Comment($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]));
        }
        return $data;
    }

    public static function display_all_comments($request)
    {
        $display = "";
        foreach (Comment::get_all_first_comments_of_a_book($request) as $comments) {
            foreach (User::get_all_data() as $users) {
                if ($users->user_id == $comments->user_id) {
                    if ($comments->status == 1) {
                        $display .= '<article class="row" style="margin-top:10px;">
                <div class="col-md-2 col-sm-2 hidden-xs">
                    <figure class="thumbnail">
                        <img class="img-responsive" style="width:50%;" src="http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png" />
                        <figcaption class="text-center"> ' . $users->username . ' </figcaption>
                    </figure>
                </div>
                <div class="col-md-10 col-sm-10">
                    <div class="panel panel-default arrow left">
                        <div class="panel-body">
                            <header class="text-left">
                                <div class="comment-user"><span class="glyphicon glyphicon-user"> ' . $users->name . '</span></div>
                                <time class="comment-date" datetime="16-12-2014 01:05"><span class="glyphicon glyphicon-time"> ' . date_format(date_create($comments->date), "d/m/yy") . '</span></time>
                            </header>
                            <div class="comment-post">
                                <p>
                                ' . $comments->description . ' 
                                </p>
                            </div>
                            <div class="text-right"><a class="btn btn-primary"  href="javascript:void(0)" data-commentID="'.$comments->comment_id.'" onclick="reply(this);">Reply</a></div>
                        </div>
                    </div>
                 </div> 
             </article> ';
                    } else {
                        $display .= '<article class="row" style="margin-top:10px;">
                        <div class="col-md-2 col-sm-2 hidden-xs">
                            <figure class="thumbnail">
                                <img class="img-responsive" style="width:50%;" src="http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png" />
                                <figcaption class="text-center"> ' . $users->username . ' </figcaption>
                            </figure>
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <div class="panel panel-default arrow left">
                                <div class="panel-body">
                                    <header class="text-left">
                                        <div class="comment-user"><span class="glyphicon glyphicon-user"> ' . $users->name . '</span></div>
                                        <time class="comment-date" datetime="16-12-2014 01:05"><span class="glyphicon glyphicon-time"> ' . date_format(date_create($comments->date), "d/m/yy") . '</span></time>
                                    </header>
                                    <div class="comment-post">
                                        <p style="color:red;">
                                            This comment was removed by the administrator. 
                                        </p>
                                    </div>
                                    <div class="text-right"><a class="btn btn-primary"  href="javascript:void(0)" data-commentID="'.$comments->comment_id.'" onclick="reply(this);">Reply</a></div>
                                </div>
                            </div>
                         </div> 
                     </article> ';
                    }
                    $display .= Comment::display_reply_of_a_comment($comments->comment_id, 0);
                }
            }
        }
        return $display;
    }

    public static function display_reply_of_a_comment($request, $offset)
    {
        $display = "";
        $replies = Comment::get_reply_of_a_comment($request);
        if ($replies != null) {
            $offset = $offset + 1;
        } else {
            $offset = 0;
        }
        if ($replies != null) {
            foreach ($replies as $reply) {
                foreach (User::get_all_data() as $users) {
                    if ($users->user_id == $reply->user_id) {
                        if ($reply->status == 1) {
                            $display .= '<article class="row col-md-offset-' . $offset . '" style="margin-top:10px;" >
                    <div class="col-md-2 col-sm-2 hidden-xs">
                        <figure class="thumbnail">
                            <img class="img-responsive" style="width:50%;" src="http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png" />
                            <figcaption class="text-center"> ' . $users->username . ' </figcaption>
                        </figure>
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <div class="panel panel-default arrow left">
                            <div class="panel-body">
                                <header class="text-left">
                                    <div class="comment-user"><span class="glyphicon glyphicon-user"> ' . $users->name . '</span></div>
                                    <time class="comment-date" datetime="16-12-2014 01:05"><span class="glyphicon glyphicon-time"> ' . date_format(date_create($reply->date), "d/m/yy") . '</span></time>
                                </header>
                                <div class="comment-post">
                                    <p>
                                    ' . $reply->description . ' 
                                    </p>
                                </div>
                                <div class="text-right"><a class="btn btn-primary"  href="javascript:void(0)" data-commentID="'.$reply->comment_id.'" onclick="reply(this)">Reply</a></div>
                            </div>
                        </div>
                     </div> 
                 </article> ';
                        } else {
                            $display .= '<article class="row col-md-offset-' . $offset . '" style="margin-top:10px;" >
                            <div class="col-md-2 col-sm-2 hidden-xs">
                                <figure class="thumbnail">
                                    <img class="img-responsive" style="width:50%;" src="http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png" />
                                    <figcaption class="text-center"> ' . $users->username . ' </figcaption>
                                </figure>
                            </div>
                            <div class="col-md-10 col-sm-10">
                                <div class="panel panel-default arrow left">
                                    <div class="panel-body">
                                        <header class="text-left">
                                            <div class="comment-user"><span class="glyphicon glyphicon-user"> ' . $users->name . '</span></div>
                                            <time class="comment-date" datetime="16-12-2014 01:05"><span class="glyphicon glyphicon-time"> ' . date_format(date_create($reply->date), "d/m/yy") . '</span></time>
                                        </header>
                                        <div class="comment-post">
                                            <p style="color:red;">
                                                This comment was removed by the administrator. 
                                            </p>
                                        </div>
                                        <div class="text-right"><a class="btn btn-primary"  href="javascript:void(0)" data-commentID="'.$reply->comment_id.'" onclick="reply(this)">Reply</a></div>
                                    </div>
                                </div>
                             </div> 
                         </article> ';
                        }
                        $display .= Comment::display_reply_of_a_comment($reply->comment_id, $offset);
                    }
                }
            }
        }
        return $display;
    }

    public static function insert($request)
    {
        $date = date("yy-m-d");
        $user_id = $_SESSION["user_id"];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_comment (description,date,reply,book_id,user_id) VALUES (?,?,?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["description"], $date, $request["reply"], $request["book_id"], $user_id]);
    }

    public static function get_all_comments() {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_comment WHERE status = 1  ORDER BY date desc");
        $stmt->execute();
        foreach ($stmt as $row) {
            array_push($data, new Comment($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]));
        }
        return $data;
    }

    public static function get_all_comments_for_each_page($start_record, $record_limit) {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_comment WHERE status = 1  ORDER BY date desc LIMIT $start_record,$record_limit");
        $stmt->execute();
        foreach ($stmt as $row) {
            array_push($data, new Comment($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]));
        }
        return $data;
    }

    public static function get_all_comments_for_restore() {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_comment WHERE status = 0  ORDER BY date desc");
        $stmt->execute();
        foreach ($stmt as $row) {
            array_push($data, new Comment($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]));
        }
        return $data;
    }

    public static function get_all_comments_for_restore_for_each_page($start_record, $record_limit) {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_comment WHERE status = 0  ORDER BY date desc LIMIT $start_record,$record_limit");
        $stmt->execute();
        foreach ($stmt as $row) {
            array_push($data, new Comment($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]));
        }
        return $data;
    }

    public static function remove($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_comment SET status = 0 WHERE comment_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function restore($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_comment SET status = 1 WHERE comment_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function get_a_comment($request) {
        $comment = null;
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_comment WHERE comment_id = ?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $comment =  new Comment($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
        return $comment;
    }
}
