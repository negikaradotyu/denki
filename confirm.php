<?php
session_start(); // セッションを開始

// セッションからデータを取得
$name = $_SESSION['name'];
$address = $_SESSION['address'];
$phone = $_SESSION['phone'];
$email = $_SESSION['email'];
$yearType = $_SESSION['yearType'];
$year = $_SESSION['year'];
$month = $_SESSION['month'];
$day = $_SESSION['day'];
$qualification = $_SESSION['qualification'];
$qualification1 = $_SESSION['qualification1'];
$qualification2 = $_SESSION['qualification2'];
$other = $_SESSION['other'];
$experience = $_SESSION['experience'];
$password = $_SESSION['password']; // パスワードを取得

// パスワードを＊マークで隠す
$hiddenPassword = str_repeat("*", strlen($password));

// データベースに接続（適切な接続情報を設定）
$host = '127.0.0.1';
$username = 'yesorno_laravel';
$password = '59435943'; // パスワードをシングルクォーテーションで囲む
$database = 'yesorno_users';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("データベースへの接続に失敗しました: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    // パスワードをデータベースに格納
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, address, phone, email, password, birthdate, qualification, qualification1, qualification2, other, experience)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQLエラー: " . $conn->error);
    }

    $stmt->bind_param("ssssssiiisi", $name, $address, $phone, $email, $hashedPassword, $birthdate, $qualification, $qualification1, $qualification2, $other, $experience);

    if ($stmt->execute()) {
        // レコードが正常に挿入された場合の処理
        echo "ユーザーが正常に登録されました。";
    } else {
        // エラーが発生した場合の処理
        echo "エラー: " . $stmt->error;
    }

    $stmt->close();
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>電気工事士登録確認</title>
    <link rel="stylesheet" href="denkistyle.css">
</head>
<body>
    <h1>電気工事士登録確認</h1>
    <h2>以下の情報で登録しますか？</h2>
    <form method="post" action="registration.php">
        <div class="form-row">
            <label for="name">氏名:</label>
            <?php echo $name; ?>
        </div>
        <div class="form-row">
            <label for="address">住所:</label>
            <?php echo $address; ?>
        </div>
        <div class="form-row">
            <label for="phone">連絡先（電話番号）:</label>
            <?php echo $phone; ?>
        </div>
        <div class="form-row">
            <label for="email">連絡先（E-mail）:</label>
            <?php echo $email; ?>
        </div>
        <div class="form-row">
            <label for="password">パスワード:</label>
            <?php echo $hiddenPassword; // ＊マークで表示 ?>
        </div>
        <div class="form-row">
            <span class="era-label">生年月日:</span>
            <?php echo $yearType . $year . "年" . $month . "月" . $day . "日"; ?>
        </div>
        <div class="form-row">
        <span>有資格:</span><br>
    <?php
    $qualifications = array(); // チェックされた資格を格納する配列

    if (!empty($qualification)) {
        $qualifications[] = "第二種電気工事士";
    }
    if (!empty($qualification1)) {
        $qualifications[] = "第一種電気工事士";
    } ?><br>
    <?php
    if (!empty($qualification2)) {
        $qualifications[] = "普通自動車免許";
    }
    if (!empty($other)) {
        $qualifications[] = "その他: " . $other;
    }

    // 配列内の資格をカンマで結合して表示
    echo implode(", ", $qualifications);
    ?>
        </div>
        <div class="form-row">
            <label for="experience">経験年数:</label>
            <?php
            if ($experience == 1) {
                echo "1年未満";
            } elseif ($experience == 2) {
                echo "1年以上3年未満";
            } elseif ($experience == 3) {
                echo "3年以上";
            }
            ?>
        </div>
        <input type="submit" name="register" value="登録">
    </form>
    <form class="login-button-form" method="get" action="registration.php">
        <input type="submit" value="修正">
    </form>
</body>
</html>
