<?php
/**
 * javascriptのfetch()用
 * (table,function,引数)をポストするとjsonか整数で返します。
 * 
 * @author Hidemaru-Jupiter
 * @version 1.0
 */
require("DBinterface.php");//データベースクラス群
//table
//function
//引数
if($_POST['table'] == "interesting"){
    $db = new Table_interesting();
    if($_POST['function'] == "setInteresting"){
        $db->setInteresting($_POST["user_id"],$_POST["category_id"]);
    }else if($_POST['function'] == "getInteresting"){
        $answer = $db->getInteresting($_POST["user_id"]);
    }
}else if($_POST['table'] == "user"){
    $db = new Table_user();
    if($_POST['function'] == "check"){
        $answer = $db->check($_POST["user_idName"]);
    }else if($_POST['function'] == "register"){
        $db->register($_POST["user_idName"],$_POST["user_pass"],$_POST["user_firstName"],$_POST["user_secondName"],$_POST["user_mailAddress"]);
    }else if($_POST['function'] == "login"){
        $answer = $db->login($_POST["user_idName"],$_POST["user_pass"]);
    }
}else if($_POST['table'] == "video"){
    $db = new Table_video();
    if($_POST['function'] == "nameSearch"){
        $answer = $db->nameSearch($_POST["video_name"]);
    }else if($_POST['function'] == "getVideo"){
        $answer = $db->getVideo($_POST["video_id"]);
    }else if($_POST['function'] == "insertVideo"){
        $db->insertVideo($_POST["video_name"],$_POST["video_date"],$_POST["video_picture"],$_POST["video_introduceUrl"]);
    }else if($_POST['function'] == "deleteVideo"){
        $db->deleteVideo($_POST["video_name"]);
    }
}else if($_POST['table'] == "stock"){
    $db = new Table_stock();
    if($_POST['function'] == "getStock"){
        $answer = $db->getStock($_POST["video_name"]);
    }else if($_POST['function'] == "incrementStock"){
        $db->incrementStock($_POST["shop_id"],$_POST["video_name"]);
    }else if($_POST['function'] == "decrementStock"){
        $db->decrementStock($_POST["shop_id"],$_POST["video_name"]);
    }
}else if($_POST['table'] == "book"){
    $db = new Table_book();
    if($_POST['function'] == "setBook"){
        $db->setBook($_POST["user_id"],$_POST["video_id"],$_POST["shop_id"]);
    }else if($_POST['function'] == "getBook"){
        $answer = $db->getBook($_POST["user_id"]);
    }else if($_POST['function'] == "deleteBook"){
        $db->deleteBook($_POST["book_id"]);
    }else if($_POST['function'] == "updateBook"){
        $db->updateBook($_POST["user_id"]);
    }else if($_POST['function'] == "updateBookFromShop"){
        $db->updateBookFromShop($_POST["book_id"]);
    }else if($_POST['function'] == "cancelBookFromShop"){
        $db->cancelBookFromShop($_POST["book_id"]);
    }
}else if($_POST['table'] == "videoCategory"){
    $db = new Table_videoCategory();
    if($_POST['function'] == "categorySearch"){
        $answer = $db->categorySearch($_POST["category_id"]);
    }
}else if($_POST['table'] == "category"){
    $db = new Table_category();
    if($_POST['function'] == "getCategory"){
        $answer = $db->getCategory();
    }
}
echo $answer;
?>