## 介绍
一个使用`Laravel`+`Swoole`的在线聊天室。

## 使用
1. 

```php
git clone https://github.com/nineyang/chat
```

2.

```php
composer install
```

3. 

```php
cp .env.example .env
```

4.
 
```php
php artisan migrate
```

5. 

```php
php artisan swoole:action start
```


## 效果图

![Aaron Swartz](/public/image/chat.gif)

## todo
~~1. 完成发送效果~~

2. 数据入库