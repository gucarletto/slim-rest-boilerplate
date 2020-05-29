<?php

namespace App\Controllers;

use App\Repository\BaseRepository;
use App\Utils\ValidaSchemaController;
use Doctrine\ORM\EntityManager;

/**
 * Classe base para os controllers da aplicação
 * 
 * @author Gustavo Carletto
 */
abstract class BaseController
{

  /**
   * Retorna um EntityManager para os controllers que o extendem
   *
   * @return EntityManager
   */
  public function getEntityManager()
  {
    return BaseRepository::getEntityManager();
  }

  public function validaSchema($dados, $schema) {
    $validador = new ValidaSchemaController($schema);
    $validador->validate($dados);
  }

}