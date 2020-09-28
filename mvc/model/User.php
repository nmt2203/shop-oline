<?php
class User
{
    var $user_id;
    var $name;
    var $username;
    var $password;
    var $authority;
    var $address;
    var $number;
    var $status;
    var $ward_id;
    var $district_id;
    var $province_id;

    public function __construct($user_id, $name, $username, $password, $authority, $address, $number, $status, $ward_id, $district_id, $province_id)
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->authority = $authority;
        $this->address = $address;
        $this->number = $number;
        $this->status = $status;
        $this->ward_id = $ward_id;
        $this->district_id = $district_id;
        $this->province_id = $province_id;
    }
    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_user WHERE status = 1") as $row) {
            array_push($data, new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]));
        }
        return $data;
    }

    public static function get_data_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_user WHERE status = 1  LIMIT $start_record,$record_limit ") as $row) {
            array_push($data, new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]));
        }
        return $data;
    }

    public static function get_data_for_restore_for_each_page($start_record, $record_limit)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_user WHERE status = 0  LIMIT $start_record,$record_limit ") as $row) {
            array_push($data, new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]));
        }
        return $data;
    }

    public static function remove($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_user SET status = 0 WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function restore($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_user SET status = 1 WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function delete($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_user WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_user WHERE status = 0") as $row) {
            array_push($data, new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]));
        }
        return $data;
    }

    public static function grant_right_for_user($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_user SET authority = ? WHERE user_id = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["authority"], $request["user_id"]]);
    }



    public static function get_an_user($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE user_id = ?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $data = new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);
        return $data;
    }
    public static function find_account($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE username = ? AND status = 1");
        $stmt->execute([$request]);
        $user = $stmt->fetchAll();
        if ($user != null)
            return true;
        else
            return false;
    }
    public static function check_password($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE username = ? AND password = ? AND status = 1");
        $stmt->execute([$request["username"], $request["password"]]);
        $user = $stmt->fetch();
        if ($user != null)
            return true;
        else
            return false;
    }
    public static function do_login($request)
    {
        if (User::find_account($request["username"])) {
            $config = include CONFIG . "config.php";
            $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
            $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE username = ? AND password = ?");
            $stmt->execute([$request["username"], $request["password"]]);
            $user = $stmt->fetch();
            // print_r($user);
            if (User::check_password($request)) {
                $row = $user;
                if ($user["status"] == 1) {
                    $_SESSION["user_id"] = $row["user_id"];
                    $_SESSION["user_username"] = $row["username"];
                    $_SESSION["user_name"] = $row["name"];
                    $_SESSION["user_authority"] = $row["authority"];
                } else {
                    return "This account is deactivated!";
                }
                return "Ok";
            } else {
                return "Wrong password!";
            }
        } else {
            return "This account doesn't exist!";
        }
    }
    public static function admin_do_login($request)
    {
        if (User::find_account($request["username"])) {
            $config = include CONFIG . "config.php";
            $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
            $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE username = ? AND password = ? AND authority = 1");
            $stmt->execute([$request["username"], $request["password"]]);
            $user = $stmt->fetch();
            // print_r($user);
            if (User::check_password($request)) {
                $row = $user;
                if ($row["authority"] == 1) {
                    if ($user["status"] == 1) {
                        $_SESSION["user_id"] = $row["user_id"];
                        $_SESSION["user_username"] = $row["username"];
                        $_SESSION["user_name"] = $row["name"];
                        $_SESSION["user_authority"] = $row["authority"];
                    } else {
                        return "This account is deactivated!";
                    }
                    return "";
                }
                else {
                    return "this account is not an administrator";
                }
            } else {
                return "Wrong password!";
            }
        } else {
            return "This account doesn't exist!";
        }
    }
    public static function do_logout()
    {
        session_unset();
        session_destroy();
    }
    public static function insert($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_user (name,username,password,authority,address,number,status,ward_id,district_id,province_id) VALUES (?,?,?,?,?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["username"], $request["password"], 0, $request["address"], $request["number"], 1, $request["ward_id"], $request["district_id"], $request["province_id"]]);
    }

    public static function do_register($request)
    {
        if (User::find_account($request["username"])) {
            return "This username has already been used!";
        } else {
            if ($request["password"] != $request["re_password"]) {
                return "The two password don't match";
            } else {
                User::insert($request);
                return "Ok";
            }
        }
    }

    public static function do_update_account($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_user SET name = ?, address = ? , number = ? ,ward_id = ? , district_id = ? , province_id = ? WHERE user_id = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["address"], $request["number"], $request["ward_id"], $request["district_id"], $request["province_id"], $request["user_id"]]);
    }

    public static function change_password($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        if (User::check_password($request)) {
            $sql = "UPDATE tbl_user SET password = ? WHERE user_id = ? ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$request["new_password"], $request["user_id"]]);
            return 'Ok';
        } else {
            return "Old password isn't correct!";
        }
    }


    // public static function do_change_status($request)
    // {
    //     $config = include CONFIG . "config.php";
    //     $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
    //     $sql = "UPDATE tbl_user SET status = ? WHERE user_id = ? ";
    //     $stmt = $pdo->prepare($sql);
    //     $stmt->execute([$request["status"], $request["user_id"]]);
    // }
}
