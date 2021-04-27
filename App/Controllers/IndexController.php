<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$this->view->btnLogin = isset($_GET['login']) ? $_GET['login'] : '';
		$this->view->loginErro = isset($_GET['aut']) ? $_GET['aut'] : '';

		$this->render('index');
	}


	public function cadastro() {

		$this->view->login = false;
		$this->view->txtFalta = false;
		$this->view->txt = '';
		$this->view->senhaConf = false;
		$this->view->loginErro = false;
		
		$this->view->usuario = array(
			'nome' => '',
			'email' => '',
			'senha' => '',
			'cpf' => '',
			'confSenha' => '',
			'telefone' => '',
		);


		$this->render('cadastro');
	}

	public function login() {
		header('Location: /');
	}

	public function registrar(){
		$usuario = Container::getModel('Usuario');

		$this->view->login = false; 
		$this->view->txtFalta = false;
		$this->view->txt = '';
		$this->view->senhaConf = false;
		$this->view->loginErro = false;

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', md5($_POST['senha']));
		$usuario->__set('cpf', $_POST['cpf']);
		$usuario->__set('telefone', $_POST['telefone']);
		$usuario->__set('senhaConfirmar', md5($_POST['confSenha']));

		if($usuario->validarCadastro()) {

			$pkCount = (is_array($usuario->getUsuarioPorEmail()) ? count($usuario->getUsuarioPorEmail()) : 0);
			if($pkCount == 0) {

				if($_POST['senha'] == $_POST['confSenha']) {
					$this->view->usuario = array(
						'nome' => '',
						'email' => '',
						'senha' => '',
						'cpf' => '',
						'confSenha' => '',
						'telefone' => '',
					);
	
					$usuario->salvar();

					$this->view->login = true;				
			
					$this->render('cadastro');

				} else {

					$this->view->usuario = array (
						'nome' =>$_POST['nome'],
						'email' =>$_POST['email'],
						'senha' =>$_POST['senha'],
						'cpf' =>$_POST['cpf'],
						'confSenha' => '',
						'telefone' => $_POST['telefone']
					);

					$this->view->senhaConf = true;

					$this->render('cadastro');
				}

			} else {


				$this->view->usuario = array (
					'nome' =>$_POST['nome'],
					'email' =>$_POST['email'],
					'senha' =>$_POST['senha'],
					'cpf' =>$_POST['cpf'],
					'confSenha' => '',
					'telefone' => $_POST['telefone']
				);

				$this->view->loginErro = true;
	
				$this->render('cadastro');

			}

		

		} else {

			$this->view->usuario = array (
				'nome' =>$_POST['nome'],
				'email' =>$_POST['email'],
				'senha' =>$_POST['senha'],
				'cpf' =>$_POST['cpf'],
				'confSenha' => '',
				'telefone' => $_POST['telefone']
			);

			$txt = $usuario->validarCadastroTxt();			
			$this->view->txt = $txt;

			$this->view->txtFalta = true;

			$this->render('cadastro');

		}

	}

	public function perguntasFrequentes(){
		$this->render('perguntasFrequentes');
	}


}

?>

