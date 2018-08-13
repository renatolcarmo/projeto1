<?php
return [
    'Soluti\\V1\\Rest\\Certificado\\Controller' => [
        'description' => 'Serviço para Gerenciamento de Certificados Digitais',
        'collection' => [
            'description' => 'Dados de Certificados',
            'GET' => [
                'description' => 'Lista Certificados',
                'response' => '{
   "_links": {
       "self": {
           "href": "/certificado"
       },
       "first": {
           "href": "/certificado?page={page}"
       },
       "prev": {
           "href": "/certificado?page={page}"
       },
       "next": {
           "href": "/certificado?page={page}"
       },
       "last": {
           "href": "/certificado?page={page}"
       }
   }
   "_embedded": {
       "certificado": [
           {
               "_links": {
                   "self": {
                       "href": "/certificado[/:certificado_id]"
                   }
               }
              "nome": "Nome do Certificado",
              "certificado": "Certificado Digital"
           }
       ]
   }
}',
            ],
            'POST' => [
                'description' => 'Inclui Certificado',
                'request' => '{
   "nome": "Nome do Certificado",
   "certificado": "Certificado Digital"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/certificado[/:certificado_id]"
       }
   }
   "nome": "Nome do Certificado",
   "certificado": "Certificado Digital"
}',
            ],
            'PUT' => [
                'description' => 'Edita Certificado',
                'request' => '{
   "nome": "Nome do Certificado",
   "certificado": "Certificado Digital"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/certificado"
       },
       "first": {
           "href": "/certificado?page={page}"
       },
       "prev": {
           "href": "/certificado?page={page}"
       },
       "next": {
           "href": "/certificado?page={page}"
       },
       "last": {
           "href": "/certificado?page={page}"
       }
   }
   "_embedded": {
       "certificado": [
           {
               "_links": {
                   "self": {
                       "href": "/certificado[/:certificado_id]"
                   }
               }
              "nome": "Nome do Certificado",
              "certificado": "Certificado Digital"
           }
       ]
   }
}',
            ],
        ],
        'entity' => [
            'description' => 'Certificados',
            'GET' => [
                'description' => 'Lista um Certificado',
                'response' => '{
   "_links": {
       "self": {
           "href": "/certificado[/:certificado_id]"
       }
   }
   "nome": "Nome do Certificado",
   "certificado": "Certificado Digital"
}',
            ],
            'PATCH' => [
                'description' => 'Edita um Certificado',
                'request' => '{
   "nome": "Nome do Certificado",
   "certificado": "Certificado Digital"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/certificado[/:certificado_id]"
       }
   }
   "nome": "Nome do Certificado",
   "certificado": "Certificado Digital"
}',
            ],
            'PUT' => [
                'description' => 'Altera um Certificado',
                'request' => '{
   "nome": "Nome do Certificado",
   "certificado": "Certificado Digital"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/certificado[/:certificado_id]"
       }
   }
   "nome": "Nome do Certificado",
   "certificado": "Certificado Digital"
}',
            ],
            'DELETE' => [
                'description' => 'Remove um Certificado',
                'request' => '{
   "nome": "Nome do Certificado",
   "certificado": "Certificado Digital"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/certificado[/:certificado_id]"
       }
   }
   "nome": "Nome do Certificado",
   "certificado": "Certificado Digital"
}',
            ],
        ],
    ],
];
