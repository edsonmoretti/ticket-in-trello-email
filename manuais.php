<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <link rel="shortcut icon" href="imgs/favicon.png"/>
    <link rel="icon" href="imgs/favicon.png"/>
    <title>PagMenos - Chamado</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<div class="container fluid">
    <div class="card border-danger">
        <div style="text-align: center" class="card-header bg-danger text-white">
            <p><img src="imgs/logo.png" class="img-fluid" style="max-width: 300px"/></p>
            <p><h5><b>MANUAIS</b></h5></p>
        </div>
        <div class="card-body">
            <?php if ($handle = opendir('manuais')) {    while (false !== ($entry = readdir($handle))) {  if ($entry != "." && $entry != "..") { ?>
                <div class="form-group">
                    <input type="hidden" value="TI" name="sector">
                    <a href="<?php echo 'manuais/'.$entry ?>" class="form-control btn btn-lg btn-outline-primary">
                        <b> <?php echo strtoupper($entry) ?></b>
                    </a>
                </div>
                <hr>
            <?php } } } closedir($handle); ?>
        </div>
        <div class="form-group">
            <hr>
            <button type="button"
                    class="form-control btn btn-lg btn-warning"
                    onclick="window.history.back()"
                    value="Abertura de Chamado">
                <b> VOLTAR</b>
            </button>
        </div>
    </div>
</div>
</body>
</html>