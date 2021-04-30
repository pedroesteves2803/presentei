<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

	public function validaAutenticacao() {

        session_start();

        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
            header('Location: /?login=login&aut=erro');
        }
    }

	public function logado() {

		$this->validaAutenticacao();

		$this->view->nome = $_SESSION['nome'];

		$this->render('logado');
		
		// $this->view->senhaConf = true;

	}

	public function minhaConta() {

		$this->validaAutenticacao();
		$this->view->usuario = array(
			'nome' => $_SESSION['nome'],
			'email' => $_SESSION['email'],
			'senha' => '',
			'cpf' => $_SESSION['cpf'],
			'confSenha' => '',
			'telefone' => $_SESSION['telefone']
		);
		$this->view->nome = $_SESSION['nome'];

		$this->view->certoSenha = '';
		$this->view->erroSenha = '';

		$this->render('minhaConta');

	}

	public function atualizarUsuario() {

			$this->validaAutenticacao();
			$usuario = Container::getModel('Usuario');

			$usuario->__set('nome', $_POST['nome']);
			$usuario->__set('email', $_POST['email']);
			$usuario->__set('cpf', $_POST['cpf']);
			$usuario->__set('telefone', $_POST['telefone']);
			$usuario->atualizarUsuario($_SESSION['email']);

			$this->view->usuario = array(
				'nome' => $usuario->__get('nome'),
				'email' => $usuario->__get('email'),
				'senha' => '',
				'cpf' => $usuario->__get('cpf'),
				'confSenha' => '',
				'telefone' => $usuario->__get('telefone')
			);
			$this->view->certoSenha = '';
			$this->view->erroSenha = '';
			$this->render('minhaConta');

	}

	//validar senhaaaa

	public function atualizarSenhaUsuario() {
		$this->validaAutenticacao();
		$usuario = Container::getModel('Usuario');
		$usuario->__set('senhaConfirmar', md5($_POST['senhaAntiga']));
		$usuario->__set('senha', md5($_POST['novaSenha']));
		$usuario->__set('email', $_SESSION['email']);

		if($usuario->verificarSenhaAntiga()){

			$usuario->atualizarSenhaUsuario();
	
			$this->view->usuario = array(
				'nome' => $_SESSION['nome'],
				'email' => $_SESSION['email'],
				'senha' => '',
				'cpf' => $_SESSION['cpf'],
				'confSenha' => '',
				'telefone' => $_SESSION['telefone']
			);
			
			$this->view->certoSenha = true;
			$this->view->erroSenha = false;	
			$this->render('minhaConta');
		}else{
			$this->view->usuario = array(
				'nome' => $_SESSION['nome'],
				'email' => $_SESSION['email'],
				'senha' => '',
				'cpf' => $_SESSION['cpf'],
				'confSenha' => '',
				'telefone' => $_SESSION['telefone']
			);
			$this->view->certoSenha = false;	
			$this->view->erroSenha = true;	
			$this->render('minhaConta');


		}
	}

	public function escolherLista() {

		$this->validaAutenticacao();

		$this->view->nome = $_SESSION['nome'];


		$this->render('escolherLista');
		
		// $this->view->senhaConf = true;
		

	}

	public function criarListaCasamento() {

		$this->validaAutenticacao();
		$lista = Container::getModel('Lista');


		$this->view->nome = $_SESSION['nome'];

		$lista->__set('nome', $_POST['nome']);
		$lista->__set('senha', $_POST['senha']);
		$lista->__set('texto', $_POST['texto']);
		$lista->__set('data', $_POST['data']);
		$lista->__set('local', $_POST['local']);
		$lista->__set('arquivo', $_POST['arquivo']);


		$this->view->usuario = array(
			'nomeLista' => $_POST['nome'],
			'senhaLista' => $_POST['senha'],
			'dataLista' => $_POST['data'],
			'localLista' => $_POST['local'],
			'texto' => $_POST['texto'],
			'arquivo' => $_FILES['arquivo']['name']
		);
		
		if(empty($nome) and empty($data) and  empty($local)){
			$this->view->camposCrt = true;
		}

		//Pasta onde o arquivo vai ser salvo
		$_UP['pasta'] = 'fotosListas/';
    
		//Tamanho máximo do arquivo em Bytes
		$_UP['tamanho'] = 1024*1024*100; //5mb
		
		//Array com a extensões permitidas
		$_UP['extensoes'] = array('png', 'jpg', 'jpeg', 'gif');
		
		//Renomeiar
		$_UP['renomeia'] = false;
		
		//Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

		//Faz a verificação do tamanho do arquivo
		if ($_UP['tamanho'] < $_FILES['arquivo']['size']){
			$this->view->tamanhosIncorreto = true;			
		}

    //O arquivo passou em todas as verificações, hora de tentar move-lo para a pasta foto
    	else{
        //Primeiro verifica se deve trocar o nome do arquivo
        if($_UP['renomeia'] == true){
            //Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
            $nome_final = time().'.jpg';
        }else{
            //mantem o nome original do arquivo
            $nome_final = $_FILES['arquivo']['name'];
        }
        //Verificar se é possivel mover o arquivo para a pasta escolhida
        if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta']. $nome_final)){
            //Upload efetuado com sucesso, exibe a mensagem
			$this->view->inserido = true;
            
			$this->render('inserirLista');
                          
            	
        }else{

			$this->view->inserido = false;
			$this->render('criarListaCasamento');


        }
    }		
		
		// $this->view->senhaConf = true;

	}
}

?>