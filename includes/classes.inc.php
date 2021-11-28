<?php
  /**
   * Bardia Parmoun
   */
  
   /**
    * The class Painting holds all the information about a single painting.
    */
    class Painting {
        public $paintingID;
        public $title;
        public $artistName;
        public $imageFileName;
        public $MSRP;
        public $excerpt;
        public $galleryName;
        public $shapeName;
        public $description;
        public $year;
        public $medium;
        public $width;
        public $height;
        public $accessionNumber;
        public $copyright;
        public $galleryLink;
        public $wikiLink;
        public $googleLink;
        public $googleDescription;

        function __construct($record){
            $this->paintingID = $record['PaintingID'];
            $this->title = $record['Title'];
            $this->artistName = $record['FirstName'].' '.$record['LastName'];
            $this->imageFileName = $record['ImageFileName'];
            $this->MSRP = number_format($record['MSRP'], 0, '.', ',');
            $this->excerpt = $record['Excerpt'];
            $this->galleryName = $record['GalleryName'];
            $this->shapeName = $record['ShapeName'];
            $this->description = $record['Description'];
            $this->year = $record['YearOfWork'];
            $this->medium = $record['Medium'];
            $this->width = $record['Width'];
            $this->height = $record['Height'];
            $this->accessionNumber = $record['AccessionNumber'];
            $this->copyright = $record['CopyrightText'];
            $this->galleryLink = $record['MuseumLink'];
            $this->wikiLink = $record['WikiLink'];
            $this->googleLink = $record['GoogleLink'];
            $this->googleDescription = $record['GoogleDescription'];
        }
    }

    /**
     * The class Artist to keep track of the artist name.
     */
    class Artist {
        public $artistName;

        function __construct($record){
            $this->artistName = $record['LastName'];
        }
    }


    /**
     * The class Gallery to keep track of the gallery names.
     */
    class Gallery {
        public $galleryName;

        function __construct($record){
            $this->galleryName = $record['GalleryName'];
        }
    }


    /**
     * The class Shape to keep track of the shape names.
     */
    class Shape {
        public $shapeName;

        function __construct($record){
            $this->shapeName = $record['ShapeName'];
        }
    }

    /**
     * The class Genre to keep track of the genre names.
     */
    class Genre{
        public $genreName;
        public $link;

        function __construct($record){
            $this->genreName = $record['GenreName'];
            $this->link = $record['Link'];
        }
    }

    /**
     * The class Subject to keep track of the subject names.
     */
    class Subject{
        public $subjecteName;

        function __construct($record){
            $this->subjectName = $record['SubjectName'];
        }
    }

    /**
     * The class Frame to keep track of the frame types.
     */
    class Frame{
        public $title;
        public $price;

        function __construct($record){
            $this->title = $record['Title'];
            $this->price = number_format($record['Price'], 0, '.', ',');
        }
    }

    /**
     * The class Glass to keep track of the glass types.
     */
    class Glass{
        public $title;
        public $price;

        function __construct($record){
            $this->title = $record['Title'];
            $this->price = number_format($record['Price'], 0, '.', ',');
        }
    }

    /**
     * The class Matt to keep track of the matt types.
     */
    class Matt{
        public $title;
        public $color;

        function __construct($record){
            $this->title = $record['Title'];
            $this->color = $record['ColorCode'];

        }
    }

    /**
     * The class Review keeps track all the different reviews.
     */
    class Review{
        public $date;
        public $rating;
        public $comment;

        function __construct($record){
            $this->date = date_format(date_create($record["ReviewDate"]), "m/d/Y");
            $this->rating = $record['Rating'];
            $this->comment = $record['Comment'];
        }
    }
?>