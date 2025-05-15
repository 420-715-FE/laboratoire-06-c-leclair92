
 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une photo</title>
    <link rel="stylesheet" href="water.css">
    <link rel="stylesheet" href="gallery.css">
</head>
<body>
  <h1>Modifier une photo</h1>
  <nav>
    <ul>
      <li> <a href="index.php?controller=photo&action=show&id=<?= htmlspecialchars($photo['id']) ?>">Retour</a></li>
    </ul>
  </nav>
  <img src="<?= htmlspecialchars($photo['filepath']) ?>" width="">
  <form action="index.php?controller=photo&action=update" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($photo['id'])?>">
    <p><b>Description :</b></p>
    <input type="text" name="description" value="<?= htmlspecialchars($photo['description']) ?>">
    <p><b>Date et heure : </b></p>
    <input type="date" name="timestamp" value="<?= htmlspecialchars($photo['timestamp']) ?>">
    <p><b>Longitude : </b></p>
    <input type="number" name="longitude" value="<?= htmlspecialchars($photo['longitude']) ?>">
    <p><b>Latitude : </b></p>
    <input type="number" name="latitude" value="<?= htmlspecialchars($photo['latitude']) ?>">
    <button type="submit">Enregistrer</button>
  </form>

</body>
</html>

 