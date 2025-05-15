<?php
class Album {
    public static function all($db) {
        $stmt = $db->query("
            SELECT album.id, album.name, album.featured_photo_id, photo.filepath AS featured_photo_url
            FROM album
            LEFT JOIN photo ON album.featured_photo_id = photo.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }


}
