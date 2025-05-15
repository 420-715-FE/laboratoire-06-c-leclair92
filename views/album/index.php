
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album</title>
    <link rel="stylesheet" href="water.css">
    <link rel="stylesheet" href="gallery.css">
</head>
<body>
    <h1>Album</h1>
  <nav>
    <ul>
      <li> <a href="index.php?controller=photo">Gallerie</a></li>
      <li> <a href="index.php?controller=album">Albums</a></li>
      <li> <a href="index.php?controller=photo&action=create">Ajouter une photo</a> </li>
    </ul>
  </nav>
   
<ul id="gallery">
  <?php foreach ($albums as $album): ?>
    <li>
      <a href="index.php?controller=album&action=show&id=<?= $album['id'] ?>">
        <?php
          if($album['featured_photo_url'] && file_exists($album['featured_photo_url'])){
              echo '<img src="'.htmlspecialchars($album['featured_photo_url']).'" width="">';
          }else{
              echo '<img src="image_placeholder.png" width="">';
          }
          ?>
      </a>
      <?= htmlspecialchars($album['name']) ?>
    </li> 
  <?php endforeach; ?>
</ul>

</body>
</html>
