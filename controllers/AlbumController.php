<?php
require_once 'models/Album.php';
require_once 'models/Photo.php';

class AlbumController {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $albums = Album::all($this->db);
        include 'views/album/index.php';
    }

        public function show() {
        $albumId = $_GET['id'] ?? null;
        $photos = Photo::findByAlbum($this->db, $albumId);
        include 'views/album/show.php';
    }
}
