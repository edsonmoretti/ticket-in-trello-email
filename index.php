<?php

if (filter_input(INPUT_POST, 'submit')) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $erroNoUpload = false;
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        //OK
    } else {
        //erro ao fazer upload, ignorar arquivo e proceder com chamado
        $erroNoUpload = true;
    }

    require 'vendor/autoload.php';
    $nome = strtoupper(filter_input(INPUT_POST, 'nome'));
    $loja = strtoupper(filter_input(INPUT_POST, 'loja'));
    $equipamento = strtoupper(filter_input(INPUT_POST, 'equipamento'));
    $descricao = filter_input(INPUT_POST, 'descricao');
    if (is_null(CONFIG_EMAIL_DESTINO_PRINCIPAL) || empty(CONFIG_EMAIL_DESTINO_PRINCIPAL)) {
        $mensagemDeErro = 'Verifique as configurações.';
    } else {
        $email = new \Mail\Email();
        $assunto = '[' . str_replace(' ', '', $loja) . '] ' . $equipamento;
        $corpo = '## Chamado aberto por: ' . $nome
            . PHP_EOL . '### Descrição: ' . PHP_EOL . $descricao;
        $email->add($assunto,
            $corpo,
            'SUPORTE TI',
            CONFIG_EMAIL_DESTINO_PRINCIPAL);
        if (!$erroNoUpload) {
            $email->attach($target_file, 'Foto');
        }
        $email->send([
            CONFIG_EMAIL_DESTINO_2, CONFIG_EMAIL_DESTINO_3
        ]);
        unlink($target_file);
        if (!$error = $email->error()) {
            $mensagemSucesso = 'Abertura de chamado enviado.';
        } else {
            //error
            $mensagemDeErro = $error->getMessage();
        }
    }
//    die();
}
?>
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
    <title>PagMenos - Chamado</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

</body>
</html>

<div class="container fluid">
    <div class="card">
        <?php if (!empty($mensagemSucesso)) { ?>
            <div class="card-header alert bg-success text-white">
                <h5 style="text-align: center"><b><?= $mensagemSucesso ?></b></h5>
            </div>
        <?php }
        if (!empty($mensagemDeErro)) { ?>
            <div class="card-header alert bg-danger text-white">
                <h5 style="text-align: center"><b><?= $mensagemDeErro ?></b></h5>
            </div>
        <?php } ?>
        <div class="card-header">
            <h5 style="text-align: center"><b>PagMenos - TI | Abertura de Chamados</b></h5>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nome"><b>NOME E SOBRENOME</label>
                    <input type="text" required class="form-control" id="nome" name="nome"
                           placeholder="EX.: FULANO DA SILVA">
                </div>
                <div class="form-group">
                    <label for="loja"><b>LOJA</b></label></label>
                    <select required class="form-control" id="loja" name="loja">
                        <option disabled selected>SELECIONE</option>
                        <option value="">LOJA 01</option>
                        <option>LOJA 02</option>
                        <option>LOJA 03</option>
                        <option>LOJA 04</option>
                        <option>LOJA 05</option>
                        <option>LOJA 06</option>
                        <option>LOJA 07</option>
                        <option>LOJA 08</option>
                        <option>LOJA 09</option>
                        <option>LOJA 10</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="equipamento"><b>EQUIPAMENTO</label>
                    <input type="text" required class="form-control" id="equipamento" name="equipamento"
                           placeholder="EX.: MONITOR DO CAIXA 01, IMPRESSORA DO ESCRITÓRIO, ETC...">
                </div>
                <div class="form-group">
                    <label for="descricao"><b>DESCRIÇÃO DO PROBLEMA</b></label>
                    <textarea class="form-control" id="descricao" required name="descricao" rows="5"
                              placeholder="EX.: Monitor do Caixa um não liga mais após queda de energia"></textarea>
                </div>
                <div class="form-group">
                    <label for="descricao"><b>FOTO</b></label>
                    <input id="foto" name="foto" type="file" accept="image/*;capture=camera" class="form-control"/>
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control btn btn-info" name="submit" value="Abertura de Chamado">
                        ABRIR CHAMADO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>