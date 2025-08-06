<?php


namespace models;

use PDO;
use select\Select;

require_once '../utility_class/Select.php';
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function login($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=:email");
        $stmt->execute([":email" => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $row['email'];
                header("Location:../UserPanel/AllProductPanel.php");
                exit();
            }
        }
    }

    function loggedIn()
    {
        if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
                return true;
        }else
            return false;
    }

    function isAdmin($email,$password,$path)
    {
        $query = $this->pdo->prepare("SELECT * FROM user WHERE email=:email");
        $query->bindParam(":email", $email);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            if (password_verify($password, $row['password']) && $row['role_id'] == 2) {
                header("Location:$path");
                exit();
            }else
                echo "<p class='error'>Wrong password.</p><br>";
        }else
            echo "<p class='error'>There is no email.</p><br>";
    }

    function signUp($email, $password)
    {
        $query = $this->pdo->prepare("INSERT INTO user(email, password) VALUES(:email, :password)");
        $query->bindParam(":email", $email);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query->bindParam(":password", $hashedPassword);
        $query->execute();
    }

    function signedUp($email)
    {
        $query = $this->pdo->prepare("SELECT * FROM user WHERE email=:email");
        $query->bindParam(":email", $email);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            echo "<p class='error'>Email already exists.</p><br>";
            exit();
        }

    }

    function logout(){
        session_destroy();
    }

    function validateProfileImageAndAdd($pdo,$img,$error)
    {
        if (!empty($img)) {

            $types = ['jpg', 'png', 'jpeg'];
            if (!in_array(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION), $types)) {
                exit("<h3 class='error'>Only jpg, png, jpeg files are allowed</h3>");
            }
            $path = '../profiles/' . uniqid('prof', true) . '.' . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            if (move_uploaded_file($_FILES['img']['tmp_name'], $path)) {
                $select = new Select();
                $results = $select->fetch($pdo, 'user', 'email');
                if ($results) {
                    if (!empty($results['profile_path'])) {

                        $file = $results['profile_path'];
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                }
                $query = $pdo->prepare("UPDATE user SET profile_path=:profile WHERE email=:email");
                $query->bindParam(':profile', $path);
                $query->bindParam(':email', $_SESSION['email']);
                $query->execute();

            } else {
                exit("<h3 class='error'>$error</h3>");
            }
        }
    }

}