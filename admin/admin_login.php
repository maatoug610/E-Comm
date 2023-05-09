<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE email = ? AND password = ?");
   $select_admin->execute([$email, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard.php');
   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<section class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <p>default username = <span>admin@</span> & password = <span>password</span></p>
      <input type="email" name="email" required placeholder="enter your email" maxlength="35"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" class="btn" name="submit">
   </form>

</section>
   
</body>
</html>
<!-- <div class="container">
    <div class="myform">
      <form action="" method="post">
        <h2>ADMIN LOGIN</h2>
        <input type="text" name="name" placeholder="Admin Name" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="pass" placeholder="Password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
        <button type="submit" name="submit">LOGIN</button>
      </form>
    </div>
    <div class="image">
      <img src="../images/admin_login_image.jpg">
    </div>
  </div> -->
