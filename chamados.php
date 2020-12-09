<?php
require 'vendor/autoload.php';

if (is_null(CONFIG_EMAIL_TI_1) || empty(CONFIG_EMAIL_TI_1)) {
    echo 'Error: E-mail destino não configurado. Entre em contato com suporte.';
    die();
}
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
    $setor = filter_input(INPUT_POST, 'sector');

    if ($setor && ($setor == 'TI' || $setor == 'Operações' || $setor == 'DP/RH')) {
    } else {
        echo 'Error: Setor destino desconhecido.';
        echo '<button onclick="window.history.back();">Voltar</button>';
        die();
    }


    $nome = strtoupper(filter_input(INPUT_POST, 'nome'));
    $loja = strtoupper(filter_input(INPUT_POST, 'loja'));
    $equipamento = strtoupper(filter_input(INPUT_POST, 'equipamento'));
    $descricao = filter_input(INPUT_POST, 'descricao');
    $whatsapp = filter_input(INPUT_POST, 'whatsapp');
    $whatsapp = str_replace(' ', '', trim($whatsapp)) ;

    if (is_null(CONFIG_EMAIL_TI_1) || empty(CONFIG_EMAIL_TI_1)) {
        $mensagemDeErro = 'Verifique as configurações.';
    } else {
        $email = new \Mail\Email();
        $assunto = '[' . $loja . '][' . ($codigoChamado = date('Hismyd')) . '] ' . $equipamento;
        $corpo = '## Chamado aberto por: ' . $nome
            . PHP_EOL . '### Descrição: '
            . PHP_EOL . $descricao
            . PHP_EOL . '------------------------'
            . PHP_EOL . PHP_EOL . 'Link para WhatsApp: https://wa.me/55' . $whatsapp . '?text=' . urlencode('Retorno ao Chamado: ' . $assunto . '. Aberto em: ' . date('d/m/Y H:i:s'));
        $emailDestino = CONFIG_EMAIL_TI_1;
        switch ($setor) {
            case 'DP/RH':
                $emailDestino = CONFIG_EMAIL_DP_RH_1;
                break;
            case 'Operações':
                $emailDestino = CONFIG_EMAIL_OPERACOES_1;
                break;
            case 'TI':
            default:
                $emailDestino = CONFIG_EMAIL_TI_1;
                break;

        }
        $email->add($assunto,
            $corpo,
            $setor,
            $emailDestino);
        if (!$erroNoUpload) {
            $email->attach($target_file, 'Foto');
        }
        $email->send();
        if (file_exists($target_file) && is_file($target_file)) {
            unlink($target_file);
        }
        if (!$error = $email->error()) {
            $mensagemSucesso = 'Abertura de chamado enviado.<br><br><h1 class="">Código do chamado: <strong>' . $codigoChamado . '</strong></h1><br>';
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
    <link rel="shortcut icon" href="imgs/favicon.png"/>
    <link rel="icon" href="imgs/favicon.png"/>
    <title>PagMenos - Chamado</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container fluid">
    <div class="card border-danger">
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
        <div style="text-align: center"
             class="card-header bg-<?= filter_input(INPUT_POST, 'sector') == 'TI' ? 'danger' : 'info' ?> text-white">
            <p><img src="imgs/logo.png" class="img-fluid" style="max-width: 300px"/></p>
            <p><h5><b>PagMenos - <?= filter_input(INPUT_POST, 'sector') ?> | Abertura de Chamados</b></h5></p>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nome"><b>NOME E SOBRENOME</label>
                    <input type="text" required class="form-control" id="nome" name="nome"
                           onblur="if(!document.getElementById('nome').value.trim().includes(' ')){alert('Nome inválido!');}"
                           placeholder="EX.: FULANO DA SILVA">
                </div>
                <div class="form-group">
                    <label for="nome"><b>WhatsApp para Retorno</label>
                    <input type="text" required class="form-control" id="whatsapp" name="whatsapp"
                           onblur="if(document.getElementById('whatsapp').value.length < 11){alert('WhatsApp inválido Coloque o DDD e o Telefone. Ex.: 81982010200!');}"
                           placeholder="Telefone com DDD. EX.: 81982010200">
                </div>
                <div class="form-group">
                    <label for="loja"><b>LOJA</b></label></label>
                    <select required class="form-control" id="loja" name="loja">
                        <!--                        temos lojas 1, 2, 4, 5, 6, 8, 9, 10, 11, 12, Empório e Panini-->
                        <option disabled selected>SELECIONE</option>
                        <option>LOJA 01</option>
                        <option>LOJA 02</option>
                        <option>LOJA 04</option>
                        <option>LOJA 05</option>
                        <option>LOJA 06</option>
                        <option>LOJA 08</option>
                        <option>LOJA 09</option>
                        <option>LOJA 10</option>
                        <option>LOJA 11</option>
                        <option>LOJA 12</option>
                        <option>EMPÓRIO PRIME</option>
                        <option>PANINI</option>
                        <option>ESCRITÓRIO</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="equipamento"><b>ASSUNTO</label>
                    <input type="text" required class="form-control" id="equipamento" name="equipamento"
                           placeholder="EX.: MONITOR DO CAIXA 01, IMPRESSORA DO ESCRITÓRIO, ETC...">
                </div>
                <div class="form-group">
                    <label for="descricao"><b>DESCRIÇÃO DO PROBLEMA</b></label>
                    <textarea class="form-control" id="descricao" required name="descricao" rows="5"
                              placeholder=""></textarea>
                </div>
                <div class="form-group">
                    <label for="descricao"><b>FOTO</b></label>
                    <input id="foto" name="foto" type="file" accept="application/pdf,image/*;capture=camera" class="form-control"/>
                </div>
                <div class="form-group">
                    <hr>
                    <br>
                    <input type="hidden" value="<?= filter_input(INPUT_POST, 'sector') ?>" name="sector">
                    <button type="submit"
                            class="form-control btn btn-lg btn-outline-<?= filter_input(INPUT_POST, 'sector') == 'TI' ? 'danger' : 'info' ?>"
                            name="submit"
                            value="Abertura de Chamado">
                        <b> ABRIR CHAMADO</b>
                    </button>
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
            </form>
        </div>
    </div>
</div>
</body>
</html>