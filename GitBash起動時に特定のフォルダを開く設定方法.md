# Git Bash 起動時に特定のフォルダを開く設定方法

## 目的
Git Bash を起動した際に、自動的に指定したフォルダ（例: `/c/xampp/htdocs/software_dev/`）に移動するよう設定します。

---

## 手順

### 1. `.bashrc` ファイルを作成・編集
以下のコマンドを入力し、`.bashrc` ファイルを開きます:

```bash
nano ~/.bashrc
```

### 2. フォルダパスを記述
ファイルの最後に、以下の内容を追加してください:

```bash
cd /c/xampp/htdocs/software_dev/
```

※ `/c/xampp/htdocs/software_dev/` を実際に移動したいフォルダのパスに置き換えてください。

### 3. 保存
`Ctrl + O` を押します。

表示される「Write to File」の箇所に「`~/.bashrc`」と記載されている場合、そのまま `Enter` を押してください。

### 4. エディタを終了
`Ctrl + X` を押して nano エディタを終了します。

### 5. 設定を反映
以下のコマンドを実行し、設定を反映させます:

```bash
source ~/.bashrc
```

### 6. 確認方法
1. Git Bash を閉じて再起動します
2. 起動時に指定したフォルダ（例: `/c/xampp/htdocs/software_dev/`）が開いていることを確認します

---

## トラブルシューティング

### $HOME の確認
以下のコマンドで `$HOME` の設定を確認してください:

```bash
echo $HOME
```

通常は `/c/Users/ユーザー名` に設定されている必要があります。必要に応じて `etc/profile` ファイルを修正してください。