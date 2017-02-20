<?php
session_start();


require_once "functions.php";
include_once './includes/header.php';
?>

<div class="login-window"> <?php

if (empty($_SESSION)) { ?>
  <p class="error">Du är inte inloggad</p> <?php
}

// Welcome
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) { ?>
    <h2>Välkommen, <?php echo ucfirst($_SESSION["firstname"]); ?>!</h2> <?php
    if (isset($_SESSION["profilepic"]) && $_SESSION["profilepic"] != NULL ) { ?>
        Din nuvarande profilbild: <br>
        <img class="profilepic" src="<?php echo $_SESSION["profilepic"]; ?>" alt="Profilbild">
        <h3>Ladda upp en ny profilbild</h3>
        <?php
    } else { ?>
      <h3>Ladda upp en profilbild</h3> <?php
    }

    // specify the folder and name for the pic
    if (isset($_POST["upload"]) ) {
        $target_folder = "userpics/";
        $filetype = ".".substr($_FILES["profile_pic"]["type"], 6);

        // create file name: user-#.jpg
        $target_name = $target_folder . basename("user-".$_SESSION["userid"].$filetype);
        // allow filesize up to 10mb
        if ($_FILES["profile_pic"]["size"] > 10000000) { ?>
            <p class="error">Filen är för stor, bilden får vara max 10 mb </p> <?php
            exit;
        }

        // check the file extension
        $type = pathinfo($target_name, PATHINFO_EXTENSION);
        if ($type != "jpeg" && $type != "jpg" && $type != "png") { ?>
            <p class="error">Endast JPG, JPEG och PNG-filer är tillåtna.</p> <?php
        }

        // Move the file from temp to folder: userpics
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_name) ) {
            connectDB();
            $query = "UPDATE users SET profilepic_url ='{$target_name}' WHERE id = '{$_SESSION["userid"]}'";
            $stmt = $conn->stmt_init();
            // update profilepic on page
            $_SESSION["profilepic"] = $target_name;
            //header("Refresh:0");
            if ($stmt->prepare($query)) {
                $stmt->execute();
            } else {
              echo mysqli_error();
            }
        // close connections
        $stmt->close();
        $conn->close();
        } else {
          echo "Ett fel har uppstått, bilden har inte laddats upp!";
        }
    } ?>
  <!-- UPLOAD PROFILE PIC -->
  <form method="post" enctype="multipart/form-data">
  <input type="file" name="profile_pic">
  <input type="submit" name="upload" value="Ladda upp bild">
  </form> <?php
} ?>
</div> <!-- /login-window -->

</body>
</html>
