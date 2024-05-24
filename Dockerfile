# 使用官方的 PHP Apache 映像
FROM php:8.2-apache

# 安裝系統依賴
RUN apt-get update
RUN apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql zip

# 安裝 Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 設定工作目錄
WORKDIR /var/www/html

# 複製所有檔案到容器內
COPY . .

# 賦予存取權限
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 啟用 Apache mod_rewrite
RUN a2enmod rewrite

# 複製 Apache 設定文件
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf


ENV XDEBUG_MODE=coverage
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer update
RUN composer install
RUN a2enmod rewrite

EXPOSE 80
