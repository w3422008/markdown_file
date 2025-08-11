<?php
// DB接続情報
$host = 'localhost';
$dbname = 'your_db_name';
$user = 'your_username';
$pass = 'your_password';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // データ取得（例: sample_table から全件取得）
  $stmt = $pdo->query("SELECT * FROM sample_table");
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $errorMsg = "DB接続エラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
  $rows = [];
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>メニュー画面</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', 'Meiryo', sans-serif;
      background: #f7f7f7;
      min-height: 100vh;
      box-sizing: border-box;
    }
    /* ナビゲーションバー */
    .navbar {
      width: 100%;
      height: 60px;
      background: #1976d2;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: start;
      padding: 0 32px;
      font-size: 1.3rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      letter-spacing: 1px;
    }
    /* 中央メニュー */
    .menu-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: calc(100vh - 60px);
    }
    .buttons-grid {
      display: grid;
      grid-template-columns: 150px 150px;
      grid-template-rows: 70px 70px;
      gap: 32px;
    }
    .menu-btn {
      background: #fff;
      border: 2px solid #1976d2;
      color: #1976d2;
      border-radius: 12px;
      font-size: 1.2rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s, color 0.2s;
      box-shadow: 0 2px 10px rgba(25, 118, 210, 0.07);
    }
    .menu-btn:hover {
      background: #1976d2;
      color: #fff;
    }
    @media (max-width: 500px) {
      .navbar {
        font-size: 1rem;
        padding: 0 12px;
      }
      .buttons-grid {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 50px 50px;
        gap: 16px;
      }
      .menu-btn {
        font-size: 1rem;
        padding: 0;
      }
    }
  </style>
</head>
<body>
  <div class="navbar">
    メニュー画面
  </div>
  <div class="menu-container">
    <div class="buttons-grid">
      <button class="menu-btn">ボタン1</button>
      <button class="menu-btn">ボタン2</button>
      <button class="menu-btn">ボタン3</button>
      <button class="menu-btn">ボタン4</button>
    </div>
  </div>
  <!-- データ表示テーブル -->
  <div style="width:90%;margin:40px auto 0;">
    <?php if (isset($errorMsg)): ?>
      <div style="color:red;"><?php echo $errorMsg; ?></div>
    <?php elseif (!empty($rows)): ?>
      <table border="1" cellpadding="8" cellspacing="0" style="width:100%;background:#fff;border-collapse:collapse;">
        <thead>
          <tr>
            <?php foreach(array_keys($rows[0]) as $col): ?>
              <th><?php echo htmlspecialchars($col, ENT_QUOTES, 'UTF-8'); ?></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach($rows as $row): ?>
            <tr>
              <?php foreach($row as $cell): ?>
                <td><?php echo htmlspecialchars($cell, ENT_QUOTES, 'UTF-8'); ?></td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div>データがありません。</div>
    <?php endif; ?>
  </div>
</body>
</html>