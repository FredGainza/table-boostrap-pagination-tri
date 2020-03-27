<?php

/**
 * TABLES BOOTSTRAP et AFFICHAGE BDD - PAGINATION ET TRI
 * le 27.03.2020
 * 
 * @category HTML & PHP
 * 
 * création d'un tableau à partir de données extraites d'une base de données,
 * avec pagination et possibilité de tri à partir de chaque colonne 
 * (nécessite Bootstrap et Font Awesome)
 * 
 * Exemple commenté : "test/exemple-bootstrap-table-bdd.php"
 * Version fonction : "version_fonction/function-table-bootstrap.php"
 *
 * @package     TABLES BOOTSTRAP et AFFICHAGE BDD
 * @version     1.0.0
 * @license     http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author      Frédéric Gainza <contact@fgainza.fr>
 * @link        https://github.com/FredGainza/table-boostrap-pagination-tri     
 */


/*
=========================================================
################# Eléments à renseigner #################
=========================================================
*/
        /* Nom de la table */
        $table;

        /* Nb éléments par page par défaut */
        $limit_par_default;

        /* Nb max de pagination autour de la page active */
        $nb_autour;

        /* Tableau nb éléments par page possibles  */
        $nb_par_page;

        /* Optionnel : Tableau  à 2 dim [field_bdd, intitulé th] */
        // exemple : $cols = [['id', 'Id'], ['firstname', 'Prénom'], ['lastname', 'Nom'], ['tel', 'Téléphone']];
        $cols;

        // Connexion à la base de données
        $dbname; 
        $user;
        $pass;
/*
=========================================================
=========================================================
*/



try {
    $dbh = new PDO('mysql:host=localhost;dbname=' . $dbname, $user, $pass);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}


/*
===================================================
#                                                 #
#                Partie Pagination                #
#                                                 #
===================================================
*/

