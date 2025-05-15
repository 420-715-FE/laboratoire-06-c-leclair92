 
 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une photo</title>
    <link rel="stylesheet" href="water.css">
    <link rel="stylesheet" href="gallery.css">
</head>
<body>
    <h1>Ajouter une photo</h1>
  <nav>
    <ul>
      <li><a href="index.php?controller=photo">Retour</a></li>
    </ul>
  </nav>

  <form action="index.php?controller=photo&action=create" method="post" enctype="multipart/form-data">
    <label for="photo">Choisissez une photo :</label>
    <input type="file" id="photo" name="photo" accept="image/*"><br>
    <input type="submit" value="Téléverser">
  </form>
   
</body>
</html>
 
