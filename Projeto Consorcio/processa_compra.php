<?php
	
	require "./bibliotecas/PHPMailer/Exception.Php";
	require "./bibliotecas/PHPMailer/OAuth.Php";
	require "./bibliotecas/PHPMailer/OAuthTokenProvider.Php";
	require "./bibliotecas/PHPMailer/PHPMailer.Php";
	require "./bibliotecas/PHPMailer/POP3.Php";
	require "./bibliotecas/PHPMailer/SMTP.Php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	class Mensagem {
		private $nome = null;
		private $email = null;
		private $telefone = null;
		private $marcaPreferencia = null;
		private $modeloPreferencia = null;
		private $corEspecifica = null;
		private $faixaPreco = null;
		private $infoAdicionais = null;
		public $status = array('codigo_status' => null, 'descricao_status' => '');

		public function __get($atributo) {
			return $this->$atributo;
		}

		public function __set($atributo, $valor) {
			$this->$atributo = $valor;
		}

		public function mensagemValida(){
			if (empty($this->nome) ||empty($this->email) ||empty($this->telefone) ||empty($this->marcaPreferencia) ||empty($this->modeloPreferencia) ||empty($this->corEspecifica) ||empty($this->faixaPreco)) {
				return false;
			}
			return true;
		}
	}

	$mensagem = new Mensagem();

	$mensagem->__set('nome', $_POST['nome']);
	$mensagem->__set('email', $_POST['email']);
	$mensagem->__set('telefone', $_POST['telefone']);
	$mensagem->__set('marcaPreferencia', $_POST['marcaPreferencia']);
	$mensagem->__set('modeloPreferencia', $_POST['modeloPreferencia']);
	$mensagem->__set('corEspecifica', $_POST['corEspecifica']);
	$mensagem->__set('faixaPreco', $_POST['faixaPreco']);
	$mensagem->__set('infoAdicionais', $_POST['infoAdicionais']);

	if(!$mensagem->mensagemValida()) {
		echo"<script>alert('Erro ao enviar. Verifique se os campos obrigatórios foram preenchidos!')</script>";
		echo"<script>window.location.replace('index.php')</script>";
		die();
		
	}


	$mail = new PHPMailer(true);

	try {
			//Server settings
			$mail->SMTPDebug = false;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'marcio.consultoria.oficial@gmail.com';                     //SMTP username
			$mail->Password   = 'jdvmqvpzxkkrolwi';                               //SMTP password
			$mail->SMTPSecure = 'tls';//PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom('marcio.consultoria.oficial@gmail.com', 'MARCIO ALCANTARA - Consultor especializado');
			$mail->addAddress('marcio.consultoria.oficial@gmail.com');     //Add a recipient
			//$mail->addAddress('ellen@example.com');               //Name is optional
			//$mail->addReplyTo('info@example.com', 'Information');
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			//Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = ('Pedido de compra solicitada por '.$mensagem->__get('nome'));
			$mail->Body    = '<Strong>SOLICITAÇÃO DE COMPRA</strong><br><br>'
							.'<Strong>Nome:</strong> ' . $mensagem->__get('nome').'<br>'
							.'<Strong>E-mail:</strong> ' . $mensagem->__get('email').'<br>'
							.'<Strong>Telefone:</strong> ' . $mensagem->__get('telefone').'<br>'
							.'<Strong>Marca de Preferência:</strong> ' . $mensagem->__get('marcaPreferencia').'<br>'
							.'<Strong>Modelo de Preferência:</strong> ' . $mensagem->__get('modeloPreferencia').'<br>'
							.'<Strong>Cor especifica:</strong> ' . $mensagem->__get('corEspecifica').'<br>'
							.'<Strong>Faixa de preço:</strong> ' . $mensagem->__get('faixaPreco').'<br>'
							.'<Strong>Informações adicionais:</strong> ' . $mensagem->__get('infoAdicionais')	.'<br>';

			$mail->AltBody = 'É necessario usar um client que suporte HTML para obter todos os recursos dessa mensagem';

			$mail->send();

			
			$mensagem->status['codigo_status'] = 1;
			$mensagem->status['descricao_status'] = 'Email enviado com sucesso';
			

	} catch (Exception $e) {

			$mensagem->status['codigo_status'] = 2;
			$mensagem->status['descricao_status'] = 'Não foi possivel enviar este e-mail! Por favor tente novamente mais tarde. Detalhes do erro' . $mail->ErrorInfo;
			//alguma lógica que armazena algum possivel erro
	}


	if ($mensagem->status['codigo_status'] == 1) {
		echo"<script>alert('Email enviado com sucesso, Por favor aguardar retorno!')</script>";
		echo"<script>window.location.replace('index.php')</script>";
	} 

	if ($mensagem->status['codigo_status'] == 2) {
		echo"<script>alert('Não foi possivel enviar este e-mail! Por favor tente novamente mais tarde')</script>";
		echo"<script>window.location.replace('index.php')</script>";
	} 


?>