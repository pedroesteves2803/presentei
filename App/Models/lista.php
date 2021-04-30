<?php

namespace App\Models;

use MF\Model\Model;

class Lista extends Model {
    private $id;
    private $nome;
    private $senha;
    private $data;
    private $texto;
    private $local;
    private $arquivo;


    public function __get($atributo) {
        return $this->$atributo;  
    }

    public function __set($atributo, $valor) {
       $this->$atributo = $valor;
    }

    public function inserirLista() {

        $query = "insert into tb_criarlista(nome_lista, senha_lista, data_lista, local_lista, descricao_lista, id_usuario)
        values(:nome, md5(:senha), :data, :local, :texto, :id)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->bindValue(':data', $this->__get('data'));
        $stmt->bindValue(':local', $this->__get('local'));
        $stmt->bindValue(':texto', $this->__get('texto'));
        $stmt->bindValue(':id', $this->__get('id'));

        $stmt->execute();

        $lista = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if($lista['id_lista'] != '' && $lista['id_lista'] != '') {
            $this->__set('id', $lista['id_lista']);
        }

        return $this;
    }

}

?>
