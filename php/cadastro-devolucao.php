<?php 
// Importação da conexão
require_once "db_connect.php";
// Iniciando sessão
session_start();
// Modifica o fuso horário a ser utilizado.
date_default_timezone_set("America/Sao_Paulo");

if (isset($_POST['btn-pegar-ferramenta'])):
    $codFerramenta = limparInput($_POST['codigo-ferramenta']);
    $ferramenta = $_POST['ferramenta'];
    $codFunc = limparInput($_POST['codFunc']);
    $nome = $_POST['nomeFunc'];
    $encarregado =  $_POST['encarregado'];
    $funcao = $_POST['funcao'];
    $secao = $_POST['secao'];
    $encarregado = $_POST['encarregado'];
    $frente_servico = $_POST['frente-servico'];
    $horario = date('Y-m-d H:i:s');

    // Inserção na tabela não devolvidos
    $sql = "INSERT INTO nao_devolvidos (`cod_ferramenta`, `nome_ferramenta`, `nome_func`, `encarregado`, `frente_servico`, `horario`) VALUES ('$codFerramenta', '$ferramenta', '$nome', '$encarregado', '$frente_servico', '$horario')";

    $sqlHistorico = "INSERT INTO historico (`cod_ferramenta`, `nome_ferramenta`,`cod_funcionario`, `nome_func`, `funcao`,`secao`, `encarregado`, `frente_servico`, `acao`, `horario`) VALUES ('$codFerramenta', '$ferramenta', '$codFunc', '$nome', '$funcao', '$secao', '$encarregado', '$frente_servico', 'pegou', '$horario')";

    // Alteração no status da ferramenta
    $upadateFerramenta = "UPDATE ferramentas SET `status` = 'Em campo' WHERE codigo = '$codFerramenta'";

    if (mysqli_query($connect, $sql) && mysqli_query($connect, $upadateFerramenta) && mysqli_query($connect, $sqlHistorico)):
        $_SESSION['mensagem'] = "Ferrameta emprestada com sucesso!";
        header('Location: ../paginas/home.php');
    else:
        $_SESSION['mensagem'] = "Falha ao emprestar ferramenta: ".mysqli_error($connect);
        header('Location: ../paginas/home.php');
    endif;
endif;

// Se existir o botão de devolução
if (isset($_POST['btn-devolver-ferramenta'])):
    $codFerramenta = limparInput($_POST['codigo-ferramenta']);
    $ferramenta = $_POST['ferramenta'];
    $codFunc = limparInput($_POST['codFunc']);
    $nome = $_POST['nomeFunc'];
    $encarregado =  $_POST['encarregado'];
    $funcao = $_POST['funcao'];
    $secao = $_POST['secao'];
    $encarregado = $_POST['encarregado'];
    $frente_servico = $_POST['frente-servico'];
    $horario = date('Y-m-d H:i:s');

    // Inserção no banco de dados
    $sql = "DELETE FROM nao_devolvidos WHERE cod_ferramenta = '$codFerramenta'";

    // Alteração no status da ferramenta
    $upadateFerramenta = "UPDATE ferramentas SET `status` = 'disponivel' WHERE codigo = '$codFerramenta'";

    // Inserção no histórico
    $sqlHistorico = "INSERT INTO historico (`cod_ferramenta`, `nome_ferramenta`,`cod_funcionario`, `nome_func`, `funcao`,`secao`, `encarregado`, `frente_servico`, `acao`, `horario`) VALUES ('$codFerramenta', '$ferramenta', '$codFunc', '$nome', '$funcao', '$secao', '$encarregado', '$frente_servico', 'devolveu', '$horario')";

    if (mysqli_query($connect, $sql) && mysqli_query($connect, $upadateFerramenta) && mysqli_query($connect, $sqlHistorico)):
        $_SESSION['mensagem'] = "Ferrameta devolvida com sucesso!";
        header('Location: ../paginas/home.php');
    else:
        $_SESSION['mensagem'] = "Falha ao devolver ferramenta: ".mysqli_error($connect);
        header('Location: ../paginas/home.php');
    endif;
endif;
?>