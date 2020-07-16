# 用語解説
|用語           |解説|
|:--            |:--|
|InnoDB         |外部キーの整合性とかやってくれるエンジンです。                  |
|utf8           |日本語対応している文字コードです。                             |
|int            |データベース内では整数型。取り方によってstringで出力されます。   |
|varchar        |stringと大体同じ。                                           |
|datetime       |日付と時刻を格納するのに使用するデータ型。'YYYY-MM-DD HH:MM:SS' が基本。|
|date           | 日付を格納するのに使用するデータ型。'YYYY-MM-DD' が基本.       |


# データの取り方
php参照

# テーブル一覧
* [interesting](#interesting)
* [user](#user)
* [video](#video)
* [stock](#stock)
* [shop](#shop)
* [order](#order)
* [videoCategory](#videoCategory)
* [category](#category)

## interesting
* ENGIN = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|interesting_id     |int            |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|user_id            |int            |FOREIGN KEY(user)      |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|category_id        |int            |FOREIGN KEY (category) |
|                   |               |ON DELETE SET NULL     |
|                   |               |ON UPDATE CASCADE      |
|interesting_date   |datetime       |                       |

## user
* ENGIN = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|user_id            |int            |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|user_idName        |varchar        |                       |
|user_pass          |varchar        |                       |
|user_firstName     |varchar        |                       |
|user_secondName    |varchar        |                       |
|user_mailAddress   |varchar        |                       |

## video
* ENGIN = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|video_id           |int            |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|video_name         |varchar        |                       |
|video_date         |date           |                       |
|video_picture      |varchar        |                       |
|video_introduceUrl |varchar        |                       |

## stock
* ENGIN = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|stock_id           |int            |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|video_id           |int            |FOREIGN KEY(video)     |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|shop_id            |int            |FOREIGN KEY(shop)      |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|stock_videoNum     |int            |                       |

## shop
* ENGIN = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|shop_id            |int            |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|shop_name          |varchar        |                       |

## order
* ENGIN = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|order_id           |int            |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|user_id            |int            |FOREIGN KEY(user)      |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|video_id           |int            |FOREIGN KEY(video)     |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|shop_id            |int            |FOREIGN KEY(shop)      |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|order_date         |datetime       |                       |
|order_complete     |bool           |                       |

## videoCategory
* ENGIN = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|videoCategory_id   |int            |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|video_id           |int            |FOREIGN KEY(video)     |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|category_id        |int            |FOREIGN KEY(category)  |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |

## category
* ENGIN = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|category_id        |int            |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|category_name      |varchar        |                       |

