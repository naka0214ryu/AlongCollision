<?php
//DB接続
$db = new mysqli("localhost", "root", "", "ohajiki_score");

//接続確認
if($db->connect_error)
{
    die("DB接続失敗");
}

//UTF8
$db->set_charset("utf8mb4");

//Unityから受け取る
$name = $_POST["name"];
$score = $_POST["score"];

//スコア登録
$sql = "INSERT INTO score (name, score) VALUES (?, ?)";
$stmt = $db->prepare($sql);
$stmt->bind_param("si", $name, $score);
$stmt->execute();
$stmt->close();

//順位取得
$sql = "SELECT COUNT(*) + 1 AS rank FROM score WHERE score > ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $score);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$rank = $row["rank"];

//返す
echo json_encode([
    "rank" => $rank
]);

$stmt->close();
$db->close();
?>
