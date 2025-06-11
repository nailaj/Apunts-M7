
<?php
session_start();

if (isset($_POST['resposta']) && isset($_SESSION['resposta_correcta'])) {
    if ($_POST['resposta'] === $_SESSION['resposta_correcta']) {
        $_SESSION['encerts']++;
    }

    $_SESSION['pregunta']++;

    if ($_SESSION['pregunta'] < 10) {
        header('Location: joc.php');
        exit;
    } else {
        header('Location: resultat.php');
        exit;
    }
} else {
    header('Location: joc.php');
    exit;
}
