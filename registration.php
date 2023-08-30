


<?php
session_start();

$error = "パスワードが一致しません。再入力願います。";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームデータをセッションに保存してconfirm.phpに渡す
    session_start();
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['address'] = $_POST['address'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['yearType'] = $_POST['yearType'];
    $_SESSION['year'] = $_POST['year'];
    
    if ($_POST['yearType'] == "昭和") {
        // 昭和年号を西暦に変換
        $_SESSION['year'] = 1925 + $_POST['year'];
    } elseif ($_POST['yearType'] == "平成") {
        // 平成年号を西暦に変換
        $_SESSION['year'] = 1988 + $_POST['year'];
    }

    $_SESSION['month'] = $_POST['month'];
    $_SESSION['day'] = $_POST['day'];

    // 西暦、月、日を結合して生年月日を作成
    $_SESSION['birthdate'] = sprintf("%04d%02d%02d", $_SESSION['year'], $_SESSION['month'], $_SESSION['day']);
    $_SESSION['qualification'] = $_POST['qualification'];
    $_SESSION['qualification1'] = $_POST['qualification1'];
    $_SESSION['qualification2'] = $_POST['qualification2'];
    $_SESSION['other'] = $_POST['other'];
    $_SESSION['experience'] = $_POST['experience'];

    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // パスワードが一致するか確認
    if ($password !== $confirmPassword) {
        $error = "パスワードとパスワード確認用が一致しません。";
    } else {
        // パスワードが一致した場合、確認画面にリダイレクト
        $_SESSION['password'] = $password;
        header("Location: confirm.php");
        exit();
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>電気工事士登録</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="denkistyle.css">
</head>
<body>
    <h1><i class="fa-solid fa-plug fa-beat"></i>電気工事士登録<i class="fa-solid fa-plug"></i></h1>
    <div class="subtitle">
        <form class="login-button" method="get" action="login.php">
            <input type="submit" value="ログインページへ">
        </form>
        <h3>まだ登録がお隅出ない方は↓</h3>
    </div>
    <h2>ユーザー登録フォーム</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-row">
            <label for="name">氏名:</label>
            <input type="text" name="name" required><p class="required"> <必須></p>
        </div>
        <div class="form-row-address">
            <label for="address">住所:</label>
            <input type="text" name="name" required><p class="required"> <必須></p>
        </div>
        <div class="form-row">
            <label for="phone">連絡先（電話番号）:</label>
            <input type="text" name="phone" required><p class="required"> <必須></p>
        </div>
        <div class="form-row">
            <label for="email">連絡先（E-mail）:</label>
            <input type="email" name="email">
        </div>
                <!-- パスワード入力 -->
            <div class="form-row">
            <label for="password">パスワード:</label>
            <input type="password" name="password" required>
            <label for="confirm_password">パスワード確認:</label>
            <input type="password" name="confirm_password" required>
        </div>

        <!-- エラーメッセージ -->
        <?php if ($error): ?>
        <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>



        <div class="form-row">
            <span class="era-label">生年月日:</span>
            <div class="date-input">
                <select class="yearType" name="yearType">
                    <option value="昭和">昭和</option>
                    <option value="平成">平成</option>
                </select>
                
                <select name="year">
                    <?php
                    for ($i = 1; $i <= 99; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                    ?>
                </select>年
                
                <select name="month">
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                    ?>
                </select>月
                
                <select name="day">
                    <?php
                    for ($i = 1; $i <= 31; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                    ?>
                </select>日<p class="required"> <必須></p>
            </div>
        </div>
        <div class="form-row">
            <div class="checkbox-group">
                <span>有資格:</span>
                <label><input type="checkbox" name="qualification[]" value=1> 第二種電気工事士</label>
                <label><input type="checkbox" name="qualification1[]" value=2> 第一種電気工事士</label>
                
                <label><input type="checkbox" name="qualification2[]" value=3> 普通自動車免許</label>
                <label><input type="checkbox"> その他</label><input type="text" name="other">
            </div>
            
        </div>
        <div class="form-row">
            <label for="experience">経験年数:</label>
            <select name="experience">
                <option value=1>1年未満</option>
                <option value=2>1年以上3年未満</option>
                <option value=3>3年以上</option>
            </select>
        </div>
        <input type="submit" value="確認">
    </form>
    
</body>
</html>
