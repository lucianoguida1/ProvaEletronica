<!DOCTYPE HTML>
<html>
<head>
    <title><?=$title;?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" type="text/css" href="assets/css/estilo.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

     <script src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/dataTables.min.js"></script>
    <script type="text/javascript" src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="assets/js/dataTables.ini.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>


<body>
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="?acao=index&modulo=index">Prova Eletronica</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <?php foreach ($menu as $key => $item){ $controller = explode("/",$item);?>
                        <li class="nav-item">
                            <a class="nav-link" href="?acao=<?=$controller[1]?>&modulo=<?=$controller[0]?>"><?=$key?></a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </nav>
            </div>
            <div class="col-md-6">
                <?php if(isset($msg)){?>
                <div id="msgSistema" class="alert alert-<?=$msg[0]?>" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5><?=$msg[1]?></h5>
                    <p><?=$msg[2]?></p>
                </div>
                <?php } ?>
                <div id="j_msgAjax"></div>
            </div>
        </div>
    </div>

<div id="content" class="container">
    <div class="row justify-content-md-center conteudo">
