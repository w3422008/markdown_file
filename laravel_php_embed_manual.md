# 🚀 Laravelプロジェクトに「生PHPファイル」を組み込む手順（menu_with_navbar.php編）

---

> **❗️重要ポイント**
> - **Laravelは「コントローラー」＋「ビュー（Blade）」＋「ルーティング」の構造が基本！**
> - **DB接続情報は `.env` ファイルで管理します。PHPファイルに直書きはNG！**

---

## 🔷 全体の流れ

1. **コントローラー**を作成し、DB処理を担当させる
2. **ビュー（Bladeテンプレート）**を作成し、HTML＋表示処理を担当させる
3. **ルーティング**を追加してURLとコントローラーを紐付ける

---

## ✏️ 1. コントローラーを新規作成

**ファイル:**  
`app/Http/Controllers/MenuController.php`

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
            // ✅【DBからデータ取得する部分】（sample_tableから全件取得）
            $rows = DB::table('sample_table')->get();
            $rows = json_decode(json_encode($rows), true); // コレクション→配列変換
            $errorMsg = null;
        } catch (\Exception $e) {
            $errorMsg = "DB接続エラー: " . $e->getMessage();
            $rows = [];
        }
        // ✅【ビューへデータを渡す】
        return view('menu_with_navbar', compact('rows', 'errorMsg'));
    }
}
```

> **🟡ポイント:**  
> - `DB::table(...)` でDB接続＆データ取得  
> - エラー時は `$errorMsg` をセット  
> - `view()` でビュー（Bladeファイル）にデータを渡します

---

## ✏️ 2. ビュー（Blade）を新規作成

**ファイル:**  
`resources/views/menu_with_navbar.blade.php`

```php
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>メニュー画面</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* ...（元のCSSをそのまま貼り付け）... */
  </style>
</head>
<body>
  <div class="navbar">メニュー画面</div>
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
    {{-- ✅【エラーメッセージ表示】 --}}
    @if(isset($errorMsg) && $errorMsg)
      <div style="color:red;">{{ $errorMsg }}</div>
    {{-- ✅【テーブル表示】 --}}
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

> **🟠ポイント:**  
> - `@if`/`@foreach` など**Blade構文**を使う  
> - **エラーメッセージ**や**テーブル**表示部分にもコメントを入れて目立たせる

---

## ✏️ 3. ルーティングを追加

**ファイル:**  
`routes/web.php`

```php
// === ここから追記 ===
use App\Http\Controllers\MenuController;

Route::get('/menu', [MenuController::class, 'show']);
// === ここまで追記 ===
```

> **🟢ポイント:**  
> - 追記部分をコメントで強調  
> - `/menu` でアクセスできるようになります！

---

## ✅ まとめ＆チェックリスト

- [x] コントローラー（`MenuController.php`）を作成した
- [x] ビュー（`menu_with_navbar.blade.php`）を作成した
- [x] ルーティング（`routes/web.php`）を追記した
- [x] `.env` ファイルでDB接続情報を設定した

---

> **⚠️ 注意:**  
> - Laravelプロジェクトでは**生PHPファイルを直接`public/`配下に置くのは非推奨**です！必ずBlade＋コントローラーに移行しましょう。
> - **DB接続情報は`.env`ファイルに記載**し、`config/database.php`も合わせて確認してください。

---

## 🎉 これで `/menu` で画面＆DBデータが表示されます！