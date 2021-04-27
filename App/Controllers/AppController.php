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

		$this->render('escolherLista');
		
		// $this->view->senhaConf = true;

	}
}

?>