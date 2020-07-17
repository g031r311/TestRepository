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
* 118.27.0.132
* user=jupiter
* pass=jupiter

testDB.phpを実行して確認してください。（実行環境が無い人は[paiza.io](https://paiza.io/ja)とか使ってください。）

# テーブル一覧
* [interesting](#interesting)
* [user](#user)
* [video](#video)
* [stock](#stock)
* [shop](#shop)
* [order](#order)
* [videoCategory](#videoCategory)
* [category](#category)

## interesting [↑](#テーブル一覧)
作成済み
* ENGINE = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|interesting_id     |int(11)        |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|user_id            |int(11)        |FOREIGN KEY(user)      |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|category_id        |int(11)        |FOREIGN KEY (category) |
|                   |               |ON DELETE SET NULL     |
|                   |               |ON UPDATE CASCADE      |
|interesting_date   |datetime       |                       |

## user [↑](#テーブル一覧)
作成済み
* ENGINE = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|user_id            |int(11)        |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|user_idName        |varchar(255)   |                       |
|user_pass          |varchar(255)   |                       |
|user_firstName     |varchar(255)   |                       |
|user_secondName    |varchar(255)   |                       |
|user_mailAddress   |varchar(255)   |                       |

## video [↑](#テーブル一覧)
作成済み
* ENGINE = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|video_id           |int(11)        |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|video_name         |varchar(255)   |                       |
|video_date         |date           |                       |
|video_picture      |varchar(255)   |                       |
|video_introduceUrl |varchar(255)   |                       |

## stock [↑](#テーブル一覧)
作成済み
* ENGINE = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|stock_id           |int(11)        |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|video_id           |int(11)        |FOREIGN KEY(video)     |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|shop_id            |int(11)        |FOREIGN KEY(shop)      |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|stock_videoNum     |int(11)        |                       |

## shop [↑](#テーブル一覧)
作成済み
* ENGINE = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|shop_id            |int(11)        |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|shop_name          |varchar(255)   |                       |

## book [↑](#テーブル一覧)
作成済み
* ENGINE = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|book_id            |int(11)        |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|user_id            |int(11)        |FOREIGN KEY(user)      |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|video_id           |int(11)        |FOREIGN KEY(video)     |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|shop_id            |int(11)        |FOREIGN KEY(shop)      |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|book_date          |datetime       |                       |
|book_complete      |tinyint(1)     |                       |

## videoCategory [↑](#テーブル一覧)
作成済み
* ENGINE = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|videoCategory_id   |int(11)        |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|video_id           |int(11)        |FOREIGN KEY(video)     |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |
|category_id        |int(11)        |FOREIGN KEY(category)  |
|                   |               |ON DELETE SET NULL     | 
|                   |               |ON UPDATE CASCADE      |

## category [↑](#テーブル一覧)
作成済み
* ENGINE = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|category_id        |int(11)        |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|category_name      |varchar(255)   |                       |

