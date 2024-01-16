<?php
// Importação da conexão
require_once "db_connect.php";
// Iniciando sessão
session_start();

if (isset($_POST['btn-deletar-efetivo'])):
    $id = $_POST['id'];

    $sql = "DELETE FROM efetivo WHERE id = '$id'";


    if (mysqli_query($connect, $sql)):
        $_SESSION['mensagem'] = "Efetivo deletado com sucesso!";
        header("Location: ../paginas/efetivo.php");
    else:
        $_SESSION['mensagem'] = "Erro ao deletar efetivo: ". mysqli_error($connect);
        header("Location: ../paginas/efetivo.php");
    endif;
endif;
?>