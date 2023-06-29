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
		private $nomeVenda = null;
		private $emailVenda = null;
		private $telefoneVenda = null;
		private $marcaVeiculo = null;
		private $modeloVeiculo = null;
		private $anoFabricacao = null;
		private $kmAtual = null;
		private $corVeiculo = null;
		private $vidroEletrico = null;
		private $tipoDirecao = null;
		private $qtdePortas = null;
		private $travaEletrica = null;
		private $precoSugerido = null;
		private $informacoesAdicionais = null;
		public $status = array('codigo_status' => null, 'descricao_status' => '');

		public function __get($atributo) {
			return $this->$atributo;
		}

		public function __set($atributo, $valor) {
			$this->$atributo = $valor;
		}

		public function mensagemValida(){
			if (empty($this->nomeVenda) ||empty($this->emailVenda) ||empty($this->telefoneVenda) ||empty($this->marcaVeiculo) ||empty($this->modeloVeiculo) ||empty($this->anoFabricacao) ||empty($this->kmAtual)||empty($this->corVeiculo)||empty($this->vidroEletrico)||empty($this->tipoDirecao)||empty($this->qtdePortas)||empty($this->travaEletrica)||empty($this->precoSugerido)) {
				return false;
			}
			return true;
		}
	}

	$mensagem = new Mensagem();

	$mensagem->__set('nomeVenda', $_POST['nomeVenda']);
	$mensagem->__set('emailVenda', $_POST['emailVenda']);
	$mensagem->__set('telefoneVenda', $_POST['telefoneVenda']);
	$mensagem->__set('marcaVeiculo', $_POST['marcaVeiculo']);
	$mensagem->__set('modeloVeiculo', $_POST['modeloVeiculo']);
	$mensagem->__set('anoFabricacao', $_POST['anoFabricacao']);
	$mensagem->__set('kmAtual', $_POST['kmAtual']);
	$mensagem->__set('corVeiculo', $_POST['corVeiculo']);
	$mensagem->__set('vidroEletrico', $_POST['vidroEletrico']);
	$mensagem->__set('tipoDirecao', $_POST['tipoDirecao']);
	$mensagem->__set('qtdePortas', $_POST['qtdePortas']);
	$mensagem->__set('travaEletrica', $_POST['travaEletrica']);
	$mensagem->__set('precoSugerido', $_POST['precoSugerido']);
	$mensagem->__set('informacoesAdicionais', $_POST['informacoesAdicionais']);

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
			$mail->Subject = ('Pedido de venda solicitada por '. $mensagem->__get('nomeVenda'));
			$mail->Body    = '<Strong>SOLICITAÇÃO DE VENDA</strong><br><br>'
							.'<Strong>Nome:</strong> ' . $mensagem->__get('nomeVenda').'<br>'
							.'<Strong>E-mail:</strong> ' . $mensagem->__get('emailVenda').'<br>'
							.'<Strong>Telefone:</strong> ' . $mensagem->__get('telefoneVenda').'<br>'
							.'<Strong>Marca do veículo:</strong> ' . $mensagem->__get('marcaVeiculo').'<br>'
							.'<Strong>Modelo do veículo:</strong> ' . $mensagem->__get('modeloVeiculo').'<br>'
							.'<Strong>Ano de fabricacao:</strong> ' . $mensagem->__get('anoFabricacao').'<br>'
							.'<Strong>Quilometragem atual:</strong> ' . $mensagem->__get('kmAtual').'<br>'
							.'<Strong>Cor do veículo:</strong> ' . $mensagem->__get('corVeiculo')	.'<br>'
							.'<Strong>Veículo possui vidro elétrico?:</strong> ' . $mensagem->__get('vidroEletrico')	.'<br>'
							.'<Strong>Tipo de direção:</strong> ' . $mensagem->__get('tipoDirecao')	.'<br>'
							.'<Strong>Quantidade de portas:</strong> ' . $mensagem->__get('qtdePortas')	.'<br>'
							.'<Strong>Veículo possui trava elétrica?:</strong> ' . $mensagem->__get('travaEletrica')	.'<br>'
							.'<Strong>Preço sugerido pelo veículo:</strong> ' . $mensagem->__get('precoSugerido')	.'<br>'
							.'<Strong>Informações adicionais:</strong> ' . $mensagem->__get('informacoesAdicionais')	.'<br>';

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