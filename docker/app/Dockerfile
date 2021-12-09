# どんな docker イメージを利用して構築をするか
# FROM : ここではPHPの公式イメージである「php:7.4-apache」というあらかじめPHPとApacheがインストールされているイメージを、Docker Hubというサイトからダウンロードしてくるようになっている。
FROM php:7.4-apache

RUN cd /etc/apache2/mods-enabled \
    && ln -s ../mods-available/rewrite.load

# 設定ファイルをdockerコンテナ内のPHP、Apacheに読み込ませる
# ADD：ローカルのファイルをDockerコンテナ内にコピーする
ADD php.ini /usr/local/etc/php/
ADD 000-default.conf /etc/apache2/sites-enabled/

# Composerのインストール
# RUN：コンテナ内でコマンド実行する
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer

# Node.jsをインストール
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

# ミドルウェアのインストール
RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim \
libpng-dev \
libpq-dev \
&& apt-get install -y supervisor \
&& docker-php-ext-install pdo_mysql && \
pecl install xdebug && \
docker-php-ext-enable xdebug