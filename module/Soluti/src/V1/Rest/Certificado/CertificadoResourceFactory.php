<?php
namespace Soluti\V1\Rest\Certificado;

class CertificadoResourceFactory
{
    public function __invoke($services)
    {
        $em = $services->get('Doctrine\ORM\EntityManager');
        return new CertificadoResource($em);
    }
}
