<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Gift shop products
    |--------------------------------------------------------------------------
    */

    'products' => [
        [
            'title' => "BAS T-shirt",
            'isNew' => false,
            'soldoutPermanently' => false,
            'price' => 2000,
            'shipping' => 500,
            'shippingPerItem' => true,
            'images' => [
                "/images/gift-shop/2011-white-T-redesign.jpg",
                "/images/gift-shop/2012-grey-T-redesign.jpg",
                "/images/gift-shop/2011-white-T-redesign-closeup.jpg",
            ],
            'colors' => [
                [
                    'description' => "White T with BAS logo in Baja Blue",
                    'sizeSummary' => true,
                    'sizes' => [
                        [
                            'size' => "S",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "BAS WHITE T-SHIRT BAJA BLUE LOGO SMALL",
                                'item_number' => "008S",
                            ],
                        ],
                        [
                            'size' => "M",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "BAS WHITE T-SHIRT BAJA BLUE LOGO MEDIUM",
                                'item_number' => "008M",
                            ],
                        ],
                        [
                            'size' => "L",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "BAS WHITE T-SHIRT BAJA BLUE LOGO LARGE",
                                'item_number' => "008L",
                            ],
                        ],
                        [
                            'size' => "XL",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "BAS WHITE T-SHIRT BAJA BLUE LOGO XTRA LARGE",
                                'item_number' => "008XL",
                            ],
                        ],
                    ],
                ],
                [
                    'description' => "Heather grey T with BAS logo in Baja Blue",
                    'sizeSummary' => true,
                    'sizes' => [
                        [
                            'size' => "S",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "BAS HEATHER GREY T-SHIRT BAJA BLUE LOGO SMALL",
                                'item_number' => "009S",
                            ],
                        ],
                        [
                            'size' => "M",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "BAS HEATHER GREY T-SHIRT BAJA BLUE LOGO MEDIUM",
                                'item_number' => "009M",
                            ],
                        ],
                        [
                            'size' => "L",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "BAS HEATHER GREY T-SHIRT BAJA BLUE LOGO LARGE",
                                'item_number' => "009L",
                            ],
                        ],
                        [
                            'size' => "XL",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "BAS HEATHER GREY T-SHIRT BAJA BLUE LOGO XTRA LARGE",
                                'item_number' => "009XL",
                            ],
                        ],
                    ],
                ],
            ],
        ],

        [
            'title' => "BAS Sweatshirt",
            'isNew' => false,
            'soldoutPermanently' => false,
            'price' => 3000,
            'shipping' => 800,
            'shippingPerItem' => true,
            'images' => [
                "/images/gift-shop/greysweatshirt1.jpg",
            ],
            'colors' => [
                [
                    'description' => "Heather grey sweatshirt with BAS logo",
                    'sizeSummary' => true,
                    'sizes' => [
                        [
                            'size' => "S",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "HEATHER GREY LONG SLEEVE SWEATSHIRT SMALL",
                                'item_number' => "010S",
                            ],
                        ],
                        [
                            'size' => "M",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "HEATHER GREY LONG SLEEVE SWEATSHIRT MEDIUM",
                                'item_number' => "010M",
                            ],
                        ],
                        [
                            'size' => "L",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "HEATHER GREY LONG SLEEVE SWEATSHIRT LARGE",
                                'item_number' => "010L",
                            ],
                        ],
                        [
                            'size' => "XL",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "HEATHER GREY LONG SLEEVE SWEATSHIRT XTRA LARGE",
                                'item_number' => "010XL",
                            ],
                        ],
                    ],
                ],
            ],
        ],

        [
            'title' => "Car Magnets",
            'isNew' => true,
            'soldoutPermanently' => true,
            'price' => 500,
            'shipping' => 200,
            'shippingPerItem' => true,
            'images' => [
                "/images/gift-shop/2018-car-magnet.jpg",
            ],
            'colors' => [
                [
                    'description' => 'We now have Car Magnets!<br />They are 5.75" x 3.375" with our Baja Blue Logo on a white background.',
                    'sizeSummary' => false,
                    'sizes' => [
                        [
                            'size' => "add",
                            'soldout' => true,
                            'paypal' => [
                                'item_name' => "CAR MAGNET",
                                'item_number' => "011CARMAG",
                            ],
                        ],
                    ],
                ],
            ],
        ],

        [
            'title' => "Long-Sleeve Denim Shirt",
            'isNew' => false,
            'soldoutPermanently' => true,
            'price' => 3000,
            'shipping' => 0,
            'shippingPerItem' => true,
            'images' => [
                "/images/gift-shop/long-sleeve-denim-shirt.jpg",
            ],
            'colors' => [
                [
                    'description' => '100% soft, cotton, chambray blue, denim.<br />This shirt has the BAS logo embroidered above the left, front pocket',
                    'sizeSummary' => true,
                    'sizes' => [
                        [
                            'size' => "M",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "LONG SLEEVE DENIM SHIRT MEDIUM",
                                'item_number' => "006M",
                            ],
                        ],
                        [
                            'size' => "L",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "LONG SLEEVE DENIM SHIRT LARGE",
                                'item_number' => "006L",
                            ],
                        ],
                        [
                            'size' => "XL",
                            'soldout' => false,
                            'paypal' => [
                                'item_name' => "LONG SLEEVE DENIM SHIRT X LARGE",
                                'item_number' => "006XL",
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Add to Cart button verbiage set
    |--------------------------------------------------------------------------
    */

    'AddToCartButtons' => [
        'add' => 'Add to Cart',
        'S'   => 'Add to Cart - Small',
        'M'   => 'Add to Cart - Medium',
        'L'   => 'Add to Cart - Large',
        'XL'  => 'Add to Cart - X-Large',
        'XXL' => 'Add to Cart - XX-Large',
    ],

    /*
    |--------------------------------------------------------------------------
    | Gift shop products
    |--------------------------------------------------------------------------
    */

    'PayPalStuff' => [
        'formPost' => 'https://www.paypal.com/cgi-bin/webscr',
        'pixelGif' => 'https://www.paypal.com/en_US/i/scr/pixel.gif',
        'hiddenFields' => [
            [
                'key' => 'add',
                'value' => '1',
            ],
            [
                'key' => 'cmd',
                'value' => '_cart',
            ],
            // this will be handled dynamically as needed since the email address is part of a contact object
            //[
            //    'key' => 'business',
            //    'value' => 'bajadogs@aol.com',
            //],
            [
                'key' => 'no_shipping',
                'value' => '0',
            ],
            [
                'key' => 'no_note',
                'value' => '1',
            ],
            [
                'key' => 'currency_code',
                'value' => 'USD',
            ],
            [
                'key' => 'lc',
                'value' => 'US',
            ],
            [
                'key' => 'bn',
                'value' => 'PP-ShopCartBF',
            ],
        ],
    ],

];
