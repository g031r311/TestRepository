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

# テンプレ
alter table {table} MODIFY COLUMN {column} {type};--タイプ変更
alter table {table} change column {oldName} {newName} {type};--名前変更
alter table {table} add {column} {type};--追加
alter table {table} modify {moveColumn} text after {goalColumn};--移動
FOREIGN KEY (`column`) REFERENCES `table` (`column`) ON DELETE SET NULL ON UPDATE CASCADE--外部キー設定
\c;--キャンセル

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

## user
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

## video
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

## stock
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

## shop
作成済み
* ENGINE = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|shop_id            |int(11)        |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|shop_name          |varchar(255)   |                       |

## book
作成済み
* ENGINE = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|book_id            |int            |NOT NULL               |
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
|book_date          |datetime       |                       |
|book_complete      |tinyint(1)     |                       |

## videoCategory
作成済み
* ENGINE = InnoDB
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
作成済み
* ENGINE = InnoDB
* DEFAULT CHARSET = utf8

|名前               |データ型       |他|
|:--                |:--            |:--                    |
|category_id        |int            |NOT NULL               |
|                   |               |AUTO_INCREMENT         |
|                   |               |PRIMARY KEY            |
|category_name      |varchar        |                       |