$prepare = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='" . $table . "'";
$q = $dbh->prepare($prepare);
$q->execute();
while ($donnees = $q->fetch(PDO::FETCH_OBJ)) {
    $columns[] = $donnees->COLUMN_NAME;
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 0;

if (isset($_GET['nb_items']) && $_GET['nb_items'] > 0) {
    $limit = intval($_GET['nb_items']);
} elseif (isset($_SESSION['limit'])) {
    $limit = intval($_SESSION['limit']);
} else {
    $limit = $limit_par_default;
}
$_SESSION['limit'] = $limit;
$debut = (!isset($debut)) ? 0 :  $page * $limit;

$requete = "SELECT * FROM " . $table;
$select_temp = $dbh->prepare($requete);
$select_temp->execute();
$nb_total = $select_temp->rowCount();

$limite = $dbh->prepare($requete . " limit $debut,$limit");
$limit_str = "LIMIT " . $page * $limit . ",$limit";

/*
===================================================
#                                                 #
#              Partie Tri du Tableau              #
#                                                 #
===================================================
*/

$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';
if ($resultat = $dbh->prepare($requete . ' ORDER BY ' .  $column . ' ' . $sort_order . ' ' . $limit_str)) {
    $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
    $add_class = ' class="select_col"';
    $resultat->execute();
    $res = $resultat->fetchAll(PDO::FETCH_OBJ);
}
?>

<!--  
===================================================
#                                                 #
#                 Partie Affichage                #
#                   HTML et CSS                   #
#                                                 #
===================================================
-->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <title>Exemple pagination et tri tableau Bootstrap</title>
    <style>
        body {
            width: 1600px;
            margin: 0 auto;
            font-family: 'Lato', sans-serif;
            background-color: #eeeeee;
        }

/************ Partie Select ************/
        .col-form-label-lg {
            padding-top: 0 !important;
        }
        .custom-select {
            height: 2.2rem !important;
            padding: 0rem 1.5rem 0 .5rem;
        }
        .col-form-label-lg {
            padding-bottom: 0 !important;
            padding-right: .75rem !important;
            font-size: 1.1rem !important;
        }
        .form-select {
            margin-bottom: 0 !important;
        }
        .form-select-up {
            margin-bottom: .5rem !important;
        }
        .pady-0-1{
            padding-top: .1rem !important;
            padding-bottom: .1rem !important;
        }

/************ Partie Pagination ************/
        .pagination>li>a {
            background-color: white;
            color: #181a1b !important;
        }
        .pagination>li>a:focus,
        .pagination>li>a:hover,
        .pagination>li>span:focus,
        .pagination>li>span:hover {
            color: #1f2428 !important;
            background-color: #eee !important;
            border-color: #ddd !important;
        }
        .pagination>.active>a {
            color: white !important;
            background-color: #1f2428 !important;
            border: solid 1px #1f2428 !important;
        }
        .pagination>.active>a:hover {
            color: #f0f0f0 !important;
            background-color: #1f2428de !important;
            border: solid 1px #1f2428e8 !important;
        }
        .page-item.disabled a {
            background-color: #eeededdb !important;
        }

/************ Partie Tableau ************/
        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        table > thead > tr > th {
            white-space: nowrap !important; 
        }
        th > a {
            color: white !important;
            text-decoration: none !important;
            background-color: transparent !important;
        }
        th {
            background-color: #242424ed;
            color: white;
            text-align: left;
            font-weight: 300;
            padding: 1rem;
        }
        td {
            text-align: left;
            width: auto;
            padding: 1rem;;
            background-color: #fcfcfc !important;
        }
        td p {
            margin-bottom: 0 !important;
        }
        tr > .border-bot{border-bottom: 1px solid #bfbfbf !important;}

/************ Partie Tri ************/
        .color-darky {
            color: #292b2c
        }

        tr .select_col {
            background-color: #4f6278ed !important;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="row my-3">
            <form action="" method="GET">
                <div class="form-group form-select row w-100 align-items-center flex-nowrap ml-5">
                    <label class="col-auto col-form-label col-form-label-lg" for="nb_items">Eléments par page</label>
                    <div class="col-auto pad-l-0 ">
                        <select name="nb_items" id="nb_items" class="form-control form-control-lg pad-r-0 custom-select">
                            <?php for ($i=0; $i<count($nb_par_page); $i++) : ?>
                                <?php if($nb_par_page[$i]>0 && $nb_par_page[$i]<=$nb_total) : ?>
                                    <option value="<?= $nb_par_page[$i]; ?>" <?= $limit == $nb_par_page[$i] ? ' selected="selected"' : ''; ?>><?= $nb_par_page[$i]; ?></option>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group form-select w-25 pl-3 valid">
                        <button type="submit" class="btn btn-success btn-valid px-3 pady-0-1">Valider</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row align-items-center justify-content-end mr-5">
            <?php
            echo "<nav aria-label=\"Partie Pagination mx-auto\">";
            echo "<br>";
            echo "<ul class=\"pagination\">";
            $nb_pages = ceil($nb_total / $limit);
            $nb_pages_index = $nb_pages - 1;
            if ($page > 0) {
                $precedent = $page - 1;
                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?nb_items=" . $limit . "&page=" . $precedent . "&column=" . $column . "&order=" . strtolower($sort_order) . "\" aria-label=\"Previous\"><span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span></a></li>";
            } else {
                $page = 0;

            }
            $i = 0;
            $j = 1;

            if ($nb_total > $limit) {
                while ($i < ($nb_pages)) {
                    if ($i != $page && abs($page - $i) < $nb_autour) {
                        echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?nb_items=" . $limit . "&page=" . $i . "&column=" . $column . "&order=" . strtolower($sort_order) . "\">$j</a></li>";
                    }
                    if (abs($page - $i) >= $nb_autour) {
                        if ($page - $i >= $nb_autour) {
                            if ($page - $i - 1 < $nb_autour) {
                                if ($page != 0) {
                                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?nb_items=" . $limit . "&page=0&column=" . $column . "&order=" . strtolower($sort_order) . "\">1</a></li>";
                                }
                                echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" tabindex=\"-1\">&hellip;</a></li>";
                            }
                        }
                    }
                    if ($i == $page) {
                        echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\"><b>$j</b></a></li>";
                    }
                    if (abs($page - $i) >= $nb_autour) {
                        if ($i - $page >= $nb_autour) {
                            if ($i - $page - 1 < $nb_autour) {
                                echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" tabindex=\"-1\">&hellip;</a></li>";
                                if ($page != $nb_pages_index) {
                                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?nb_items=" . $limit . "&page=" . $nb_pages_index . "&column=" . $column . "&order=" . strtolower($sort_order) . "\">$nb_pages</a></li>";
                                }
                            }
                        }
                    }
                    $i++;
                    $j++;
                }
            }
            if ($debut + $limit < $nb_total) {
                $suivant = $page + 1;
                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?nb_items=" . $limit . "&page=" . $suivant . "&column=" . $column . "&order=" . strtolower($sort_order) . "\" aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</span><span class=\"sr-only\">Next</span></a></li>";
            }
            echo "</ul></nav>";
            ?>
        </div>

        <table class="mb-5 border-dark">
            <thead>
                <tr>
                    <?php for ($i = 0; $i <count($columns); $i++) : ?>
                        <th<?= $column == (isset($cols) ? $cols[$i][0] : $columns[$i]) ? $add_class : ""; ?>><a href="?nb_items=<?= $limit; ?>&page=<?= $page; ?>&column=<?= isset($cols) ? $cols[$i][0] : $columns[$i]; ?>&order=<?= $asc_or_desc; ?>"><?= isset($cols) ? $cols[$i][0] : $columns[$i]; ?><i class="fas fa-sort<?= $column == (isset($cols) ? $cols[$i][0] : $columns[$i]) ? '-' . $up_or_down . ' color-darky ml-2' : ' text-warning ml-2'; ?>"></i></a></th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($res as $v) : ?>
                    <tr class="border-bot">
                        <?php for ($i = 0; $i <count($columns); $i++) : ?>
                            <?php $x = $columns[$i]; ?>
                            <td class="border-bot"><?= $v->$x; ?></td>
                        <?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>