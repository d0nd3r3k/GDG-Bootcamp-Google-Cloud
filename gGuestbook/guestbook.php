<?php
require_once 'google/appengine/api/users/UserService.php';

    use google\appengine\api\users\User;
    use google\appengine\api\users\UserService;

    $user = UserService::getCurrentUser();

    if ($user) {
        $userName = $user->getNickname();
        $userEmail = $user->getEmail();
        echo 'Hello, ' . htmlspecialchars($user->getNickname());
    }
    else {
      header('Location: ' .
             UserService::createLoginURL($_SERVER['REQUEST_URI']));
    }
?>
<html>
<head>
     <link type="text/css" rel="stylesheet" href="/css/style.css" />
</head>
  <body>
    <?php
      if (array_key_exists('content', $_POST)) {
        $message = $_POST['content'];
        //Output 
        echo "You wrote:<pre>\n";
        echo htmlspecialchars($message);
        echo "\n</pre>";
        //save inside database
        mysql_connect(":/cloudsql/organic-lacing-392:userdb", "root", "") or die(mysql_error()); 
        mysql_select_db("userdb") or die(mysql_error()); 
        $insert = mysql_query("INSERT INTO Users (name, email, message) VALUES ('$userName', '$userEmail', '$message')") or die(mysql_error());
      }
    ?>
    <form action="/sign" method="post">
      <div><textarea name="content" rows="3" cols="60"></textarea></div>
      <div><input type="submit" value="Sign Guestbook"></div>
    </form>
  </body>
</html>