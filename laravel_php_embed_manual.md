# Laravelプロジェクトへ生PHPファイル（menu_with_navbar.php）を組み込む手順

Laravelでは、従来型のPHPファイルをそのまま設置して動かすのではなく、**コントローラー**と**ビュー（Bladeテンプレート）**へ分離して組み込むのが標準です。  
以下は、`menu_with_navbar.php` の内容をLaravel流に組み込む代表的な方法です。

---

## 1. 必要なファイル・場所

- **コントローラー:** `app/Http/Controllers/MenuController.php`（新規作成）
- **ビュー:** `resources/views/menu_with_navbar.blade.php`（新規作成）
- **ルーティング:** `routes/web.php`（追記）

---

## 2. 手順

### (1) コントローラーを作成

`app/Http/Controllers/MenuController.php` を新規作成し、DB接続やデータ取得処理をコントローラーに移します。

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function show()
    {
        try {
            // DB接続＆データ取得（例: sample_table から全件取得）
            $rows = DB::table('sample_table')->get();
            $rows = json_decode(json_encode($rows), true); // コレクション→配列
            $errorMsg = null;
        } catch (\Exception $e) {
            $errorMsg = "DB接続エラー: " . $e->getMessage();
            $rows = [];
        }
        return view('menu_with_navbar', compact('rows', 'errorMsg'));
    }
}
```

---

### (2) ビュー（Bladeテンプレート）を作成

`resources/views/menu_with_navbar.blade.php` を新規作成し、HTML＋PHP部分をBlade構文に置き換えます。

```php
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>メニュー画面</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* ...（スタイルは元ファイルのまま貼り付け）... */
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
    @if(isset($errorMsg) && $errorMsg)
      <div style="color:red;">{{ $errorMsg }}</div>
    @elseif(!empty($rows))
      <table border="1" cellpadding="8" cellspacing="0" style="width:100%;background:#fff;border-collapse:collapse;">
        <thead>
          <tr>
            @foreach(array_keys($rows[0]) as $col)
              <th>{{ $col }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach($rows as $row)
            <tr>
              @foreach($row as $cell)
                <td>{{ $cell }}</td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <div>データがありません。</div>
    @endif
  </div>
</body>
</html>
```

---

### (3) ルーティングを追加

`routes/web.php` に下記を追記します。

```php
use App\Http\Controllers\MenuController;

Route::get('/menu', [MenuController::class, 'show']);
```

---

## 3. 補足

- **DB接続情報は `.env` に記載**  
  LaravelではDB接続情報（ホスト名・DB名・ユーザー名・パスワード）は`.env`ファイルで管理します。`config/database.php`も合わせて確認してください。
- **古い生PHPのまま `public/` 直下に置く方法は非推奨**  
  セキュリティ・メンテナンス性の観点から、Bladeテンプレート＆コントローラー構造へ移行しましょう。

---

## 4. 手順まとめ

1. **コントローラー**を作成: `app/Http/Controllers/MenuController.php`
2. **ビュー**をBladeで作成: `resources/views/menu_with_navbar.blade.php`
3. **ルーティング**を設定: `routes/web.php`に追記
4. `http://localhost/menu` で動作確認

---