<?php 
defined('BASEPATH') OR exit('Ação não permitida.');
class Email extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function send($assunto, $msg, $destinatario){
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'andy.it.0927@gmail.com';
        $mail->Password = '229533As@';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        //email de envio
        $mail->setFrom('andy.it.0927@gmail.com', 'Andressa envio');
        $mail->addReplyTo('andressa@ip3turbo.com.br', 'Andressa Copia');
        //email do remetente
        $mail->addAddress($destinatario);
        //Email subject
        $mail->Subject = $assunto;
        //Informar formato html
        $mail->isHTML(true);
        //Corpo do email
        $mailContent = $msg;
        $mail->Body = $mailContent;
        if(!$mail->send()){
            echo 'Menssagem nao foi enviada. <br>';
            echo 'Mailer Error: '.$mail->ErrorInfo;            
        }else{
            echo 'Menssagem enviada';
        }
    }
}