<?php
class JupiterDB{//スーパークラス（継承で使うだけ）
    protected $pdo;
    protected $stmt;
    protected $rows;
    /**
     * データベース接続
     */
    function __construct(){
        try {
            $this->pdo = new PDO(
                'mysql:dbname=jupiterDB; host=118.27.0.132; charset=utf8mb4',/*テスト用*/
                'jupiter',
                'jupiter',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
            header('Content-Type: text/plain; charset=UTF-8', true, 500);
            exit($e->getMessage()); 
        }
    }
}
/**
 * ユーザテーブル
 */
class Table_user extends JupiterDB{
    function __construct(){
        parent::__construct();
    }
    /**
     * ID名から空きの確認をする。
     * $rowにヒットしたクエリを格納する。
     * @param string $user_idName ユーザ名
     * @return 0 空きあり
     * @throws -1 既に登録あり。
     */
    public function check(string $user_idName){
        $this->stmt = $this->pdo->prepare(
            "SELECT * FROM user 
            WHERE user.user_idName = :idName");
        $this->stmt->bindValue(':idName', $user_idName, PDO::PARAM_STR);
        $this->stmt->execute();
        $this->rows = $this->stmt->fetchAll();
        if(count($this->rows) != 0){
            return -1;//HIT
        }else{
            return 0;
        }
    }
    /**
     * ユーザ登録をする。
     * userテーブルに追加する。
     * @param string $user_idName ユーザ名
     * @param string $user_pass ユーザ名
     * @param string $user_firstName 姓
     * @param string $user_secondName 名
     * @param string $user_mailAddress メアド
     */
    public function register(string $user_idName, string $user_pass, string $user_firstName,
                            string $user_secondName, string $user_mailAddress){
        $this->stmt = $this->pdo->prepare(
            'INSERT INTO user (user_idName, user_pass, user_firstName, user_secondName, user_mailAddress)
             VALUES(:idName,:pass,:firstName,:secondName,:mailAddress)');
        $this->stmt->bindValue(':idName', $user_idName, PDO::PARAM_STR);
        $this->stmt->bindValue(':pass', $user_pass, PDO::PARAM_STR);
        $this->stmt->bindValue(':firstName', $user_firstName, PDO::PARAM_STR);
        $this->stmt->bindValue(':secondName', $user_secondName, PDO::PARAM_STR);
        $this->stmt->bindValue(':mailAddress', $user_mailAddress, PDO::PARAM_STR);
        $this->stmt->execute();
    }
    /**
     * ID名とパスワードからユーザIDを調べる。
     * $rowにヒットしたクエリを格納する。
     * 
     * @param string $user_idName ユーザ名
     * @param string $user_pass ユーザ名
     * @return $user_id ユーザのプライマリーキー。
     * @throws -1 エラー
     */
    public function login($user_idName,$user_pass){
        $this->stmt = $this->pdo->prepare(
            "SELECT * FROM user 
            WHERE user.user_idName = :idName 
            AND user.user_pass = :pass");
        $this->stmt->bindValue(':idName', $user_idName, PDO::PARAM_STR);
        $this->stmt->bindValue(':pass', $user_pass, PDO::PARAM_STR);
        $this->stmt->execute();
        $this->rows = $this->stmt->fetchAll();
        if(count($this->rows) == 1){
            return $this->rows[0]['user_id'];
        }else{
            return -1;//err
        }
    }
}
/**
 * カテゴリテーブル
 */
class Table_category extends JupiterDB{
    function __construct(){
        parent::__construct();
    }
    /**
     * カテゴリリストの取得
     * @return category_id,category_name
     */
    public function getCategory(){
        $this->stmt = $this->pdo->prepare("SELECT * FROM category");
        $this->stmt->execute();
        $this->rows = $this->stmt->fetchAll();
        return json_encode($this->rows);
    }
}
/**
 * ビデオテーブル
 */
class Table_video extends JupiterDB{
    function __construct(){
        parent::__construct();
    }
    /**
     * ビデオ名で曖昧検索
     * @param string $video_name ビデオの名前
     * @return video_id,video_name,video_date,video_picture,video_introduceUrl
     */
    public function nameSearch(string $video_name){
        $video_name = "%".$video_name."%";//前後に文字があってもなくてもHITするようにする。
        $this->stmt = $this->pdo->prepare(
            "SELECT * FROM video 
            WHERE video.video_name like :name");
        $this->stmt->bindValue(':name', $video_name, PDO::PARAM_STR);
        $this->stmt->execute();
        $this->rows = $this->stmt->fetchAll();
        return json_encode($this->rows);
    }
    /**
     * ビデオidからビデオ情報取得
     * @param int $video_id プライマリーキー
     * @return video_id,video_name,video_date,video_picture,video_introduceUrl
     */
    public function getVideo(int $video_id){
        $this->stmt = $this->pdo->prepare(
            "SELECT * FROM video 
            WHERE video.video_id = :video_id");
        $this->stmt->bindValue(':video_id', $video_id, PDO::PARAM_INT);
        $this->stmt->execute();
        $this->rows = $this->stmt->fetchAll();
        return json_encode($this->rows);
    }
    /**
     * ビデオ追加
     * @param string $video_name
     * @param string $video_date
     * @param string $video_picture
     * @param string $video_introduceUrl
     */
    public function insertVideo(string $video_name,
                    string $video_date, string $video_picture, string $video_introduceUrl){
        $this->stmt = $this->pdo->prepare(
            'INSERT INTO video
            (video_name, video_date, video_picture, video_introduceUrl)
            VALUES(:video_name, :video_date, :video_picture, :video_introduceUrl)');
        $this->stmt->bindValue(':video_name', $video_name, PDO::PARAM_STR);
        $this->stmt->bindValue(':video_date', $video_date, PDO::PARAM_STR);
        $this->stmt->bindValue(':video_picture', $video_picture, PDO::PARAM_STR);
        $this->stmt->bindValue(':video_introduceUrl', $video_introduceUrl, PDO::PARAM_STR);
        $this->stmt->execute();
    }
    /**
     * 削除
     * @param string $video_name
     */
    public function deleteVideo($video_name){
        $this->stmt = $this->pdo->prepare(
            'DELETE FROM video 
            WHERE video.video_name = :video_name');
        $this->stmt->bindValue(':video_name', $video_name, PDO::PARAM_STR);
        $this->stmt->execute();
    }
}
/**
 * ビデオカテゴリテーブル
 */
class Table_videoCategory extends JupiterDB{
    function __construct(){
        parent::__construct();
    }
    /**
     * カテゴリidで検索
     * @param int $category_id カテゴリのプライマリーキー
     * @return videoCategory_id
     * @return video_id,video_name,video_date,video_picture
     * @return category_id,category_name
     */
    public function categorySearch(int $category_id){
        $this->stmt = $this->pdo->prepare(
            "SELECT *
            FROM videoCategory INNER JOIN category ON videoCategory.category_id = category.category_id 
            INNER JOIN video ON videoCategory.video_id = video.video_id 
            WHERE category.category_id =:category_id ");
        $this->stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $this->stmt->execute();
        $this->rows = $this->stmt->fetchAll();
        return json_encode($this->rows);
    }
}
/**
 * 嗜好テーブル
 */
class Table_interesting extends JupiterDB{
    function __construct(){
        parent::__construct();
    }
    /**
     * 興味を登録する
     * @param int $user_id  プライマリーキー
     * @param int $category_id プライマリーキー
     */
    public function setInteresting(int $user_id, int $category_id){
        $this->stmt = $this->pdo->prepare(
            'INSERT INTO interesting (user_id, category_id, interesting_date)
            VALUES(:user_id,:category_id,:interesting_date)');
        $this->stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $this->stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $this->stmt->bindValue(':interesting_date', date('Y-m-d'), PDO::PARAM_STR);
        $this->stmt->execute();
    }
    /**
     * 嗜好取得
     * @param int $user_id
     * @return interesting_id,interesting_date
     * @return user_id,user_idName,user_pass,user_firstName,user_secondName,user_mailAddress
     * @return category_id,category_name
     */
    public function getInteresting(int $user_id){
        $this->stmt = $this->pdo->prepare(
            "SELECT * FROM interesting 
            INNER JOIN user ON user.user_id = interesting.user_id 
            INNER JOIN category ON category.category_id = interesting.category_id
            WHERE user.user_id = :user_id");
        $this->stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $this->stmt->execute();
        $this->rows = $this->stmt->fetchAll();
        return json_encode($this->rows);
    }
}
/**
 * 在庫テーブル
 */
class Table_stock extends JupiterDB{
    function __construct(){
        parent::__construct();
    }
    /**
     * ビデオidから在庫かくにん
     * @param int $video_id  プライマリーキー
     * @return stock_id,stock_videoNum
     * @return video_id,video_name,video_date,video_picture,video_introduceUrl
     * @return shop_id,shop_name
     */
    public function getStock(int $video_id){
        $this->stmt = $this->pdo->prepare(
            "SELECT * 
            FROM stock 
            INNER JOIN video ON video.video_id = stock.video_id 
            INNER JOIN shop ON shop.shop_id = stock.shop_id
            WHERE video.video_id = :video_id");
        $this->stmt->bindValue(':video_id', $video_id, PDO::PARAM_INT);
        $this->stmt->execute();
        $this->rows = $this->stmt->fetchAll();
        return json_encode($this->rows);
    }
    /**
     * 返却
     * @param int $shop_id
     * @param string $video_name
     */
    public function incrementStock(int $shop_id, string $video_name){
        $this->stmt = $this->pdo->prepare(
            'UPDATE stock INNER JOIN video ON video.video_id = stock.video_id 
            SET stock.stock_videoNum = stock.stock_videoNum + 1 
            WHERE video.video_name = :video_name AND stock.shop_id = :shop_id;');
        $this->stmt->bindValue(':shop_id', $shop_id, PDO::PARAM_INT);
        $this->stmt->bindValue(':video_name', $video_name, PDO::PARAM_STR);
        $this->stmt->execute();
    }
    /**
     * 貸し出し
     * @param int $shop_id
     * @param string $video_name
     */
    public function decrementStock(int $shop_id, string $video_name){
        $this->stmt = $this->pdo->prepare(
            'UPDATE stock INNER JOIN video ON video.video_id = stock.video_id 
            SET stock.stock_videoNum = stock.stock_videoNum - 1 
            WHERE video.video_name = :video_name AND stock.shop_id = :shop_id;');
        $this->stmt->bindValue(':shop_id', $shop_id, PDO::PARAM_INT);
        $this->stmt->bindValue(':video_name', $video_name, PDO::PARAM_STR);
        $this->stmt->execute();
    }
}
/**
 * 取り置きテーブル
 */
class Table_book extends JupiterDB{
    function __construct(){
        parent::__construct();
    }
    /**
     * ユーザ取り置き申請
     * @param int $user_id
     * @param int $video_id
     * @param int $shop_id
     */
    public function setBook(int $user_id, int $video_id, int $shop_id){
        $this->stmt = $this->pdo->prepare(
            'INSERT INTO book (user_id, video_id, shop_id, book_date, book_complete)
             VALUES(:user_id, :video_id, :shop_id, :book_date, :book_complete)');
        $this->stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $this->stmt->bindValue(':video_id', $video_id, PDO::PARAM_INT);
        $this->stmt->bindValue(':shop_id', $shop_id, PDO::PARAM_INT);
        $this->stmt->bindValue(':book_date', date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $this->stmt->bindValue(':book_complete', NULL, PDO::PARAM_INT);
        $this->stmt->execute();
    }
    /**
     * ユーザ取り置き確認
     * @param int $user_id
     * @return book_id,book_date,book_complete
     * @return user_id,user_idName,user_pass,user_firstName,user_secondName,user_mailAddress
     * @return video_id,video_name,video_date,video_picture,video_introduceUrl
     * @return shop_id,shop_name
     */
    public function getBook(int $user_id){
        $this->stmt = $this->pdo->prepare(
            "SELECT * 
            FROM book INNER JOIN user ON user.user_id = book.user_id 
            INNER JOIN video ON video.video_id = book.video_id 
            INNER JOIN shop ON shop.shop_id = book.shop_id
            WHERE user.user_id = :user_id");
        $this->stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $this->stmt->execute();
        $this->rows = $this->stmt->fetchAll();
        return json_encode($this->rows);
    }
    /**
     * ユーザ取り置き削除
     * @param int $book_id
     */
    public function deleteBook(int $book_id){
        $this->stmt = $this->pdo->prepare(
            'DELETE FROM book WHERE book_id = :book_id');
        $this->stmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);
        $this->stmt->execute();
    }
    /**
     * ユーザ取り置き本申請
     * @param int $user_id
     */
    public function updateBook(int $user_id){
        $this->stmt = $this->pdo->prepare(
            'UPDATE book SET book_complete = :book_complete, book_date = :book_date 
            WHERE user.user_id = :user_id');
        $this->stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $this->stmt->bindValue(':book_date', date('Y-m-d'), PDO::PARAM_STR);
        $this->stmt->bindValue(':book_complete', FALSE, PDO::PARAM_INT);
        $this->stmt->execute();
    }
    /**
     * お店取り置き完了
     * @param int $book_id
     */
    public function updateBookFromShop(int $book_id){
        $this->stmt = $this->pdo->prepare(
            'UPDATE book SET book_complete = :book_complete, book_date = :book_date 
            WHERE book.book_id = :book_id');
        $this->stmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);
        $this->stmt->bindValue(':book_date', date('Y-m-d'), PDO::PARAM_STR);
        $this->stmt->bindValue(':book_complete', TRUE, PDO::PARAM_INT);
        $this->stmt->execute();
    }
    /**
     * お店取り置きキャンセル
     * @param int $book_id
     */
    public function cancelBookFromShop(int $book_id){
        $this->stmt = $this->pdo->prepare(
            'UPDATE book SET book_complete = :book_complete, book_date = :book_date 
            WHERE book.book_id = :book_id');
        $this->stmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);
        $this->stmt->bindValue(':book_date', date('Y-m-d'), PDO::PARAM_STR);
        $this->stmt->bindValue(':book_complete', -1, PDO::PARAM_INT);//テーブル用意していなかったので、応急的に-1で勘弁してください。
        $this->stmt->execute();
    }
    /**
     * お店から全体の取り置き確認
     * @param int $shop_id
     * @return book_id,book_date
     * @return user_id,user_idName,user_pass,user_firstName,user_secondName,user_mailAddress
     * @return video_id,video_name,video_date,video_picture,video_introduceUrl
     * @return shop_id,shop_name
     */
    public function getBookFromShop(int $shop_id){
        $this->stmt = $this->pdo->prepare(
            "SELECT * 
            FROM book INNER JOIN user ON user.user_id = book.user_id 
            INNER JOIN video ON video.video_id = book.video_id 
            INNER JOIN shop ON shop.shop_id = book.shop_id
            WHERE shop.shop_id = :shop_id");
        $this->stmt->bindValue(':shop_id', $shop_id, PDO::PARAM_INT);
        $this->stmt->execute();
        $this->rows = $this->stmt->fetchAll();
        return json_encode($this->rows);
    }
}
/**
 * メール送信用
 * @param string $to 宛先
 * @param string $subject 題名
 * @param string $message 本文
 * @return 0 成功
 * @return -1 失敗
 */
class sendEmail{
    public $to;
    public $subject;
    public $message;
    function __construct(string $to, string $subject, string $message){
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
    }
    /**
     * メールを送る（<apache@118-27-0-132.localdomain>から送信）<= 気が向いたら変更します。
     * @return 0 成功
     * @return -1 失敗
     */
    function send(){
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        if(mb_send_mail($this->to, $this->subject, $this->message)){
           return 0;
        }else{
            return -1;
        }
    }
}