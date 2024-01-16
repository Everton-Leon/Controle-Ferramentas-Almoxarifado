<?php
// Encerrando a sessão e retornando para a index
session_start();
session_unset();
session_destroy();
header('Location: ../index.php')
?>