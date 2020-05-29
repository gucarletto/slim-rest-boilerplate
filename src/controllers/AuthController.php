<?php

namespace App\Controllers;

use App\Models\Usuario;
use Firebase\JWT\JWT;

/**
 * Classe para autenticação na API
 *
 * @author Gustavo Carletto
 */
class AuthController extends BaseController
{

  private $usuario;
  private $senha;
  private $secret;

  /**
   * Efetua login com usuário, senha e rede
   *
   * @return mixed
   */
  public function login() {
    $oUsuario = $this->getEntityManager()->getRepository('App\Models\Usuario')->findOneBy([
      'login' => $this->usuario
      , 'senha' => hash('sha256', $this->senha)
    ]);
    return $oUsuario;
  }

  /**
   * Verifica o token validado para o JWT ainda existe para algum usuário
   *
   * @param string $sToken
   * @return bool
   */
  public function tokenExists($sToken)  {
    $oUsuario = $this->getEntityManager()->getRepository('App\Models\Usuario')->findOneBy([
      'token' => $sToken
    ]);
    return ($oUsuario) ? true : false;
  }

  /**
   * Atualiza o token de acordo com o token o usuário, senha e a rede
   *
   * @return string
   */
  public function refreshToken()
  {
    $now = time();
    $exp = time()+(2*60*60);
    $token = [
      'usuario' => $this->getUsuario(),
      'senha' => $this->getSenha(),
      'iat' => $now,
      'exp' => $exp
    ];
    return JWT::encode($token, $this->getSecret());
  }

  /**
   * Atualiza o token do usuário
   *
   * @param Usuario $oUsuario
   * @param string $sToken
   * @return void
   */
  public function refreshTokenUsuario($oUsuario, $sToken) {
    $oUsuario->setToken($sToken);
    $this->getEntityManager()->persist($oUsuario);
    $this->getEntityManager()->flush($oUsuario);
  }

  /**
   * Get the value of usuario
   *
   * @return string
   */
  public function getUsuario()
  {
    return $this->usuario;
  }

  /**
   * Set the value of usuario
   *
   * @param string $sUsuario
   */
  public function setUsuario($sUsuario)
  {
    $this->usuario = $sUsuario;
  }

  /**
   * Get the value of senha
   *
   * @return string
   */
  public function getSenha()
  {
    return $this->senha;
  }

  /**
   * Set the value of senha
   *
   * @param string $sSenha
   */
  public function setSenha($sSenha)
  {
    $this->senha = $sSenha;
  }

  /**
   * Get the value of secret
   *
   * @return string
   */
  public function getSecret()
  {
    return $this->secret;
  }

  /**
   * Set the value of secret
   *
   * @param string $secret
   */
  public function setSecret($secret)
  {
    $this->secret = $secret;
  }

}
