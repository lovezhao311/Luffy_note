<?php
#加载公共文件
include_once 'common.php';

/**
 * 实例 4  key 生存时间
 */

# 清空当前数据库中的所有 key 。
$redis->flushdb();
$redis->set('name', 'luffyzhao');
# 为给定key设置生存时间。
$redis->expire('name', 100);
// sleep(4);###
# 返回给定key的剩余生存时间(time to live)(以秒为单位)
$ttl = $redis->ttl('name');
dump($ttl); # > 96

# 移除给定key的生存时间。
$redis->persist('name'); # 返回值 1 或者 0
$ttl = $redis->ttl('name');
dump($ttl); # > -1

$redis->set('name', 'luffyzhao');
$redis->expireat('name', '1355292000');

$redis->flushdb();
/**
 *
 *     本例总共用到函数 expire ttl persist
 *         expire 说明:
 *             为给定key设置生存时间。
 *         用法:
 *             $redis->expire(String $key, Int $time);
 *         ttl 说明:
 *             返回给定key的剩余生存时间(time to live)(以秒为单位)
 *         用法:
 *             $redis->ttl(String $key);
 *         persist 说明:
 *             移除给定key的生存时间。
 *         用法:
 *             $redis->persist(String $key);
 *          expireat 说明:
 *              也是给定key设置生存时间。不同在于EXPIREAT命令接受的时间参数是UNIX时间戳(unix timestamp)。
 *          用法:
 *              $redis->expireat($key,'1355292000'); # 这个key将在2012.12.12过期
 *
 * */
