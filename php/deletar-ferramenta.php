<?php
// Importação da conexão
require_once "db_connect.php";
// Iniciando sessão
session_start();

if (isset($_POST['btn-deletar-ferramenta'])):
    $id = $_POST['id'];

    $sql = "DELETE FROM ferramentas WHERE id = '$id'";

    if (mysqli_query($connect, $sql)):
        $_SESSION['mensagem'] = "Ferramenta deletada com sucesso!";
        header("Location: ../paginas/ferramentas.php");
    else:
        $_SESSION['mensagem'] = "Erro ao deletar ferramenta: ". mysqli_error($connect);
        header("Location: ../paginas/ferramentas.php");
    endif;
endif;
?>