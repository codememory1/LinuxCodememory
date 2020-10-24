<?php

return [
    
    'Html' => [
        
        'default' => [
            '<option value="null" selected>Null</option>',
            '<option value="date">Date</option>',
            '<option value="datetime">Date_Time</option>',
            '<option value="time">Time</option>',
            '<option value="autonumber">Auto Number</option>',
            '<option value="token">Token</option>'
        ],
        'type' => [
            '<option value="int" selected>Int</option>',
            '<option value="string">String</option>',
            '<option value="float">Float</option>',
            '<option value="json">Json</option>',
            '<option value="array">Array</option>',
            '<option value="object">Object</option>',
            '<option value="date">Date</option>',
            '<option value="datetime">Date_Time</option>'
        ],
        
    ],
    
    'Model' => [
		
        'FieldsSettings' => [
            'type' => [
                'INT'       => 'typeInt',
                'STRING'    => 'typeString',
                'FLOAT'     => 'typeFloat',
                'JSON'      => 'typeJson',
                'ARRAY'     => 'typeArray',
                'OBJECT'    => 'typeObject',
                'DATE'      => 'typeDate',
                'DATETIME'  => 'typeDateTime'
            ],
            
            'default' => [
                'NULL'       => 'defaultNull',
                'DATE'       => 'defaultDate',
                'DATETIME'   => 'defaultDateTime',
                'TIME'       => 'defaultTime',
                'AUTONUMBER' => 'defaultAutoNumber',
                'TOKEN'      => 'defaultToken'
            ]
        ]
        
    ]
    
];