<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['cadastro'] = array(
			'route' => '/cadastro',
			'controller' => 'indexController',
			'action' => 'cadastro'
		);

		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);

		$routes['login'] = array(
			'route' => '/login',
			'controller' => 'indexController',
			'action' => 'login'
		);
		
		$routes['logar'] = array(
			'route' => '/logar',
			'controller' => 'AuthController',
			'action' => 'logar'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$routes['logado'] = array(
			'route' => '/logado',
			'controller' => 'AppController',
			'action' => 'logado'
		);

		$routes['minhaConta'] = array(
			'route' => '/minhaConta',
			'controller' => 'AppController',
			'action' => 'minhaConta'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$routes['atualizarUsuario'] = array(
			'route' => '/atualizarUsuario',
			'controller' => 'AppController',
			'action' => 'atualizarUsuario'
		);

		$routes['atualizarSenhaUsuario'] = array(
			'route' => '/atualizarSenhaUsuario',
			'controller' => 'AppController',
			'action' => 'atualizarSenhaUsuario'
		);

		$routes['escolherLista'] = array(
			'route' => '/escolherLista',
			'controller' => 'AppController',
			'action' => 'escolherLista'
		);
		
		$routes['perguntasFrequentes'] = array(
			'route' => '/perguntasFrequentes',
			'controller' => 'indexController',
			'action' => 'perguntasFrequentes'
		);

		$this->setRoutes($routes);
	}

}

?>