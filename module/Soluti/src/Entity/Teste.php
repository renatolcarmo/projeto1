<?php
namespace Soluti\Entity;
  
use Doctrine\ORM\Mapping as ORM;
  
/**
 * @ORM\Table(name="testes")
 * @ORM\Entity
 */
class Teste {
  
    /**
     * @ORM\Id
     * @ORM\GeneratedValue("AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\Column(type="text")
     */
    private $certificado;
     
    public function getId() {
        return $this->id;
    }
  
    public function setId($id) {
        $this->id = $id;
    }
  
    public function getNome() {
        return $this->nome;
    }
  
    public function setNome($nome) {
        $this->nome = $nome;
    }
  
    public function getCertificado() {
        return $this->certificado;
    }
  
    public function setCertificado($certificado) {
        $this->certificado = $certificado;
    }
  
}