<?php

namespace FRD\Sistema\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="produtos")
 */

class Produto
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    /**
     * @ORM\Column(type="float")
     */
    private $valor;

    public function setId($id) { $this->id = $id; return $this; }
    public function getId() { return $this->id; }

    public function setNome($nome) { $this->nome = $nome; return $this; }
    public function getNome() { return $this->nome; }

    public function setDescricao($descricao) { $this->descricao = $descricao; return $this; }
    public function getDescricao() { return $this->descricao; }

    public function setValor($valor) { $this->valor = $valor; return $this; }
    public function getValor() { return $this->valor; }
}