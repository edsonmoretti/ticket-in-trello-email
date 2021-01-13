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
            <p><h5><b>Abertura de Chamados</b></h5></p>
        </div>
        <div class="card-body">
            <div class="form-group">
                <br>
                <form method="post" action="chamados.php">
                    <input type="hidden" value="TI" name="sector">
                    <input type="hidden" value="success" name="classe">
                    <button type="submit" class="form-control btn btn-lg btn-outline-success">
                        <b> ABRIR CHAMADO PARA TI</b>
                    </button>

                    <input type="hidden" value="TI" name="sector">
                    <a href="manuais.php" class="form-control btn btn-outline-primary">
                        <b> ACESSAR MANUAIS</b>
                    </a>
                </form>
            </div>
            <hr>
            <div class="form-group">
                <form method="post" action="chamados.php">
                    <input type="hidden" value="Operações" name="sector">
                    <input type="hidden" value="info" name="classe">
                    <button type="submit" class="form-control btn btn-lg btn-outline-info">
                        <b> ABRIR CHAMADO P/ OPERAÇÕES</b>
                    </button>
                </form>
            </div>
            <hr>
            <div class="form-group">
                <form method="post" action="chamados.php">
                    <input type="hidden" value="DP/RH" name="sector">
                    <input type="hidden" value="danger" name="classe">
                    <button type="submit" class="form-control btn btn-lg btn-outline-danger">
                        <b> ABRIR CHAMADO DP/RH</b>
                    </button>
                </form>
            </div>
            <hr>
            <div class="form-group">
                <form method="post" action="chamados.php">
                    <input type="hidden" value="Prevenção" name="sector">
                    <input type="hidden" value="dark" name="classe">
                    <button type="submit" class="form-control btn btn-lg btn-outline-dark">
                        <b> ABRIR CHAMADO P/ PREVENÇÃO</b>
                    </button>
                </form>
            </div>
            <br><br><br><br>
        </div>
    </div>
</div>
</body>
</html>