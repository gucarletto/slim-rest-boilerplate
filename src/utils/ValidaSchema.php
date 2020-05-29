<?php

namespace App\Utils;

use Exception;
use JsonSchema\Constraints\Constraint as Constraint;
use JsonSchema\Validator;

/**
 * ValidaSchemaController
 * 
 * @author Gustavo Carletto
 */
class ValidaSchemaController
{

  private $schemaName;

  public function __construct($schemaName)
  {
    $this->schemaName = $schemaName;
  }

  /**
   * Valida a requisição contra um schema json
   *
   * @param [] $dados
   * @return boolean
   * @throws Exception
   */
  public function validate($dados)
  {
    $schema = json_decode(file_get_contents(sprintf('%s/../schemas/%s.json', __DIR__, $this->getSchemaName())));
    $validator = new Validator();
    $validator->validate($dados, $schema, Constraint::CHECK_MODE_COERCE_TYPES);
    if($validator->isValid()) {
      return true;
    } else {
      $msg = 'O documento enviado é inválido. Erros: %s';
      $errors = [];
      foreach($validator->getErrors() as $error) {
        $errors[] = sprintf("[%s] %s\n", $error['property'], $error['message']);
      }
      throw new Exception(sprintf($msg, implode(', ', $errors)));
    }
  }

  /**
   * Get the value of schemaName
   */
  public function getSchemaName()
  {
    return $this->schemaName;
  }

  /**
   * Set the value of schemaName
   */
  public function setSchemaName($schemaName)
  {
    $this->schemaName = $schemaName;
  }
}
