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
php artisan key:generate
```

5.
 
```php
php artisan migrate
```

6. 

```php
php artisan swoole:action start
```


## 效果图

![Aaron Swartz](/public/image/chat.gif)

## todo
~~1. 完成发送效果~~

~~2. 数据入库~~

3. 当前人数，用户头像，获取之前的消息，加入群时的通知，发帖时间等小效果

4. 上线一个体验版