<?php
/**
 * Bardia Parmoun
 */

// Collection of functions to deal with SQL database
/**
 * Sets a connection with the database.
 * @param values: the connection parameters.
 * @return pdo object.
 */
function setConnectionInfo($values=array()) {
      // your code goes here
      try {
        if (count($values) == 3){
            $pdo = new PDO($values[0], $values[1], $values[2]);
        } else {
            $pdo = new PDO(DBCONNECTION, DBUSER, DBPASS);
        }

        return $pdo;

      }  catch (PDOException $e){
        die ($e->getMessage());
      }
}

/**
 * Runs a query with optional parameters.
 * @param pdo the pdo object of the database.
 * @param sql the sql query to run.
 * @param parameters: the optional parameters for the param.
 * @return result the result of the query.
 */
function runQuery($pdo, $sql, $parameters=array())     {
    // your code goes here
    try {
        $statement = $pdo->prepare($sql);
        $i = 1;

        foreach ($parameters as $param){
            $statement->bindValue($i, $param);
            $i++;
        }


        $statement->execute();
  
        return $statement;
    }  catch (PDOException $e){
        die ($e->getMessage());
    }
}

/**
 * Gets all the paintings with their artists, galleries and shapes
 * @param artist the artist of the painting
 * @param museum where the painting is located
 * @param shape the shape of the painting
 * @return paintings all the paintings that match this criteria.
 */
