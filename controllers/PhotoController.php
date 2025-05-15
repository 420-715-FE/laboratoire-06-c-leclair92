<?php
require_once 'models/Photo.php';
   function uuid(){
    // Generate 16 random bytes
    $data = random_bytes(16);

    // Set the version to 4 (0100 in binary)
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set the variant to 2 (10 in binary)
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Return the formatted UUID
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
class PhotoController {
        private $db;
        public function __construct($db) {
            $this->db = $db;
        }

        public function index() {
            $photos = Photo::all($this->db);
            include 'views/photo/index.php';
        }

        public function show() {
            $photo = Photo::find($this->db, $_GET['id']);
            include 'views/photo/show.php';
        }

        public function create() {
        
            if (isset($_FILES['photo'])) {
            if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                $filename = $_FILES['photo']['name'];
                $filetype = $_FILES['photo']['type'];
                $tempPath = $_FILES['photo']['tmp_name'];

                if (str_starts_with($filetype, 'image/')) {
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $newFilename = uuid() . '.' . $extension;
                    $newPath = "images/$newFilename";

                    if (move_uploaded_file($tempPath, $newPath)) {
                        $photo = Photo::create($this->db, $newPath);
        
                        header('Location: index.php?controller=photo&action=edit&id=' .  $photo);
                
                    } else {
                        echo 'Erreur lors du déplacement vers le dossier image';
                
                    }
                } else {
                    echo 'Ce n\'est pas une image';
                
                }
            } else {

                echo 'Le téléversement a échoué';
        
            }
    }
    include 'views/photo/create.php';
    }


    public function edit() {
        $photo = Photo::find($this->db, $_GET['id']);
        include 'views/photo/edit.php';
    }

    public function update() {
        $id = $_POST['id'];
        $description = $_POST['description'];
        $timestamp = $_POST['timestamp'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        Photo::update($this->db, $id,$description, $timestamp,$latitude,$longitude);
        header('Location: index.php?controller=photo');
    }

    public function delete() {
        Photo::delete($this->db, $_GET['id']);
        header('Location: index.php?controller=photo');
    }
}
