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
    if (isset($_GET["id"])){
      $id = $_GET["id"];
    } else {
      $id = 441;
    }

    if (isset($_SESSION['Favourites'])){
        $favourite_list = $_SESSION['Favourites'];
    } else {
        $favourite_list = Array();
    }


    if (isset($favourite_list[$id])){
      unset($favourite_list[$id]);
    }

    $_SESSION['Favourites'] = $favourite_list;

    header("Location: view-favourites.php");
  }
?>