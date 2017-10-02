## 介绍
一个使用`Laravel`+`Swoole`的在线聊天室。
[在线体验](http://chat.hellonine.top/)

## 环境

- PHP >=7.0
- Laravel >= 5.5 
- MySQL 
- Swoole
- Redis

## 使用

1. 

```
git clone https://github.com/nineyang/chat
```

2.

```
composer install
```

3. 

```
cp .env.example .env
```

4.

```
php artisan key:generate
```

5.

```
php artisan storage:link
```

6.
 
```
php artisan migrate
```

7. 

```
php artisan swoole:action start
```


## 效果图

![Aaron Swartz](/public/image/chat.gif)

## todo
~~1. 完成发送效果~~

~~2. 数据入库~~

3. 当前人数，用户头像，获取之前的消息，加入群时的通知，发帖时间等小效果

~~4. 上线一个体验版~~