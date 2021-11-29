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

    // Checks to see if one painting should be removed.
    if ($id == -1) {
      $favourite_list = Array();
    } else {
      // Removing an individual painting.
      if (isset($_SESSION['Favourites'])){
          $favourite_list = $_SESSION['Favourites'];
      } else {
          $favourite_list = Array();
      }

      if (isset($favourite_list[$id])){
        unset($favourite_list[$id]);
      }  
    }

    // Setting up the new favourites list.
    $_SESSION['Favourites'] = $favourite_list;

    header("Location: view-favourites.php");
  }
?>