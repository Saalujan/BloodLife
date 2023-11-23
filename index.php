<?php 

if (isset($_COOKIE["remember_me"])) {
   header('Location:services/loginprocess.php');

}else{  

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page in HTML with CSS</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/login.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative; 
        }

        .box-form {
            display: flex;
            flex-direction: row;
            overflow: hidden;
        }

        .left {
            flex: 1;
            background-size: cover;
            background-position: center;
            position: relative;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .left h1 {
            font-size: 36px;
        }

        .left q {
            font-size: 18px;
            margin-bottom: 20px; 
            position: absolute;
            bottom: 10px; 
        }

        
    </style>
</head>
<body>
<div class="box-form">
    <div class="left col-5">
        <div class="overlay">
            <h1>Blood Life</h1>
            
        </div>
        <!-- <div class="lines">
        <p>Hello bloods, we welcome you to our blood stock managing platform.</p>
        </div> -->
    </div>

    <div class="right">
        <h5>Login</h5>
      
        <form method="post" action="services/loginprocess.php">
            <div class="inputs">
                <input type="text" name="email"  placeholder="email">
                <br>
                <input type="password" name="password"   placeholder="password">
            </div>
            <!-- <div class="image">
                <img src="" alt="">
            </div> -->


            
            <br><br>

            <div class="remember-me--forget-password">
                
                <label class="remember">
                    <input type="checkbox" name="remember"/>
                    <span class="text-checkbox">Remember me</span>
                </label>
                
                <label class="forgot">
                <a href="HomePages/Enteryouremail.php">Forgot password?</a>
                </label>
                
            </div>

            <br>
            <button type="submit">Login</button>
        </form>


    </div>
</div>




</body>
</html>

<?php 

    }
?>