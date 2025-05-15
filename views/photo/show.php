 
 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>photo</title>
    <link rel="stylesheet" href="water.css">
    <link rel="stylesheet" href="gallery.css">
</head>
<body>
  <h1>Détails de la photo</h1>
  <nav>
    <ul>
      <li><a href="index.php?controller=photo">Retour</a></li>
      <li> <a href="index.php?controller=photo&action=edit&id=<?= htmlspecialchars($photo['id'])?>">Modifier</a></li>
      <li> <a href="index.php?controller=photo&action=delete&id=<?= htmlspecialchars($photo['id']) ?>">Supprimer</a></li>
   </ul>
  </nav>
  <?php
  if($photo['filepath']){
      echo '<img src="'.htmlspecialchars($photo['filepath']).'" width="">';
  }else{
      echo '<img src="image_placeholder.png" width="">';
  }
  ?>
  <p><b>Description :</b> <?= htmlspecialchars($photo['description']) ?></p>
  <p><b>Date et heure : </b><?= htmlspecialchars($photo['timestamp']) ?></p>
  <p><b>Longitude : </b><?= htmlspecialchars($photo['longitude']) ?></p>
  <p><b>Latitude : </b><?= htmlspecialchars($photo['latitude']) ?></p>
  <p><b>Étiquettes :</b></p>

</body>
</html>