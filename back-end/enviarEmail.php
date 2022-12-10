<?php
    session_start();

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Usuario;
    use APBPDN\Services\RequestService;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require "vendor/autoload.php";
    require "credenciais-email.php";

    try{    
        $emailUsuario = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('email');
    }catch(\Exception $e){
        header('HTTP/1.1 500 Internal Server Error');   
        echo $e->getMessage();
        exit();
    }

    $entityManager = EntityManagerCreator::create();

    $usuarioRepository = $entityManager->getRepository(Usuario::class);

    $usuario = $usuarioRepository->findOneBy(['email' => $emailUsuario]);

    if(!$usuario){
        header('HTTP/1.1 500 Internal Server Error');   
        echo "E-mail inválido";
        exit();
    }

    
    $_SESSION['idDoUsuarioQueQuerRedefinirSenha'] = $usuario->id;
    $_SESSION['nomeDoUsuarioQueQuerRedefinirSenha'] = $usuario->getNome();

    try {
     
        $mail = new PHPMailer(true);

        //Server settings
        $mail->isSMTP();                                          
        $mail->Host = HOST_EMAIL;                     
        $mail->SMTPAuth = true;                                 
        $mail->Username = USER_EMAIL;                 
        $mail->Password = PASSWORD_EMAIL;                 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
        $mail->Port = 465;     
    
        //Recipients
        $mail->setFrom(USER_EMAIL);
        $mail->addAddress($emailUsuario);    
            
        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = 'Redefinir senha';
        $chave =  substr(md5(date('dmYHis')), 0, 5);
        $mail->Body = 
        '
            <p style="font-size: 35px;">A chave de segurança é: </p> 
            <div style="background-color: rgb(191, 191, 191); width: 200px; text-align:center">
                <strong style="font-size: 40px;">'.$chave.'</strong>
            </div>
            
        ';
        
    
        $mail->AltBody = 'A chave de segurança é: '.$chave;
    
        if($mail->send()){
            $_SESSION['chave'] = $chave;
            $_SESSION['emailParaQualFoiEnviado'] = $emailUsuario;
            header('HTTP/1.1 200 OK');
        }else{
            throw new Exception();
        }


    } catch (Exception $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }

    
?>