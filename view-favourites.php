<?php
  /**
   * Bardia Parmoun
   */

  require_once('includes/header.inc.php');
  require_once('includes/art-config.inc.php');
  require_once('includes/database.inc.php');
  require_once('includes/classes.inc.php');
?>

<section class="eleven wide column">
  <h1 class="ui header">Paintings</h1>
  <ul class="ui divided items" id="paintingsList">

  <?php 
    
    if (isset($_SESSION['Favourites'])){
        $favourte_list = $_SESSION['Favourites'];

        foreach($favourte_list as $painting){
            echo '
                <li class="item">
                <a class="ui small image" href="single-painting.php?id='.$painting[0].'"><img src="images/art/works/square-medium/'.$painting[1].'.jpg"></a>
                <div class="content">
                <a class="header" href="single-painting.php?id='.$painting[0].'">'.$painting[2].'</a>     
                <div class="extra">
                    <a class="ui icon orange button" href="cart.php?id='.$painting[0].'"><i class="add to cart icon"></i></a>
                    <a class="ui icon button" href="remove-favourites.php?id='.$painting[0].'">
                        Remove From Favourites
                    </a>
                </div>        
                </div>      
            </li>';
        }
    }
  ?> 

  </ul>        
</section>  
