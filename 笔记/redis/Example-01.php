<?php
#加载公共文件
include_once 'common.php';

/**
 * 实例 1 单个key的 赋值、获取、删除
 */

# 清空当前数据库中的所有 key 。
$redis->flushdb();
# set 函数 给一个key赋值
$redis->set('name', 'luffyzhao');
# get 函数
$name = $redis->get('name');
dump($name); # luffyzhao

# del 函数
$rs = $redis->del('name');
dump($rs); # TRUE(1)

# get不存在的key 返回的是 bool(false)
dump($redis->get('name')); # bool(false)

# 删除key之前 判断key是否存在
if (!$redis->exists('name')) # 不存在
{
    dump($redis->del('name'));
}

/**
 *
 *     本例总共用到函数 set get del exists
 *         set 说明:
 *             将字符串值value关联到key。
 *         用法:
 *             $redis->set(String $key, String $value);
 *         get 说明:
 *             返回key所关联的字符串值。如果key不存在则返回 bool(false)
 *         用法:
 *             $redis->get(String $key);
 *         del 说明:
 *             移除给定的一个或多个key。如果key不存在，则忽略该命令返回 int(0)。
 *         用法:
 *             $redis->del($key);
 *         exists 说明:
 *             检查给定key是否存在。
 *         用法:
 *             $redis->exists($key);
 * */
