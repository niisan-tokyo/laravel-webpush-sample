# サービスワーカーを使ったプッシュ通知の例

自身のPC上のみでプッシュ通知を完遂することができる。
dockerが必要。

# 使用方法

## リポジトリをクローン

```
git clone https://github.com/niisan-tokyo/laravel-webpush-sample.git
```

## 初期設定をする

```
cd compose
# サーバを立ち上げる
docker-compose up -d nginx
# ワークスペースに入る
docker-compose run --rm workspace
# 設定をする
composer install
php artisan migrate
php artisan webpush:vapid
# ワークスペースを終了する
exit
```

## プッシュ通知を受け取る準備をする

http://localhost:8080/register

にて、ユーザーを登録

ログインすると、左上にプッシュ通知を許可するかどうか出てくるので、許可を出しておく。  
画面はこのまま閉じる。

## プッシュ通知を送る

プッシュ通知をシステムに登録しているユーザーに送付する

```
# ワークスペースに入る
docker-compose run --rm workspace
# プッシュ通知を流す
php artisan webpush:test
```

これで、プッシュ通知が自身のPCに飛んでくればオーケー