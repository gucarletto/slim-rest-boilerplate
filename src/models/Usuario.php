<?php
declare(strict_types=1);

namespace App\Models;

use JsonSerializable;

/**
 * User
 *
 * @Table(name="usuarios")
 * @Entity
 * 
 * @author Gustavo Carletto
 */
class Usuario implements JsonSerializable
{
  /**
	 * @var int
	 *
	 * @Column(name="id", type="integer", nullable=false)
	 * @Id
	 * @GeneratedValue(strategy="IDENTITY")
	 */
  private $id;

  /**
	 * @var string
	 *
	 * @Column(name="login", type="string", length=30, nullable=false, unique=true)
	 */
  private $login;

  /**
	 * @var string
	 *
	 * @Column(name="nome", type="string", length=70, nullable=false)
	 */
  private $nome;

  /**
	 * @var string
	 *
	 * @Column(name="email", type="string", length=70, nullable=false, unique=true)
	 */
  private $email;

  /**
	 * @var string
	 *
	 * @Column(name="senha", type="string", length=20, nullable=false)
	 */
  private $senha;

  /**
	 * @var string
	 *
	 * @Column(name="token", type="string", length=256)
	 */
  private $token;

  /**
   * @return int
   */
  public function getId(): int
  {
    return $this->id;
  }

  /**
   * @param int $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  /**
   * @return string
   */
  public function getLogin(): string
  {
    return $this->login;
  }

  /**
   * @param string $login
   */
  public function setLogin($login) {
    $this->login = $login;
  }

  /**
   * @return string
   */
  public function getNome(): string
  {
    return $this->nome;
  }

  /**
   * @param string $nome
   */
  public function setNome($nome) {
    $this->nome = $nome;
  }

  /**
   * @return string
   */
  public function getEmail(): string
  {
    return $this->email;
  }

  /**
   * @param string $email
   */
  public function setEmail($email) {
    $this->email = $email;
  }

  /**
   * @return string
   */
  public function getSenha(): string
  {
    return $this->senha;
  }

  /**
   * @param string $senha
   */
  public function setSenha($senha) {
    $this->senha = $senha;
  }

  /**
   * @return array
   */
  public function jsonSerialize()
  {
    return [
      'id' => $this->id,
      'login' => $this->login,
      'nome' => $this->nome,
      'email' => $this->email,
    ];
  }

  /**
   * Get the value of token
   *
   * @return string
   */ 
  public function getToken()
  {
    return $this->token;
  }

  /**
   * Set the value of token
   *
   * @param  string  $token
   */ 
  public function setToken(string $token)
  {
    $this->token = $token;
  }
}
