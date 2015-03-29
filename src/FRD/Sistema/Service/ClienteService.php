<?php

namespace FRD\Sistema\Service;


class ClienteService
{

    function insert(array $data)
    {
        $cliente = new \FRD\Sistema\Entity\Cliente();
        $cliente->setNome($data['nome']);
        $cliente->setEmail($data['email']);
        $cliente->setCpfCnpj($data['cpfCnpj']);

        $mapper = new \FRD\Sistema\Mapper\ClienteMapper();
        return $mapper->insert($cliente);
    }
} 