<?php
session_start();
require_once "functions.php";

// Check if email already registered
$already_reg = false;
if (isset($_GET["newUser"]) && $_GET["newUser"] == true) {
    $new_username = $_POST["username"];
    connectDB(); // TODO: Close connection db
    if (mysqli_fetch_assoc(mysqli_query($conn, "SELECT username FROM users WHERE username ='$new_username'")) != NULL  ) {
        header ("Location: login.php?email_registered=true");
        $already_reg = true;
        exit;
    }
}

include_once './includes/header.php';

?>
<div class="login-window">
<?php

if (isset($_POST["username"]) && $already_reg == false) {
    if (!empty($_POST["username"])  ) {
        // connection to db
        connectDB();// TODO: close db connection

        $user = sanitizeMySql($conn, $_POST["username"]);
        $pass = sanitizeMySql($conn, $_POST["password"]);
         $hPass = hashPassword($pass); // TODO: funkar detta? var bör man hasha? $hpass används inte...
        // get users first name, id & profilepic
        $get_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE username = '$user'"));
        $firstname = $get_user["firstname"];
        $userid = $get_user["id"];
        $profilepic_url = $get_user["profilepic_url"];

        //get instance of statement
        $statement = $conn->stmt_init();

        if (isset($_SESSION["loggedin"])) {
            echo "<p>Välkommen $firstname, du är inloggad!</p>";
        }

        if ($statement->prepare("SELECT * FROM users WHERE username = '{$user}'")) {
            $statement->execute();
            $statement->bind_result($id, $firstname, $lastname, $username, $password, $profilepic_url);
            $statement->fetch();
            if ($id != 0 && $password == $pass) {
                $_SESSION["logged_in"] = true;
                $_SESSION["firstname"] = $firstname;
                $_SESSION["username"] = $username;
                $_SESSION["userid"] = $userid;
                $_SESSION["profilepic"] = $profilepic_url;
                $userid = $_SESSION["username"]; //logged in user

                // TODO: close db connection


                // if NEW USER - upload profile pic
                if (isset($_GET["newUser"]) && $_GET["newUser"] == true ) { ?>
                    <h2> Välkommen <?php $firstname ?>! </h2>
                    <p> Ditt konto är nu skapat. Ladda upp en profilbild nedan. </p> <?php
                } else {
                  // if LOGIN USER - update profile pic ?>
                  <h2>Välkommen <?php echo $_SESSION["firstname"]; ?>!</h2> <?php
                  // if profilepic exists, show it
                  if ($profilepic_url != NULL) { ?>
                      <img src="<?php echo $_SESSION["profilepic"]; ?>" alt="Profilbild på <?php echo $_SESSION["username"]; ?>"> <?php
                  }
                }
                ?>
                <?php

                // TODO: hitta buggen!!!!

                if (isset($_POST["upload"]) ) {
                    echo "JA DET ÄR DEN";
                    echo "<pre>";
                    var_dump ($_FILES);
                    echo "</pre>";

                    $target_folder = "userpics/";
                    $target_name = $target_folder . basename("user-".$userid.".jpeg"); // create file name: user-#.jpeg

                    // allow filesize up to 10mb
                    if ($_FILES["profile_pic"]["size"] > 10000000) {
                        echo "Filen är för stor, bilden får vara max 10 mb.";
                        exit;
                    }

                    // check the file extension
                    $type = pathinfo($target_name, PATHINFO_EXTENSION);
                    //$type = substr($target_name, strlen($target_name)-3) //inte lika säker som den ovan
                    if ($type != "jpeg") {
                        echo "Endast JPEG-filer är tillåtna.";
                        exit;
                    }

                    // Move the file from temp to userpics folder
                    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_name) ) {
                        $conn = new mysqli("localhost", "root", "root", "inl2");
                        $query = "UPDATE users SET profilepic_url ='{$target_name}' WHERE id = '{$userid}'";
                        $stmt = $conn->stmt_init();
                        if ($stmt->prepare($query)) {
                            $stmt->execute();
                            $stmt->bind_result($id, $firstname, $lastname, $username, $password, $profilepic_url);
                            $stmt->fetch();
                            echo "test1";

                            //update profilepic
                            $_SESSION["profilepic"] = $target_name;
                            echo "test2";


                        } else {
                          echo mysqli_error();
                        }

                    } else {
                      echo "Ett fel har uppstått, bilden har inte laddats upp!";
                    }

                } else {
                  echo "Fel Användarnamn/lösenord";
                }
            }
        } else {
        echo "hej";
        }
    } else {
      echo "not set";
    }
}
  ?>

  <!-- UPLOAD PROFILE PIC -->
  <h3>Ladda upp en profilbild</h3>
  <form method="post" enctype="multipart/form-data">
    <input type="file" name="profile_pic">
    <input type="submit" name="upload" value="Ladda upp bild">
  </form>

  </div> <!-- /login-window -->

</body>
</html>
