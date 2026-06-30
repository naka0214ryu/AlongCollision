<?php
//DB接続
$db = new mysqli("localhost", "root", "", "ohajiki_score");

//接続確認
if ($db->connect_error)
{
    die("DB接続失敗");
}

//UTF8
$db->set_charset("utf8mb4");

//命令文
$sql = "SELECT name, score FROM score ORDER BY score DESC LIMIT 10";

//命令実行
$result = $db->query($sql);

$ranking = [];

$rank = 1;

//順位、名前、スコア取得
while ($row = $result->fetch_assoc())
{
    $ranking[] = [
        "rank" => $rank,
        "name" => $row["name"],
        "score" => $row["score"]
    ];

    $rank++;
}

//Unityへ返す
echo json_encode([
    "rankings" => $ranking
]);

$db->close();
?>