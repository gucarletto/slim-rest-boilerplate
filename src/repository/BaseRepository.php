<?php

namespace App\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Classe para operações base com o banco de dados
 * 
 * @author Gustavo Carletto
 */
class BaseRepository
{

  private static $entityManager;
  private static $logger;

  /**
   * Retorna o EntityManager para ser usado na aplicação
   *
   * @return EntityManager
   */
  public static function getEntityManager() {
    if(!self::$entityManager) {
      $sPaths = [__DIR__. "../models"];
      $oConfig = Setup::createAnnotationMetadataConfiguration($sPaths, false, null, null, true);

      $aParams = [
        'host' => getenv('DATABASE_HOST'),
        'user' => getenv('DATABASE_USER'),
        'dbname' => getenv('DATABASE_NAME'),
        'password' => getenv('DATABASE_PASSWORD'),
        'driver' => getenv('DATABASE_DRIVER'),
      ];

      self::$entityManager = EntityManager::create($aParams, $oConfig);
      self::$logger = new \Doctrine\DBAL\Logging\DebugStack();
      self::$entityManager->getConnection()->getConfiguration()->setSQLLogger(self::$logger);
    }
    return self::$entityManager;
  }

}