<?php
// Importação da conexão
require_once "db_connect.php";
// Iniciando sessão
session_start();
// Modifica o fuso horário a ser utilizado.
date_default_timezone_set("America/Sao_Paulo");

if (isset($_POST['btn-atualizar-ferramenta'])):
    $id = $_POST['id'];
    $codigo = limparInput($_POST['codigo']);
    $ferramenta = limparInput($_POST['ferramenta']);
    $data = date('y/m/d');
    $foto = $_FILES['foto'];
    $nome_imagem = $_POST['nome_imagem'];

    // Vericando se o valor código está duplicado 
    $verificar_duplicidade = mysqli_query($connect, "SELECT codigo FROM ferramentas WHERE codigo = '$codigo'");
    if (!mysqli_num_rows($verificar_duplicidade) == 0) {
        $_SESSION['mensagem'] = "Código da ferramenta duplicado! Tente novamente com um novo valor.";
        header("Location: ../paginas/ferramentas.php");
    }

    // Se a foto estiver sido selecionada
    if (!empty($foto["name"])):
        
        // Largura máxima em pixels
        $largura = 700;
        // Altura máxima em pixels
        $altura = 700;
        // Tamanho máximo do arquivo em bytes
        $tamanho = 100000;
        $error = array();
        // Verifica se o arquivo é uma imagem
        if(!preg_match("/^image\/(pjpeg|jpeg|png|gif)$/i", $foto["type"])):
            $error[1] = "Isso não é uma imagem.";
        endif;
    
        // Pega as dimensões da imagem
        $dimensoes = getimagesize($foto["tmp_name"]);
    
        // Verifica se a largura da imagem é maior que a largura permitida
        if($dimensoes[0] > $largura):
            $error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
        endif;
        // Verifica se a altura da imagem é maior que a altura permitida
        if($dimensoes[1] > $altura):
            $error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
        endif;
        
        // Verifica se o tamanho da imagem é maior que o tamanho permitido
        if($foto["size"] > $tamanho):
                $error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
        endif;
        // Se não houver nenhum erro
        if (count($error) == 0):  
            // Pega extensão da imagem
            preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
            // Gera um nome único para a imagem
            $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
            // Caminho de onde ficará a imagem
            $caminho_imagem = "../img/imagem-ferramentas/" . $nome_imagem;
            // Faz o upload da imagem para seu respectivo caminho
            move_uploaded_file($foto["tmp_name"], $caminho_imagem);

            // Insere os dados no banco
            $sql = "UPDATE ferramentas SET codigo = '$codigo', ferramenta = '$ferramenta', data = '$data', imagem_ferramenta = '$nome_imagem' WHERE id = '$id'";
        
            // Se os dados forem inseridos com sucesso
            if (mysqli_query($connect, $sql)):
                $_SESSION['mensagem'] = "Ferramenta atualizada com sucesso!";
                header("Location: ../paginas/ferramentas.php");
            else:
                $_SESSION['mensagem'] = "Erro ao atualizar ferramenta: ". mysqli_error($connect);
                header("Location: ../paginas/ferramentas.php");
            endif;
        else:
            $_SESSION['mensagem'] = "Erro ao atualizar imagem! Verifique se ela atende aos requisitos e tente novamente.";
            header("Location: ../paginas/ferramentas.php");
        endif;
        
    else:
        // Insere os dados no banco
        $sql = "UPDATE ferramentas SET codigo = '$codigo', ferramenta = '$ferramenta', data = '$data', imagem_ferramenta = '$nome_imagem' WHERE id = '$id'";
        
        // Se os dados forem inseridos com sucesso
        if (mysqli_query($connect, $sql)):
            $_SESSION['mensagem'] = "Ferramenta atualizada com sucesso!";
            header("Location: ../paginas/ferramentas.php");
        else:
            $_SESSION['mensagem'] = "Erro ao atualizar ferramenta: ". mysqli_error($connect);
            header("Location: ../paginas/ferramentas.php");
        endif;

    endif;
endif;
?>