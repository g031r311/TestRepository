<?php
//データベースの接続確認用ソースコードです。
//https://qiita.com/mpyw/items/b00b72c5c95aac573b71のコードをちょっといじっただけです。
try {
    /* リクエストから得たスーパーグローバル変数をチェックするなどの処理 */

    // データベースに接続
    $pdo = new PDO(
        'mysql:dbname=jupiterDB; host=118.27.0.132; charset=utf8mb4',/*テスト用*/
        'jupiter',
        'jupiter',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
    /* データベースから値を取ってきたり， データを挿入したりする処理 */
} catch (PDOException $e) {
    // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
    // - もし手抜きしたくない場合は普通にHTMLの表示を継続する
    // - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage()); 
}

// Webブラウザにこれから表示するものがUTF-8で書かれたHTMLであることを伝える
// (これか <meta charset="utf-8"> の最低限どちらか1つがあればいい． 両方あっても良い．)
header('Content-Type: text/html; charset=utf-8');
?>

<?php
echo "INSERT test\n";
$stmt = $pdo->prepare('INSERT INTO video (video_name,video_date,video_picture,video_introduceUrl)
                        VALUES(:name,:date,:picture,:introduceUrl)');
$stmt->bindValue(':name', "河童のクゥと夏休み", PDO::PARAM_STR);
$date = new DateTime('2007-01-01');
$stmt->bindValue(':date', $date->format('Y-m-d'), PDO::PARAM_STR);
$stmt->bindValue(':picture', "img/kappa", PDO::PARAM_STR);
$stmt->bindValue(':introduceUrl', "https://www.youtube.com/watch?v=2500F6PTvzE", PDO::PARAM_STR);
$stmt->execute();

$stmt = $pdo->prepare('SELECT * FROM video');
$stmt->execute();
$rows = $stmt->fetchAll();
var_dump($rows);

echo "UPDATE test\n";
$stmt = $pdo->prepare('UPDATE video SET video_picture=:picture WHERE video_name=:name');
$stmt->bindValue(':picture', "img/qutonatsu", PDO::PARAM_STR);
$stmt->bindValue(':name', "河童のクゥと夏休み", PDO::PARAM_STR);
$stmt->execute();

$stmt = $pdo->prepare('SELECT * FROM video');
$stmt->execute();
$rows = $stmt->fetchAll();
var_dump($rows);

echo "DELETE test\n";
$stmt = $pdo->prepare('DELETE FROM video WHERE video_name=:name');
$stmt->bindValue(':name', "河童のクゥと夏休み", PDO::PARAM_STR);
$stmt->execute();

$stmt = $pdo->prepare('SELECT * FROM video');
$stmt->execute();
$rows = $stmt->fetchAll();
var_dump($rows);
?>
