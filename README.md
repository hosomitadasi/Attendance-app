# Attendance-app

## 環境構築

## Dockerビルド

## Laravel環境構築
１．コンテナに入る
docker-compose exec app bash

２．composerのインストール
composer install

３． .env ファイルをコピーして編集
cp .env.example .env

４． アプリキーを生成
php artisan key:generate

５． データベースを作成後マイグレーション実行
php artisan migrate

６． ダミーデータを作成後php artisanを実行
php artisan db:seed


## 使用技術

- PHP 8.3.12
- Laravel 8.83.29
- MySQL 8.0.26
- nginx 1.21.1
- Docker / Docker Compose
- Mailtrap
- PHPUnit

## メール認証
　認証用としてmailtrapを利用しています。.env に以下のように設定してください。

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=＜Mailtrapのユーザー名＞
MAIL_PASSWORD=＜Mailtrapのパスワード＞
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="Attendance App"

## PHP unitを利用したテストに関して
　テスト用としてPHP unitを利用しています。以下のコマンドでテストを実行できます。
　php artisan test

## ルート確認
　次のルートから管理者、一般ユーザーそれぞれのログイン画面に入ることができます。

一般ユーザー：localhost/login

管理者：localhost/admin/login