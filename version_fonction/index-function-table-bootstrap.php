<?php
require 'function-table-bootstrap2.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <title>Exemple d'utilisation de la fonction d'affichage</title>
    <link rel="stylesheet" href="function-table-bootstrap.css">
</head>
<body>
    <div class="container">
        <?php tableBootstrap('membres', 'snippet_table_bootstrap', 25, 5, [3,5,10,25,50,100,250,500]); ?>
    </div>
</body>
</html>