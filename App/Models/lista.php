<?php

namespace App\Models;

use MF\Model\Model;

class Lista extends Model {
    private $id;
    private $nome;
    private $img;
    private $data;
    private $texto;
    private $local;
    private $arquivo;
    private $url;

    //lista


    public function __get($atributo) {
        return $this->$atributo;  
    }

    public function __set($atributo, $valor) {
       $this->$atributo = $valor;
    }

    public function inserirLista() {

        $query = "insert into tb_criarlista(nome_lista, data_lista, local_lista, descricao_lista, img_lista, id_usuario)
        values(:nome, :data, :local, :texto, :img, :id)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':img', $this->__get('img'));
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
