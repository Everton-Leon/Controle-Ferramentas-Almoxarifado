<?php 
// Importação da conexão
require_once "db_connect.php";
// Iniciando sessão
session_start();

if (isset($_POST['btn-cadastrar-efetivo'])):
    $codigo = limparInput($_POST['codigo']);
    $nome = limparInput($_POST['nome']);
    $funcao = limparInput($_POST['funcao']);
    $encarregado = limparInput($_POST['encarregado']);
    $secao = limparInput($_POST['secao']);
    $situacao = limparInput($_POST['situacao']);
    $frente_servico = limparInput($_POST['frente_servico']);
    $foto = $_FILES['foto'];
    $nome_imagem = null;

    // Vericando se o valor código está duplicado 
    $verificar_duplicidade = mysqli_query($connect, "SELECT codigo FROM efetivo WHERE codigo = '$codigo'");
    if (!mysqli_num_rows($verificar_duplicidade) == 0):
        $_SESSION['mensagem'] = "Código do efetivo duplicado! Tente novamente com um novo valor.";
        header("Location: ../paginas/efetivo.php");
    endif;

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
            $caminho_imagem = "../img/imagem-efetivo/" . $nome_imagem;
            // Faz o upload da imagem para seu respectivo caminho
            move_uploaded_file($foto["tmp_name"], $caminho_imagem);

            // Insere os dados no banco
            $sql = "INSERT INTO efetivo (`codigo`, `nome`, `funcao`, `encarregado`, `secao`, `situacao`, `frente_servico`, `imagem_efetivo`) VALUES ('$codigo', '$nome', '$funcao', '$encarregado', '$secao', '$situacao', '$frente_servico', '$nome_imagem')";
        
            // Se os dados forem inseridos com sucesso
            if (mysqli_query($connect, $sql)):
                $_SESSION['mensagem'] = "Efetivo cadastrado com sucesso!";
                header("Location: ../paginas/efetivo.php");
            else:
                $_SESSION['mensagem'] = "Erro ao cadastrar efetivo: ". mysqli_error($connect);
                header("Location: ../paginas/efetivo.php");
            endif;
        else:
            $_SESSION['mensagem'] = "Erro ao cadastrar imagem! Verifique se ela atende aos requisitos e tente novamente.";
            header("Location: ../paginas/efetivo.php");
        endif;
        
    else:
        // Insere os dados no banco
        $sql = "INSERT INTO efetivo (`codigo`, `nome`, `funcao`, `encarregado`, `secao`, `situacao`, `frente_servico`, `imagem_efetivo`) VALUES ('$codigo', '$nome', '$funcao', '$encarregado', '$secao', '$situacao', '$frente_servico', '$nome_imagem')";
        
        // Se os dados forem inseridos com sucesso
        if (mysqli_query($connect, $sql)):
            $_SESSION['mensagem'] = "Efetivo cadastrado com sucesso!";
            header("Location: ../paginas/efetivo.php");
        else:
            $_SESSION['mensagem'] = "Erro ao cadastrar efetivo: ". mysqli_error($connect);
            header("Location: ../paginas/efetivo.php");
        endif;

    endif;
endif;
?>