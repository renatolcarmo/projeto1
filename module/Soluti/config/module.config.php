<?php
return [
    'service_manager' => [
        'factories' => [
            \Soluti\V1\Rest\Certificado\CertificadoResource::class => \Soluti\V1\Rest\Certificado\CertificadoResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'soluti.rest.certificado' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/certificado[/:certificado_id]',
                    'defaults' => [
                        'controller' => 'Soluti\\V1\\Rest\\Certificado\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'soluti.rest.certificado',
        ],
    ],
    'zf-rest' => [
        'Soluti\\V1\\Rest\\Certificado\\Controller' => [
            'listener' => \Soluti\V1\Rest\Certificado\CertificadoResource::class,
            'route_name' => 'soluti.rest.certificado',
            'route_identifier_name' => 'certificado_id',
            'collection_name' => 'certificado',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Soluti\Entity\Certificado::class,
            'collection_class' => \Soluti\V1\Rest\Certificado\CertificadoCollection::class,
            'service_name' => 'Certificado',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Soluti\\V1\\Rest\\Certificado\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'Soluti\\V1\\Rest\\Certificado\\Controller' => [
                0 => 'application/vnd.soluti.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Soluti\\V1\\Rest\\Certificado\\Controller' => [
                0 => 'application/vnd.soluti.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Soluti\V1\Rest\Certificado\CertificadoEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'soluti.rest.certificado',
                'route_identifier_name' => 'certificado_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Soluti\V1\Rest\Certificado\CertificadoCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'soluti.rest.certificado',
                'route_identifier_name' => 'certificado_id',
                'is_collection' => true,
            ],
            \Soluti\Entity\Certificado::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'soluti.rest.certificado',
                'route_identifier_name' => 'certificado_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
        ],
    ],
    'doctrine' => [
        'driver' => [
            'soluti_entities' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    0 => './module/Soluti/src/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Soluti' => 'soluti_entities',
                ],
            ],
        ],
    ],
    'zf-content-validation' => [
        'Soluti\\V1\\Rest\\Certificado\\Controller' => [
            'input_filter' => 'Soluti\\V1\\Rest\\Certificado\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Soluti\\V1\\Rest\\Certificado\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\NotEmpty::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'nome',
                'description' => 'Nome do Certificado',
                'field_type' => 'string',
                'error_message' => 'Informe o Nome do Certificado',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'certificado',
                'description' => 'Certificado Digital',
                'field_type' => 'text',
                'error_message' => 'Informe o Certificado Digital',
            ],
        ],
    ],
    'zf-apigility' => [
        'doctrine-connected' => [],
    ],
    'doctrine-hydrator' => [],
];
