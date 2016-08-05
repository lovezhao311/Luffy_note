<?php
#加载公共文件
include_once 'common.php';

/**
 * 实例 1 返回key所储存的值的类型。
 */

$redis->flushALL();

#情况1  key不存在
dump($redis->type('fake_key')); # > int(0)

#情况2 字符串类型
$redis->set('weather', "sunny"); # 构建一个字符串
dump($redis->type('weather')); # >int(1)

#情况3 集合类型
$redis->sadd('pat', "dog"); # 构建一个集合
dump($redis->type('pat')); # >int(2)

#情况4 列表类型
$redis->lpush('book_list', "programming in scala"); # 构建一个列表
dump($redis->type('book_list')); # >int(3)

#情况5 有序集类型
$redis->zadd('pats', 1, 'cat'); # 构建一个zset (sorted set) // int(1)
$redis->zadd('pats', 2, 'dog');
$redis->zadd('pats', 3, 'pig');
// dump($redis->zRange('pats', 0, -1)); // array(3) { [0]=> string(3) "cat" [1]=> string(3) "dog" [2]=> string(3) "pig" }
dump($redis->type('pats')); # >int(4)

#情况6 哈希类型
$redis->hset('website', 'google', 'www.g.cn'); # 一个新域
// dump($redis->hget('website', 'google')); //string(8) "www.g.cn"
dump($redis->type('website')); # >int(5)

/**
 * 总结
 *     用法
 *         $redis->type($key);
 *     返回值
 *         int(0) key 不存在
 *         int(1) 字符串类型
 *         int(2) 集合类型
 *         int(3) 列表类型
 *         int(4) 有序集类型
 *         int(5) 哈希类型
 **/
