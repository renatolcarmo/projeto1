<?php
namespace Soluti\V1\Rest\Certificado;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

use RB\Sphinx\Hmac\HMAC;
use RB\Sphinx\Hmac\Algorithm\HMACv0;
use RB\Sphinx\Hmac\Hash\PHPHash;
use RB\Sphinx\Hmac\Key\StaticKey;
use RB\Sphinx\Hmac\Nonce\SimpleTSNonce;
use RB\Sphinx\Hmac\Exception\HMACException;

class CertificadoResource extends AbstractResourceListener
{

    private $em;

    public function __construct($em) {
        $this->em = $em;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {        
        try{
            $certificado = new \Soluti\Entity\Certificado();
            $certificado->setNome($data->nome);
            $certificado->setCertificado($data->certificado);

            $this->em->persist($certificado);
            $this->em->flush();
            return true;

        } catch(Exception $e){
            return new ApiProblem(405, $e->getMessage());
        }
        
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        try{
            $certificado = $this->em->find("Soluti\Entity\Certificado", $id); 
            
            $this->em->remove($certificado);
            $this->em->flush();
            return true;

        } catch(Exception $e){
            return new ApiProblem(405, $e->getMessage());
        }
        
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('e');
        $qb->from('Soluti\Entity\Certificado', 'e');
        $qb->where('e.id = :id');
        
        $qb->setParameters(array(
            'id' => $id
        ));

        $data = $qb->getQuery()->getArrayResult();

        if(isset($data[0])){
            $certEncrypt = isset($data[0]["certificado"]) ? $data[0]["certificado"] : '';

            $cert = $this->infoCertificate( $certEncrypt );
            unset($data[0]["certificado"]);

            //var_dump($data); exit;
            return array_merge($data[0], $cert);
        }else{
            return $data;
        }
        
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('e');
        $qb->from('Soluti\Entity\Certificado', 'e');

        $data = $qb->getQuery()->getArrayResult();
        
        foreach($data as $key=>$val){
            unset($data[$key]["certificado"]);
        }

        return new CertificadoCollection($data);
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        try{
            $certificado = $this->em->find("Soluti\Entity\Certificado", $id); 
            $certificado->setNome($data->nome);
            $certificado->setCertificado($data->certificado);

            $this->em->merge($certificado);
            $this->em->flush();
            return true;

        } catch(Exception $e){
            return new ApiProblem(405, $e->getMessage());
        }
        
    }

    /**
     * Gera Informações do Cetificado
     *
     * @param  mixed $encrypt
     * @return Array
     */
    public function infoCertificate($encrypt)
    {

        if(stristr($encrypt,'CERTIFICATE')){
            $x509 = new \phpseclib\File\X509();
            $cert = $x509->loadX509($encrypt);
        }else{
            $cert = false;
        }

        //print_r($cert); exit;
        
        if($cert){
            $info = array(
                'subject_dn' => $this->rdnSequence($cert["tbsCertificate"]["subject"]["rdnSequence"]),
                'issuer_dn' => $this->rdnSequence($cert["tbsCertificate"]["issuer"]["rdnSequence"]),
                'valid_bf' => $cert["tbsCertificate"]["validity"]["notBefore"]["utcTime"],
                'valid_af' => $cert["tbsCertificate"]["validity"]["notAfter"]["utcTime"]
            );

        }else{
            $info = array(
                'subject_dn' => '',
                'issuer_dn' => '',
                'valid_bf' => '',
                'valid_af' => ''
            );
        }

        return $info;
    }

    /**
     * Gera string Subject e Issuer
     *
     * @param  mixed $data
     * @return Array
     */
    public function rdnSequence($data)
    {
        $dn = '';
        foreach($data as $s){
            switch($s[0]["type"]){
                case 'id-at-countryName' :
                    $dn.='C=' . $s[0]["value"]["printableString"];
                    break;
                case 'id-at-organizationName' :
                    $dn.=', O=' . $s[0]["value"]["printableString"];
                    break;
                case 'id-at-organizationalUnitName' :
                    $dn.=', OU=' . $s[0]["value"]["printableString"];
                    break;
                case 'id-at-commonName' :
                    $dn.=', CN=' . $s[0]["value"]["printableString"];
                    break;
            }
        }
        return $dn;
    }
 
    public function rbHmac($data)
    {
        $hmacServer = new HMAC( new HMACv0(), new PHPHash('sha1'), new StaticKey( 'SEGREDO123' ), new SimpleTSNonce ( 4 ) );
        $hmacServer->setKeyId ( 'IDaplicacao' );
        $hmacServer->setNonceValue ( $nonceRecebido );
        try {
            $hmacServer->validate ( $mensagemRecebida, $hmacRecebido );
            echo 'HMAC Válido', PHP_EOL;
        } catch( HMACException $exception ) {
            echo 'HMAC Inválido: ', $exception->getMessage(), PHP_EOL;
        }
    }

}
