# Laboratoire 06-C

Dans le cadre de ce laboratoire, vous devez développer une application de type « Galerie de photos » simple en utilisant la base de données MySQL fournie, de même que l'architecture MVC. À la fin de ce laboratoire, il manquera certaines fonctionnalités pour que l'application soit complète. Vous ajouterez ces fonctionnalités lors des laboratoires ultérieurs.

Commencez par prendre connaissance de la base de données fournie, et assurez-vous de bien comprendre sa structure. N'hésitez pas à générer un diagramme dans phpMyAdmin afin de mieux comprendre.

Voici les fonctionnalités que vous devez implémenter dans ce laboratoire:

* Afficher la galerie de photos
* Cliquer sur une photo spécifique pour l'afficher avec ses informations
* Modifier les informations d'une photo
* Supprimer une photo
* Afficher la liste des albums
* Afficher les photos d'un album

Les fonctionnalités permettant d'ajouter, modifier et supprimer des albums ne sont pas à implémenter pour le moment. Il en va de même pour l'ajout d'étiquettes (*tags*) à une photo.

Le script SQL fourni pour créer la base de données comprend déjà des données de tests, incluant des photos, des étiquettes (*tags*) et des albums. Les fichiers des photos se trouvent dans le dossier `images` du présent dépôt.

Voici un aperçu de l'application à développer:

![](images-readme/demo.gif)

C'est à vous de réfléchir aux modèles, vues et contrôleurs dont vous aurez besoin dans votre application. C'est également à vous de bien découper les fonctionnalités à développer pour les implémenter en étapes les plus petites possibles et en testant vos fonctionnalités au fur et à mesure.

Vous trouverez ci-dessous des informations dont vous aurez besoin pour implémenter les fonctionnalités demandées.

## Téléversement d'un fichier

Pour téléverser un fichier à partir d'un formulaire HTML, il faut utiliser un champ de type `file`. De plus, il faut ajouter un attribut `enctype="multipart/form-data"` à la balise `form`. Voici un exemple:

```html
<form method="POST" enctype="multipart/form-data">
    <label for="photo">Choisissez une photo :</label>
    <input type="file" id="photo" name="photo" accept="image/*">
    <input type="submit" value="Téléverser">
    <label for=""></label>
</form>
```

Avec l'attribut `enctype="multipart/form-data"` sur le formulaire, vous ne pourrez plus utiliser la variable `$_POST` pour vérifier si le formulaire a été transmis. Voici donc une méthode alternative à utiliser dans votre routeur (fichier `index.php`):

```php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->handlePost($_GET, $_POST);
} else {
    $controller->handle($_GET);
}
```

Voici comment recevoir et traiter le fichier du côté de PHP. Nous voulons stocker le fichier reçu dans le dossier `images`.

```php
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
                /*
                Le fichier a été téléversé correctement et
                se trouve maintenant dans le dossier « images ».
                La valeur de la variable $newPath peut être
                utilisée pour l'ajout de la photo dans la base
                de données.
                */
            } else {
                /*
                Une erreur a été rencontrée lors du déplacement
                du fichier vers le dossier « images ». Il faudrait
                donc indiquer à l'utilisateur que le téléversement
                de la photo a échoué.
                */
            }
        } else {
            /*
            Le fichier reçu n'est pas une image. Il faudrait
            donc afficher un message d'erreur à l'utilisateur.
            */
        }
    } else {
        /*
        Le téléversement a échoué. Il faudrait donc afficher
        un message d'erreur à l'utilisateur.
        */
    }
}
```

Remarquez l'utilisation d'une fonction `uuid()` pour générer le nouveau nom du fichier. Cette fonction n'est pas incluse dans PHP, vous devez donc la créer. Voici son code:

```php
// Source: https://www.usefulids.com/resources/generate-uuid-in-php
function uuid()
{
    // Generate 16 random bytes
    $data = random_bytes(16);

    // Set the version to 4 (0100 in binary)
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set the variant to 2 (10 in binary)
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Return the formatted UUID
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
```

Les [UUID](https://fr.wikipedia.org/wiki/Universally_unique_identifier) sont des chaînes de caractères hexadécimales générées aléatoirement. Elles sont souvent utilisées dans des applications qui ont besoin de générer des identifiants avec une forte probabilité d'unicité.

> Pour que le téléversement de fichiers fonctionne, il faut aussi vous assurer que votre installation PHP est configurée pour accepter les téléversements. Pour ce faire, utilisez les menus de XAMPP pour accéder au fichier `php.ini`, et assurez-vous que le paramètre `file_uploads` a la valeur `On`. Assurez-vous aussi que `upload_max_filesize` a une valeur suffisante.

## Feuilles de style

Utilisez les feuilles de style `water.css` et `gallery.css` dans toutes vos vues.

Pour formater la galerie de photos tel qu'attendu, il vous suffit de placer chaque photo dans un `li` à l'intérieur d'un `ul` avec l'ID `gallery`. Le fichier `gallery.css` contient les règles CSS nécessaires pour produire le résultat voulu.

Pour styler le menu qui se trouve sous le titre de chaque page, il faut placer celui-ci dans un `nav` contenant un `ul`. Chaque élément du menu doit être dans un `li` distinct.

## Formulaire et validation

Toutes les données saisies dans un formulaire doivent être validées et les mesures de sécurité habituelles doivent être appliquées.

Utilisez un champ de type `datetime-local` pour la date et heure d'une photo, et utilisez la fonction suivante pour valider la valeur transmise:

```php
function isValidTimestamp($timestamp) {
    $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $timestamp);    
    return $dateTime && $dateTime->format('Y-m-d\TH:i') === $timestamp;
}
```

La latitude et la longitude doivent être des nombres décimaux.

Si un champ non requis est laissé vide, il faut insérer `NULL` dans la base de données plutôt qu'une chaîne de caractères vide (`''`), sauf pour la description d'une photo, qui elle peut être une chaîne vide.

> **NOTE:** On pourrait éventuellement extraire la date, l'heure, la longitude et la latitude directement des fichiers téléversés au lieu de les demander à l'utilisateur! Ces informations sont disponibles dans les données [EXIF](https://fr.wikipedia.org/wiki/Exchangeable_image_file_format) des photos, et PHP fournit des fonctions pour les lire.

## Image *placeholder*

Dans la liste des albums, Utilisez l'image `image_placeholder.png` fournie lorsqu'un album ne possède pas de `featured_photo_id`.

> Cette image provient de l'[utilisateur Truongpd38 sur Wikipedia Commons](https://commons.wikimedia.org/wiki/File:DefaultImage.png) et est partagée sous [licence CC BY-SA 4.0](https://www.creativecommons.org/licenses/by-sa/4.0/deed.fr).

## Erreur 404

Une page `erreur404.php` vous est fournie. Redirigez l'utilisateur vers cette page lorsque vous détectez qu'il manque un paramètre dans l'URL ou qu'une valeur d'`ID` invalide a été passée.
