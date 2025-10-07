<?php

session_start();

// apagar as variáveis de sessão
session_unset();

//destrói a sessão
session_destroy();

header('Location: login.php');

?>