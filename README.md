# 匯率轉換 API 服務

## 環境需求

- PHP 8.2
- Composer 2.x
- Laravel 11.x
- PHPUNIT

## 使用方式

### 1. 執行docker composer
```bash
docker composer up -d
```
### 2. 安裝相依套件
```bash
composer install
```

### 3. 測試
```bash
php artisan test
```

### 5. 使用方式
- method: GET
- route: /api/currency/convert
- params: source(原貨幣), target(指定貨幣), amount(原貨幣金額)
- example: /api/currency/convert?source=USD&target=TWD&amount=100
- response: {"msg": "success", "amount": "33.79"}