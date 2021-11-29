<?php
  /**
   * Bardia Parmoun
   */

  require_once('includes/header.inc.php');
  require_once('includes/art-config.inc.php');
  require_once('includes/database.inc.php');
  require_once('includes/classes.inc.php');

  session_start();

  if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET["id"]) && is_numeric($_GET["id"])){
      $id = $_GET["id"];
    } else {
      $id = 441;
    }

    if (isset($_SESSION['Favourites'])){
        $favourite_list = $_SESSION['Favourites'];
    } else {
        $favourite_list = Array();
    }

    $painting = getPaintingById($id);

    $favourite_list[$id] = Array($id, $painting->imageFileName, $painting->title);

    $_SESSION['Favourites'] = $favourite_list;

    header("Location: view-favourites.php");
  }
?>