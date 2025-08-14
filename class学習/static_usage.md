# PHPにおける `static` の活用とメリット

## ✅ `static` を使うメリット一覧

### 1. インスタンス化不要でアクセス可能
- クラスを new しなくても、直接 `ClassName::method()` や `ClassName::$property` で使える
- 軽量で効率的。ユーティリティ関数や設定管理に最適

```php
Config::getAppName();  // new Config() は不要
```

### 2. 状態をクラス全体で共有できる
- 静的プロパティはすべての呼び出しで共通の値を保持
- 例：接続回数、ログ履歴、グローバル設定など

```php
Logger::$logCount++;  // 全体で共有されるカウンター
```

### 3. ユーティリティ関数の定義に最適
- 文字列処理、日付計算、バリデーションなど、状態を持たない処理に向いている

```php
class StringUtil {
    public static function toSnakeCase($str) {
        return strtolower(preg_replace('/[A-Z]/', '_$0', $str));
    }
}
```

### 4. ファクトリメソッドやシングルトンパターンに活用できる
- インスタンス生成を制御する設計において、static は重要な役割を果たす

```php
public static function create($data) {
    return new self($data);
}
```

### 5. 継承と late static binding による柔軟性

```php
class Base {
    public static function whoAmI() {
        echo static::class;
    }
}

class Child extends Base {}

Child::whoAmI();  // → Child
```

### 6. グローバルな設定・定数の管理に便利

```php
class AppConfig {
    public static $timezone = 'Asia/Tokyo';
    public static $version = '1.0.0';
}
```

---

## 🧠 状態を持たない処理の例

### 文字列変換・整形

```php
class StringHelper {
    public static function slugify($text) {
        return strtolower(preg_replace('/[^a-z0-9]+/', '-', trim($text)));
    }
}
```

### 日付・時間のフォーマット

```php
class DateHelper {
    public static function formatDate($date, $format = 'Y-m-d') {
        return date($format, strtotime($date));
    }
}
```

### バリデーション処理

```php
class Validator {
    public static function isEmail($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
```

### 暗号化・ハッシュ化

```php
class Security {
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
```

---

## 🧱 共有すべき情報の例

### アプリケーション設定

```php
class AppConfig {
    public static $timezone = 'Asia/Tokyo';
    public static $version = '1.2.3';
}
```

### 接続統計・アクセスカウント

```php
class AccessTracker {
    private static $count = 0;

    public static function increment() {
        self::$count++;
    }

    public static function getCount() {
        return self::$count;
    }
}
```

### 定数管理

```php
class StatusCode {
    const OK = 200;
    const NOT_FOUND = 404;
    const SERVER_ERROR = 500;
}
```

### 環境設定の切り替え

```php
class Environment {
    public static $mode = 'production';

    public static function isDebug() {
        return self::$mode === 'development';
    }
}
```

---

## 🧭 まとめ：静的にすべき典型パターン

| 分類             | よく使われる例                | 理由                           |
|------------------|------------------------------|--------------------------------|
| 状態を持たない処理 | 文字列変換、日付整形、バリデーション | 副作用がなく、再利用性が高い   |
| 共有すべき情報    | 設定値、統計、定数、環境モード      | クラス全体で一貫性を保ちたい   |
