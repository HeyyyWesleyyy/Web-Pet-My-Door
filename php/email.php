<?php
date_default_timezone_set('America/Sao_Paulo');
require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(($_POST['email'] && !empty(trim($_POST['email']))) && ($_POST['mensagem'] && !empty(trim($_POST['mensagem'])))){
    $nome = !empty($_POST['nome'])?$_POST['nome']:"Não informado";
    $email = !empty($_POST['email'])?trim($_POST['email']):"Não informado";
    $mensagem = !empty($_POST['mensagem'])?trim($_POST['mensagem']):"Não informado";
    $data = date('d/m/Y H:i:s');
    
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'cl19479@g.unicamp.br';
    $mail->Password = 'cl560100036';
    $mail->Port = 587;

    $mail->setFrom('cl19479@g.unicamp.br');
    $mail->addAddress('cl19479@g.unicamp.br');

    $mail->isHTML(true);
    $mail->Subject = "Site Pet My Door";
    $mail->Body = "Nome: {$nome}<br>
                   Email: {$email}<br>
                   Mensagem: {$mensagem}<br>
                   Data:hora: {$data}";

    if($mail->send()) {
        echo 'Email enviado com sucesso.';
    } else {
        echo 'Email não enviado.';
    }
} else {
    echo 'Email não enviado: informar o email e a mensagem.';
}