<?php
#加载公共文件
include_once 'common.php';

$redis->flushdb();

$redis->hset('h', 'key1', 'hello');
$redis->hset('h', 'key2', 'word');
#向名称为h的hash中添加元素key1—>hello

dump($redis->hget('h', 'key1')); // hello
#返回名称为h的hash中key1对应的value（hello）

dump($redis->hlen('h')); // 2
#返回名称为h的hash中元素个数

$redis->hdel('h', 'key1');
#删除名称为h的hash中键为key1的域

$redis->hkeys('h');
#返回名称为key的hash中所有键

dump($redis->hvals('h'));
/**
array (
0 => '2',
1 => 'word',
)
 */
#返回名称为h的hash中所有键对应的value

dump($redis->hgetall('h'));
/**
array (
'x' => '4',
'key2' => 'word',
)
 **/
#返回名称为h的hash中所有的键（field）及其对应的value

$redis->hexists('h', 'a'); // false
#名称为h的hash中是否存在键名字为a的域

$redis->hincrby('h', 'x', 2);
#将名称为h的hash中x的value增加2
#当域 不存在时 按 0 计算
dump($redis->hget('h', 'x')); // 2

$redis->hmset('user:1', array('name' => 'Joe', 'salary' => 2000, 'sex' => 1));
#向名称为key的hash中批量添加元素
dump($redis->hgetall('user:1'));
/**
array (
'name' => 'Joe',
'salary' => '2000',
'sex' => '1',
)
 **/

dump($redis->hmget('user:1', array('name', 'salary')));
#返回名称为h的hash中field1,field2对应的value
/**
array (
'name' => 'Joe',
'salary' => '2000',
)
 **/
