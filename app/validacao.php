<?php
  // Verifica se houve POST e se o usuário ou a senha é(são) vazio(s)
  if (!empty($_POST) AND (empty($_POST['usuario']) OR empty($_POST['senha']))) {
    header("Location: formulario.html"); exit;
  }

  $conn = new PDO('mysql:host='. $_ENV['DATABASE_HOST']. ';dbname='. $_ENV['DATABASE_DB'], $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASS']);
  $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
   
  $stmt = $conn->prepare('SELECT * FROM tela_de_login WHERE usuario = :USUARIO');
  $stmt -> execute(array(':USUARIO' => $usuario));

  foreach($conn as $key=>$value){
    $count = count($$conn);
    if($count > 0){
      if(password_verify($senha, $value['senha'])){
        if(!isset($_SESSION));session_start();
        // Salva os dados encontrados na sessão
        $_SESSION['Id'] = $value['id'];
        $_SESSION['Usuario'] = $value['usuario'];
        $_SESSION['Nome'] = $value['nome'];
        $_SESSION['Nivel'] = $value['nivel'];
        return header('index.html');
      }
      else{
        return header('formulario.html?msn=Senha incorreta'); exit;
      }
    }
    else{
      return header('formulario.html?msn= Usuario não exixte'); exit;
    }

  }
  
?>