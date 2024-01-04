<?php 
session_start();
require 'functions.php';

if ( isset($_COOKIE['id']) && isset($_COOKIE['key']) ){
 
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn,"SELECT username FROM user WHERE id = $id");

    $row = mysqli_fetch_assoc($result);


    if ( $key === hash('sha256', $row['username']) ){
        $_SESSION['login'] = true;
    }


}


if (isset($_SESSION["login"])){
    header("location: index.php");
    exit;
}


if (isset($_POST["login"])){
    
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if ( mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"])){

            $_SESSION["login"] = true;

            if (  isset($_POST["remember"]) ){

                setcookie( 'id', $row['id'], time() + 60 );
                setcookie( 'key', hash( 'sha256', $row['username']), time() + 60);
            }

            header("location: index.php");
            exit;
        }

    }

    $error = true;

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman LOGIN</title>
    <style>

        :root{

            --font-color : #EFAE6A;

        }

        body{

            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.dev/svgjs' width='1440' height='765' preserveAspectRatio='none' viewBox='0 0 1440 765'%3e%3cg mask='url(%26quot%3b%23SvgjsMask1019%26quot%3b)' fill='none'%3e%3crect width='1440' height='765' x='0' y='0' fill='rgba(240%2c 239%2c 234%2c 1)'%3e%3c/rect%3e%3cpath d='M 0%2c86 C 57.6%2c127 172.8%2c293.2 288%2c291 C 403.2%2c288.8 460.8%2c69.6 576%2c75 C 691.2%2c80.4 748.8%2c305 864%2c318 C 979.2%2c331 1036.8%2c150.6 1152%2c140 C 1267.2%2c129.4 1382.4%2c240 1440%2c265L1440 765L0 765z' fill='rgba(239%2c 174%2c 106%2c 1)'%3e%3c/path%3e%3cpath d='M 0%2c666 C 96%2c615.2 288%2c419.6 480%2c412 C 672%2c404.4 768%2c624.8 960%2c628 C 1152%2c631.2 1344%2c468 1440%2c428L1440 765L0 765z' fill='rgba(214%2c 93%2c 64%2c 1)'%3e%3c/path%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1019'%3e%3crect width='1440' height='765' fill='white'%3e%3c/rect%3e%3c/mask%3e%3c/defs%3e%3c/svg%3e");

        }

        p{
            color: red;
            font-size: large;
            font-weight: bold;
            font-family: sans-serif;
        }

        h1{
            font-family: sans-serif;
            text-align: center;
            color: #EFAE6A ;
        }

        form{
            position: absolute;
            width:350px;
            height: 350px;
            background-color: #F0EFEA;
            padding: 12px 20px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 20px;
            box-shadow: 6px 6px 6px 4px #3D3B40;
        }
        form ul li{
            list-style: none;
            
        }

        .formelement{

            width: 90%;
            background-color: transparent;
            margin: 20px 0px;
            border: none;
            outline: none;
            border: 2px solid #EFAE6A;
            border-radius: 40px;
            padding: 10px;

        }

        button{

            width: 100%;
            margin-top: 25px;
            height: 45px;
            border: none;
            outline: none;
            background-color: #EFAE6A ;
            border-radius: 40px;
            color: white;

        }

        button:hover {

            background-color: #C68E54;

        }

        .remember{

            color:var(--font-color);

        }

    </style>
</head>
<body>



    <form action="" method="post">
        <h1>LOGIN ADMIN</h1>
            <div>
                <label for="username"></label>
                <input type="text" name="username" id="username"  class="formelement" placeholder="username">
            </div>
                
            <div>
                <label for="password"></label>
                <input type="password" name="password" id="password"  class="formelement" placeholder="password">
            </div>
                
            
            <div>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" class="remember">Remember Me?</label>
            </div>
                
            
            <button type="submit" name="login">LOGIN</button>
        </ul>
    </form>

    <?php if ( isset($error) ) : ?>
        <p>username atau password salah</p>
    <?php endif; ?>
    
</body>
</html>