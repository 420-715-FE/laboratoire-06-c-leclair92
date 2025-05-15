<?php
class Photo {
    public static function all($db) {
        return $db->query("SELECT * FROM photo")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($db, $id) {
        $stmt = $db->prepare("SELECT * FROM photo WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($db, $filepath) {
        $stmt = $db->prepare("INSERT INTO photo (filepath) VALUES (?)");
        $stmt->execute([$filepath]);
         return $db->lastInsertId(); 
    }

    public static function update($db, $id, $description, $timestamp,$latitude,$longitude) {
        $stmt = $db->prepare("UPDATE photo SET description = ?, timestamp = ? , latitude = ?, longitude = ?  WHERE id = ?");
        $stmt->execute([$description, $timestamp,$latitude,$longitude, $id]);
    }

    public static function delete($db, $id) {
        $stmt = $db->prepare("DELETE FROM photo WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function findByAlbum($db, $albumId) {
    $stmt = $db->prepare("
        SELECT photo.*
        FROM photo
        JOIN album_photo ON photo.id = album_photo.photo_id
        WHERE album_photo.album_id = ?
    ");
    $stmt->execute([$albumId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
?>