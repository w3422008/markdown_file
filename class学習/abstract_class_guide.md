# 抽象クラス（Abstract Class）とは

## 1. 簡単な説明
- 抽象クラスは **共通処理をまとめつつ、未完成の部分は子クラスに実装させるためのクラス**
- インスタンス化（new）できない
- 共通部分は親クラスに書き、変更が必要な部分は抽象メソッドとして定義する

---

## 2. イメージ例
> 「レポート作成の雛形」  
> 会社でレポートを作るとき、表紙や署名欄などは全てのレポートで共通。  
> しかし本文の内容は部署によって違う。  
> 抽象クラスはこの「共通部分」をまとめ、「違う部分」を空欄にして子クラスに書かせる。

---

## 3. 基本構文（PHP例）
```php
abstract class ReportGenerator {
    protected $title;
    protected $data;

    public function __construct($title, $data) {
        $this->title = $title;
        $this->data = $data;
    }

    public function generateHeader() {
        return "=== {$this->title} ===
";
    }

    // 抽象メソッド（中身は書かない）
    abstract public function generateContent();

    public function generateReport() {
        return $this->generateHeader() . $this->generateContent();
    }
}
```

---

## 4. 具体クラス例
```php
class CsvReportGenerator extends ReportGenerator {
    public function generateContent() {
        $lines = [];
        foreach ($this->data as $row) {
            $lines[] = implode(",", $row);
        }
        return implode("\n", $lines);
    }
}

$data = [
    ['ID', 'Name', 'Score'],
    [1, 'Alice', 88],
    [2, 'Bob', 92]
];

$report = new CsvReportGenerator("成績レポート", $data);
echo $report->generateReport();
```
- `generateHeader()` は親クラスの共通処理を使用
- `generateContent()` は子クラスで独自実装

---

## 5. システム開発での利用場面
1. **共通の流れを統一しつつ、一部だけ異なる処理を実装したいとき**
   - 例：レポート生成、ファイル変換、決済処理など
2. **テンプレートメソッドパターンを実現したいとき**
   - 処理の順番を固定し、細部だけ子クラスに任せたい
3. **チーム開発で基本形を強制したいとき**
   - 基本構造を変えさせず、差分部分だけをカスタマイズさせる

---

## 6. メリット
- **共通処理の一元化**  
  変更があっても親クラスだけ直せばOK
- **拡張性が高い**  
  新しい形式やパターンを子クラスで簡単に追加可能
- **保守性向上**  
  コードの重複を削減し、バグ修正が容易
- **処理の順序や構造を守れる**  
  テンプレートメソッドで全体の流れを統一可能

---

## 7. 注意点
- 抽象クラスは **多重継承できない**（PHPの場合）
- 全てのメソッドを抽象にするなら「インターフェース」の方が適している場合もある
- 過度に階層を深くすると可読性が下がる

---

## 8. 抽象クラス導入判断チェックリスト
以下に **2つ以上当てはまる場合** は抽象クラス導入を検討

- [ ] 共通処理が複数クラスで重複している
- [ ] 共通処理の後に行う詳細処理がクラスごとに異なる
- [ ] 処理の順序は全クラスで統一したい
- [ ] チーム開発で基本形を守らせたい
- [ ] 将来的に似た処理を行うクラスが増える可能性が高い