function fetchPaintings($artist = "", $museum = "", $shape = ""){
    $sql = "SELECT * FROM paintings NATURAL JOIN artists NATURAL JOIN shapes NATURAL JOIN galleries WHERE";

    $filters = "";

    if ($artist == "" || $artist == "Select Artist"){
        $artist = true;
        $sql = $sql." ? AND";
    } else {
        $filters = $filters." ARTIST = '".$artist."'";
        $sql = $sql." LastName = ? AND";
    }

    if ($museum == "" || $museum == "Select Museum"){
        $museum = true;
        $sql = $sql." ? AND";
    } else {
        $filters = $filters." MUSEUM = '".$museum."'";
        $sql = $sql." GalleryName = ? AND";
    }

    if ($shape == "" || $shape == "Select Shape"){
        $shape = true;
        $sql = $sql." ?";
    } else {
        $filters = $filters." SHAPE = '".$shape."'";
        $sql = $sql." ShapeName = ?";
    }

    if ($filters == ""){
      echo '<h4> ALL PAINTINGS [TOP 20] </h4>';
    } else {
      echo '<h4> PAINTINGS FILTERED BY'.$filters.'<br/> [TOP 20] </h4>';
    }

    $sql = $sql." ORDER BY YearOfWork LIMIT 20;";

    $pdo = setConnectionInfo();
    $result = runQuery($pdo, $sql, Array($artist, $museum, $shape));
    $pdo = null;

    $rows = $result->fetchAll();
    $paintings = Array();
    foreach($rows as $row){
        $paintings[] = new Painting($row);
    }

    return $paintings;
  }

  /**
   * Grabs all the artist lastnames.
   * @return artists the lastnames of all the artists.
   */
  function fetchArtists(){
    $sql = "SELECT LastName FROM artists ORDER BY LastName";
    $pdo = setConnectionInfo();
    $result = runQuery($pdo, $sql);
    $pdo = null;
  
    $rows = $result->fetchAll();
    $artists = Array();
    foreach($rows as $row){
        $artists[] = new Artist($row);
    }
  
    return $artists;
  }

 /**
   * Grabs all the gallery names.
   * @return galleries the name of all the galleries.
   */
  function fetchMuseums(){
    $sql = "SELECT GalleryName FROM galleries ORDER BY GalleryName";
    $pdo = setConnectionInfo();
    $result = runQuery($pdo, $sql);
    $pdo = null;
    
    $rows = $result->fetchAll();
    $galleries = Array();
    foreach($rows as $row){
        $galleries[] = new Gallery($row);
    }
    
    return $galleries;
  }

  /**
   * Grabs all the shape names.
   * @return shapes the name of all the shapes.
   */
  function fetchShapes(){
    $sql = "SELECT ShapeName FROM shapes ORDER BY ShapeName";
    $pdo = setConnectionInfo();
    $result = runQuery($pdo, $sql);
    $pdo = null;
      
    $rows = $result->fetchAll();
    $shapes = Array();
    foreach($rows as $row){
        $shapes[] = new Shape($row);
    }
      
    return $shapes;
  }


  /**
   * Gets the information about the painting using its id.
   * @param id the id of the painting
   * @return Painting the painting object.
   */
  function getPaintingById($id){
    $sql = "SELECT * FROM paintings NATURAL JOIN artists NATURAL JOIN shapes NATURAL JOIN galleries WHERE paintingID = ?";

    $pdo = setConnectionInfo();
    $result = runQuery($pdo, $sql, Array($id));
    $pdo = null;
    
    return new Painting($result->fetch());
  }

  /**
   * Gets all the genres for the painting id.
   * @param id the painting id.
   * @return genres list of the painting genres.
   */
  function findPaintingGenres($id){
    $sql = "SELECT * FROM paintings NATURAL JOIN paintinggenres INNER JOIN genres on paintinggenres.GenreID = genres.GenreID WHERE paintings.PaintingID = ?";
      
    $pdo = setConnectionInfo();
    $result = runQuery($pdo, $sql, Array($id));
    $pdo = null;
    
    $rows = $result->fetchAll();
    $genres = Array();
    foreach($rows as $row){
        $genres[] = new Genre($row);
    }
      
    return $genres;  
  }

  /**
   * Gets all the subjects for the painting id.
   * @param id the painting id.
   * @return subjects list of the painting subjects.
   */
  function findPaintingSubjects($id){
    $sql = "SELECT * FROM paintings NATURAL JOIN paintingsubjects INNER JOIN subjects on paintingsubjects.SubjectID = subjects.SubjectID WHERE paintings.PaintingID = ?";
    
    $pdo = setConnectionInfo();
    $result = runQuery($pdo, $sql, Array($id));
    $pdo = null;
      
    $rows = $result->fetchAll();
    $subjects = Array();
    foreach($rows as $row){
        $subjects[] = new Subject($row);
    }

    return $subjects;
  }

  /**
   * Gets all the frame types.
   * @return frames different frame types.
   */
  function getFrameTypes(){
    $sql = "SELECT Title, Price FROM typesframes ORDER BY FrameID";
    
    $pdo = setConnectionInfo();
    $result = runQuery($pdo, $sql);
    $pdo = null;
        
    $rows = $result->fetchAll();
    $frames = Array();
    foreach($rows as $row){
        $frames[] = new Frame($row);
    }
  
    return $frames;
  }

  /**
   * Gets all the glass types.
   * @return glasses different glass types.
   */
  function getGlassTypes(){
    $sql = "SELECT Title, Price FROM typesglass ORDER BY GlassID";
    
    $pdo = setConnectionInfo();
    $result = runQuery($pdo, $sql);
    $pdo = null;
        
    $rows = $result->fetchAll();
    $glasses = Array();
    foreach($rows as $row){
        $glasses[] = new Glass($row);
    }
  
    return $glasses;
  }

  /**
   * Gets all the matt types.
   * @return matts different matt types.
   */
  function getMattTypes(){
    $sql = "SELECT Title, ColorCode FROM typesmatt ORDER BY MattID";
    
    $pdo = setConnectionInfo();
    $result = runQuery($pdo, $sql);
    $pdo = null;
        
    $rows = $result->fetchAll();
    $matts = Array();
    foreach($rows as $row){
        $matts[] = new Matt($row);
    }
  
    return $matts;
  }

  /**
   * Gets all the reivews for the painting.
   * @param id the painting id.
   * @return reviews list of the painting reviews.
   */
  function getReviews($id){
    $sql = "SELECT * FROM reviews WHERE PaintingID = ?";
      
    $pdo = setConnectionInfo();
    $result = runQuery($pdo, $sql, Array($id));
    $pdo = null;

    $rows = $result->fetchAll();
    $reviews = Array();
    foreach($rows as $row){
        $reviews[] = new Review($row);
    }  

    return $reviews;
  }

  /**
   * Gets all the reivews for the painting.
   * @param id the painting id.
   * @return rating the avg rating of the painting.
   */
  function getAvgReview($id){
    $sql = "SELECT AVG(Rating) FROM reviews GROUP BY PaintingID HAVING PaintingID = ?";
      
    $pdo = setConnectionInfo();
    $result = runQuery($pdo, $sql, Array($id));
    $pdo = null;

    $rating = $result->fetch();
    return round($rating[0], 0);
  }      
?>
