<?php
    return [
        "admin" => [
            "sidebar" => [
                "dashboard"     => [
                    "route" => "dashboard",
                    "title" => "Dashboard",
                    "icon"  => "dashboard",
                    "level" => "auth",
                ],
                "location"      => [
                    "route" => "country",
                    "title" => "Locations",
                    "icon"  => "globe",
                    "level" => "auth",
                    "child" => [
                        "country" => [
                            "route" => "country",
                            "title" => "Countries",
                            "icon"  => "globe",
                            "level" => "auth",
                        ],
                        "state"   => [
                            "route" => "state",
                            "title" => "States",
                            "icon"  => "globe",
                            "level" => "auth",
                        ],
                        "city"    => [
                            "route" => "city",
                            "title" => "Cities",
                            "icon"  => "globe",
                            "level" => "auth",
                        ],
                        "subcity" => [
                            "route" => "subcity",
                            "title" => "Sub Cities",
                            "icon"  => "globe",
                            "level" => "auth",
                        ],
                    ],
                ],
                "category"      => [
                    "route" => "category",
                    "title" => "Categories",
                    "icon"  => "cube",
                    "level" => "care",
                    "child" => [
                        "subcategory" => [
                            "route" => "subcategory",
                            "title" => "Sub Categories",
                            "icon"  => "cube",
                            "level" => "auth",
                        ],
                    ],
                ],
                "booklet"       => [
                    "route" => "booklet",
                    "title" => "Booklets",
                    "icon"  => "barcode",
                    "level" => "executive",
                    "child" => [
                        "bookletAll"          => [
                            'route' => "booklet",
                            'title' => "Booklets ALL",
                            'icon'  => 'barcode',
                            "level" => "auth",
                        ],
                        "giveBooklets"        => [
                            'route' => "givebooklets",
                            'title' => "Booklets to Excecutives",
                            'icon'  => "book",
                            "level" => "admin",
                        ],
                        "bookletTransactions" => [
                            'route' => "booklettransactions",
                            'title' => "Booklet Purchases",
                            'icon'  => "book",
                            "level" => "auth",
                        ],
                    ],
                ],
                "store"         => [
                    "route" => "store",
                    "title" => "Stores Listing",
                    "icon"  => "building",
                    "level" => "care",
                ],
                "bonusDeals"    => [
                    "route" => "bonusdeal.index",
                    "title" => "Bonus Deals",
                    "icon"  => "tags",
                    "level" => "care",
                ],
                "deal"          => [
                    "route" => "deal",
                    "title" => "Deals",
                    "icon"  => "tags",
                    "level" => "auth",
                    "child" => [
                        "createdeal" => [
                            "route" => "deal_create",
                            "title" => "Add a new Deal",
                            "icon"  => "plus",
                            "level" => "admin",
                        ],
                        "deals"      => [
                            "route" => "deal",
                            "title" => "List All Deals",
                            "icon"  => "tags",
                            "level" => "auth",
                        ],
                    ],
                ],
                "redemptions"   => [
                    "route" => "client.avail.deal",
                    "title" => "Redeem Deal",
                    "icon"  => "tag",
                    "level" => "auth",
                    "child" => [
                        "redeem"   => [
                            "route" => "client.avail.deal",
                            "title" => "Redeem Deal",
                            "icon"  => "tags",
                            "level" => "auth",
                        ],
                        "validate" => [
                            "route" => "deal.redeem",
                            "title" => "Validate Deal Coupons",
                            "icon"  => "tag",
                            "level" => "auth",
                        ],
                    ]
                ],
                "advertisments" => [
                    "route" => "advertisment",
                    "title" => "Advertisments",
                    "icon"  => "flag",
                    "level" => "admin",
                ],
                "user"          => [
                    "route" => "user",
                    "title" => "Executives",
                    "icon"  => "users",
                    "level" => "admin",
                ],
                "client"        => [
                    "route" => "client",
                    "title" => "Clients",
                    "icon"  => "user-plus",
                    "level" => "auth",
                ],
                "value"         => [
                    "route" => "value",
                    "title" => "Default Values",
                    "icon"  => "cogs",
                    "level" => "admin",
                ],
                "reporting"     => [
                    "route" => "export.index",
                    "title" => "Reports",
                    "icon"  => 'book',
                    "level" => "admin",
                    "child" => [
                        'exportReports'   => [
                            'route' => 'export.index',
                            'title' => "Report Downloads",
                            'icon'  => 'download',
                            "level" => "admin",
                        ],
                        "booklet_reports" => [
                            "route" => "booklet_reports",
                            "title" => "Reporting Code",
                            "icon"  => "flag",
                            "level" => "admin",
                        ],
                        "ccrepo"          => [
                            "route" => "ccTransactions",
                            "title" => "CC Avenue Transactions",
                            "icon"  => "book",
                            "level" => "admin",
                        ],
                        "logs"            => [
                            "route" => "log-viewer::dashboard",
                            "title" => "Site Logs",
                            "icon"  => "book",
                            "level" => "admin",
                        ],
                    ],
                ],
            ],
        ],
    ];
