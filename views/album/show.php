

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photos</title>
    <link rel="stylesheet" href="water.css">
    <link rel="stylesheet" href="gallery.css">
</head>
<body>
  <h1>Gallerie de photo</h1>
  <nav>
    <ul>
      <li><a href="index.php?controller=album">Retour</a></li>
      <li><a href="index.php?controller=photo&action=create">Ajouter une photo</a></li>
    </ul>
  </nav>
  <ul id="gallery">
    <?php foreach ($photos as $photo): ?>
      <li>
        <a href="index.php?controller=photo&action=show&id=<?= htmlspecialchars($photo['id']) ?>">
          <?php
            if($photo['filepath'] && file_exists($photo['filepath'])){
              echo '<img src="'.htmlspecialchars($photo['filepath']).'" width="100">';
           }else{
              echo '<img src="image_placeholder.png" width="">';
           }
          ?>
 
        </a>
        <p><?= htmlspecialchars($photo['description']) ?></p>
      </li>
    <?php endforeach; ?>
  </ul>

   
</body>
</html>
