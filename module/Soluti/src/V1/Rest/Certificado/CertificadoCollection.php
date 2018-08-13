<?php
namespace Soluti\V1\Rest\Certificado;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

class CertificadoCollection extends Paginator
{
    public function __construct($certificadoCollection) {
        parent::__construct(new ArrayAdapter($certificadoCollection));
    }
}
