# DockerイメージのベースとしてPHP 8.3-FPMを使用
FROM php:8.3-fpm

# Composerを最新バージョンからコピーし、システム全体で利用可能にする
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# aptパッケージリストを更新
RUN apt-get update

# 必要なシステムライブラリとツールをインストール
RUN apt-get install -y git zip unzip curl gnupg \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP拡張機能の依存ライブラリを次のRUNコマンドで試す
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libzip-dev \
    pkg-config \
    build-essential \
    libmariadb-dev-compat \
    # ここに libonig-dev を戻す！
    libonig-dev \
    # その他のビルド関連ツールは一旦コメントアウトしたままにする
    # autoconf \
    # file \
    # gcc \
    # libc-dev \
    # make \
    # patch \
    # re2c \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP拡張機能をインストールし、opcacheを有効にする
RUN docker-php-ext-install -j$(nproc) mbstring pdo_mysql
RUN docker-php-ext-enable mbstring pdo_mysql

RUN docker-php-ext-install -j$(nproc) xml
RUN docker-php-ext-enable xml

RUN docker-php-ext-install -j$(nproc) zip
RUN docker-php-ext-enable zip

RUN docker-php-ext-install -j$(nproc) bcmath
RUN docker-php-ext-enable bcmath

# 全て成功したらopcacheを有効化
RUN docker-php-ext-enable opcache

# GD拡張機能のインストール（必要であればコメント解除）
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install -j$(nproc) gd \
#     && docker-php-ext-enable gd

# Node.js 20.xをインストールする
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# コンテナ内の作業ディレクトリを /var/www/html に設定
WORKDIR /var/www/html

# ホストのビルドコンテキスト（Laravelプロジェクトのルート）から全てのファイルをコンテナの /var/www/html にコピー
COPY . /var/www/html

# Laravelのストレージとキャッシュディレクトリのパーミッションを設定
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
#     && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache