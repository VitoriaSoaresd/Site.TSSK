<?php
require('config/config.php');

/**
 * Obtém e filtra o nome da página da URL:
 * Referências:
 *  • https://www.w3schools.com/jsref/jsref_trim_string.asp
 *  • https://www.php.net/manual/en/function.urldecode.php
 *  • https://www.w3schools.com/php/func_string_htmlentities.asp
 *  • https://www.w3schools.com/php/php_superglobals.asp
 *  • https://www.w3schools.com/php/php_superglobals_server.asp
 **/
$route = trim(htmlentities($_SERVER['QUERY_STRING']));

// Se não solicitou uma rota, usa a rota da página inicial:
if ($route == '') $route = 'home';

// Remove coisas depois da "/" caso exista:
$route = explode('/', $route)[0];

/**
 * Monta todos os caminhos dos arquivos da página em uma coleção:
 * Referências:
 *  • https://www.w3schools.com/php/php_arrays.asp
 *  • https://www.w3schools.com/php/func_array.asp
 **/
$page = array(
  'php' => "pages/{$route}/index.php",
  'css' => "pages/{$route}/index.css",
  'js' => "pages/{$route}/index.js",
);

/**
 * Verifica se a rota solicitada para o arquivo PHP existe:
 * Referências:
 *  • https://www.w3schools.com/php/func_filesystem_file_exists.asp
 **/
if (!file_exists($page['php'])) :

  // Se não existe, carrega, explicitamente, a rota da página 404:
  $page = array(
    'php' => "pages/404/index.php",
    'css' => "pages/404/index.css",
    'js' => "pages/404/index.js",
  );
endif;

// Carrega a página PHP solicitada pela rota:
require($page['php']);

// Carrega o CSS da página solicitada, somente se ele existe:
if (file_exists($page['css']))
  // Gera a tag que carrega o CSS da página:
  $page_css = "<link rel=\"stylesheet\" href=\"/{$page['css']}\">";

// Carrega o JavaScript da página solicitada, somente se ele existe:
if (file_exists($page['js']))
  // Gera a tag que carrega o JavaScript da página:
  $page_js = "<script src=\"/{$page['js']}\"></script>";

?>
<!DOCTYPE html>

<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="/img/favicon.jpg">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="/img/logotssk.jpg">
  <link rel="stylesheet" href="/style.css" />
  <link rel="stylesheet" href="" id="pageCSS">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

  <title><?php echo $c['sitename'] ?></title>
</head>

<body>
    <a id="top"></a>

    <header>
        <a href="/" title="Página inicial"><?php echo $c['sitelogo'] ?></a>
        <h1><?php echo $c['sitename'] ?> <small><?php echo $c['siteslogan'] ?></small></h1>
        <hr>
        <nav>
        <a href="/" title="Página inicial"><span>Início</span></a>
        <a href="/?about" title="Nos conheça"><span>Sobre nós</span></a>
        <a href="/?schedule" title="Agenda de eventos"><span>Agenda</span></a>
        <a href="/?contacts" title="Faça contato"><span>Contatos</span></a>
        </nav>
        <hr>
    </header>

    <main id="content"><?php echo $page_content;?></main>

    <footer>
        <hr>
        &copy; 2022 <?php echo $c['sitename'] ?>
    </footer>
</body>

</html>