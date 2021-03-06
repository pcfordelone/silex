<?php

namespace FRD\Sistema\Controllers;


use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ProdutosController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        Request::enableHttpMethodParameterOverride();

        $produtos = $app['controllers_factory'];

        $produtos->get("/", function() use($app) {
            $dados = $app['ProdutoService']->fetchAll();

            return $app['twig']->render('produtos.twig',['produtos'=>$dados]);
        })->bind("prod");

        $produtos->get("/{id}", function($id) use($app) {
            $dados = $app['ProdutoService']->find($id);

            return $app['twig']->render('produto.twig',['produto'=>$dados]);
        });

        $produtos->post("/", function(Request $request) use($app) {
            $data['nome'] = $request->get('nome');
            $data['descricao'] = $request->get('descricao');
            $data['valor'] = floatval($request->get('valor'));

            $constraint = new Assert\Collection(array(
                'nome' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5))),
                'valor' => array(new Assert\NotBlank(), new Assert\Type(array('type' => 'float'))),
                'descricao'  => new Assert\Length(array('min' => 10)),
            ));

            $errors = $app['validator']->validateValue($data, $constraint);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo $error->getPropertyPath().' '.$error->getMessage()."<br/>\n";
                }
                return false;
            }

            $app['ProdutoService']->insert($data);

            $dados = $app['ProdutoService']->fetchAll();
            $alert = "Produto {$request->get('nome')} adicionado com sucesso";

            return $app['twig']->render('produtos.twig',['produtos'=>$dados, 'alert'=>$alert]);

        })->bind('cadastrar_produto');

        $produtos->put("/{id}", function(Request $request, $id) use($app) {
            $data['id'] = $id;
            $data['nome'] = $request->get('nome');
            $data['descricao'] = $request->get('descricao');
            $data['valor'] = floatval($request->get('valor'));

            $constraint = new Assert\Collection(array(
                'id' => new Assert\NotBlank(),
                'nome' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5))),
                'valor' => array(new Assert\NotBlank(), new Assert\Type(array('type' => 'float'))),
                'descricao'  => new Assert\Length(array('min' => 10)),
            ));

            $errors = $app['validator']->validateValue($data, $constraint);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo $error->getPropertyPath().' '.$error->getMessage()."<br/>\n";
                }
                return false;
            }

            $app['ProdutoService']->update($data, $id);

            $dados = $app['ProdutoService']->fetchAll();
            $alert = "Produto {$request->get('nome')} atualizado com sucesso";

            return $app['twig']->render('produtos.twig',['produtos'=>$dados, 'alert'=>$alert]);

        })->bind('atualizar_produto');

        $produtos->delete("/{id}", function($id, Request $request) use($app) {
            $alert = "produto {$request->get('nome')} excluido com sucesso ";
            $app['ProdutoService']->delete($id);

            $dados = $app['ProdutoService']->fetchAll();

            return $app['twig']->render('produtos.twig',['produtos'=>$dados, 'alert'=>$alert]);

        })->bind('apagar_produto');

        return $produtos;
    }

} 