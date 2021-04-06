<?php

    return [
      'products' => [
        'Site' => [
          [
            'site_id' => 1,
            'name' => 'site #1',
            'prefix' => '_test',
            'is_active' => 1
          ]
        ],
        'Product' => [
          [
            'product_id' => 1,
            'name' => 'test product #1',
            'art' => 'fsdsd'
          ],
          [
            'product_id' => 2,
            'name' => 'test product #2',
            'art' => 'fggsdgd',
            'ecwid_id' => '64643'
          ],
        ],
        'Price' => [
          [
            'product_price_id' => 1,
            'price_type' => Price::PRICE_TYPE_OPT,
            'value' => '1100',
            'product_id' => 1
          ]
        ],
      ],
      'rest_response_iterator' => [
        'getProducts_0' => <<<JSON
{
    "total": 80,
    "count": 2,
    "offset": 67,
    "limit": 2,
    "items": [
        {
            "id": 111,
            "sku": dfgsdfg",
            "price": 14310,
            "attributes": [
                {
                    "id": 111111,
                    "name": "Уникальный код",
                    "value": "sfssdf",
                    "show": "DESCR",
                    "type": "UPC"
                },
                {
                    "id": 111222,
                    "name": "test ID",
                    "value": "1",
                    "show": "NOTSHOW",
                    "type": "CUSTOM"
                }
            ]
        },
        {
            "id": 222,
            "sku": "sdfdsf",
            "price": 14310,
            "attributes": [
                {
                    "id": 222111,
                    "name": "Уникальный код",
                    "value": "sfdfsd",
                    "show": "DESCR",
                    "type": "UPC"
                },
                {
                    "id": 222222,
                    "name": "test ID",
                    "value": "1",
                    "show": "NOTSHOW",
                    "type": "CUSTOM"
                }
            ]
        }
    ]
}
JSON
        ,
        'getProducts_2' => <<<JSON
{
    "total": 80,
    "count": 2,
    "offset": 67,
    "limit": 2,
    "items": [
        {
            "id": 333,
            "sku": "qwer",
            "price": 14310,
            "attributes": [
                {
                    "id": 333111,
                    "name": "Уникальный код",
                    "value": "bvw/qdf",
                    "show": "DESCR",
                    "type": "UPC"
                },
                {
                    "id": 333222,
                    "name": "test ID",
                    "value": "1",
                    "show": "NOTSHOW",
                    "type": "CUSTOM"
                }
            ]
        },
        {
            "id": 444,
            "sku": "sdfasdf",
            "price": 14310,
            "attributes": [
                {
                    "id": 444111,
                    "name": "Уникальный код",
                    "value": "rwqwq/tt",
                    "show": "DESCR",
                    "type": "UPC"
                },
                {
                    "id": 444222,
                    "name": "test ID",
                    "value": "1",
                    "show": "NOTSHOW",
                    "type": "CUSTOM"
                }
            ]
        }
    ]
}
JSON
        ,
        'getProducts_4' => '{"total":80,"count":0,"offset":99,"limit":1,"items":[]}'
      ],
      'rest_response_syncProductPriceById_success' => [
        'exportProduct' => '{"updateCount": 1}'
      ],
      'rest_response_syncProductPriceById_fault' => [
        'exportProduct' => '{"updateCount": 0}'
      ],

      'EcwidProductType_success' => <<<JSON
{
    "total": 80,
    "count": 2,
    "offset": 67,
    "limit": 2,
    "items": [
        {
            "id": 112,
            "sku": "sdfsa",
            "price": 14310,
            "attributes": [
                {
                    "id": 89862265,
                    "name": "Уникальный код",
                    "value": "sdfaf",
                    "show": "DESCR",
                    "type": "UPC"
                },
                {
                    "id": 221,
                    "name": "test ID",
                    "value": "1",
                    "show": "NOTSHOW",
                    "type": "CUSTOM"
                }
            ]
        },
        {
            "id": 113,
            "sku": "hnnn",
            "price": 14310,
            "attributes": [
                {
                    "id": 2314,
                    "name": "Уникальный код",
                    "value": "safadf",
                    "show": "DESCR",
                    "type": "UPC"
                },
                {
                    "id": 4543,
                    "name": "test ID",
                    "value": "1",
                    "show": "NOTSHOW",
                    "type": "CUSTOM"
                }
            ]
        }
    ]
}
JSON
      ,
      'EcwidProductType_fault' => <<<JSON
{
    "total": 80,
    "count": 2,
    "offset": 67,
    "limit": 2,
    "items": [
        {
            "id": 87542,
            "sku": "gfdsew",
            "price": 14310,
            "attributes": [
                {
                    "id": 441,
                    "name": "Уникальный код",
                    "value": "dfgwdsf",
                    "show": "DESCR",
                    "type": "UPC"
                }
            ]
        },
        {
            "sku": "gfdwgnn/ooo",
            "price": 14310,
            "attributes": [
                {
                    "id": 8765,
                    "name": "Уникальный код",
                    "value": "wqrqwe/iii",
                    "show": "DESCR",
                    "type": "UPC"
                }
            ]
        }
    ]
}
JSON
    ];