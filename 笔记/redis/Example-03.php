<?php
#加载公共文件
include_once 'common.php';

/**
 * 实例 3 msetnx keys 用法
 */

# 清空当前数据库中的所有 key 。
$redis->flushdb();
# 对不存在的key 进行msetnx关联
$array_mset = [
    'name'     => 'luffyzhao',
    'sex'      => 'boy',
    'birthday' => '3.11',
];
$rs = $redis->msetnx($array_mset);
dump($rs); #bool(true)

# 对已存在的key 进行msetnx关联
$array_mset = [
    'name' => 'william',
    'from' => 'china',
];
$rs = $redis->msetnx($array_mset);
dump($rs); #操作失败 > bool(false)

$exists = $redis->exists('from');
dump($exists); # 因为操作是原子性的，from没有被设置  > bool(false)

$name = $redis->get('name');
dump($name); # name没有被修改 //"william"

$array_mset_keys = array('name', 'sex', 'birthday');
$mget            = $redis->mget($array_mset_keys);
dump($mget); # [ 0 => 'luffyzhao', 1 => 'boy', 2 => '3.11']

# 查找符合给定模式的key。KEYS pattern
$keys = $redis->keys('*');
dump($keys); # 返回redis里所有的key

/**
 *
 *     本例总共用到函数 msetnx keys
 *         msetnx 说明:
 *             同时设置一个或多个key-value对，当且仅当key不存在。
 *             即使只有一个key已存在，MSETNX也会拒绝所有传入key的设置操作。
 *             MSETNX是原子性的，因此它可以用作设置多个不同key表示不同字段(field)的唯一性逻辑对象(unique logic object)，所有字段要么全被设置，要么全不被设置。
 *         用法:
 *             $redis->msetnx(['name'=>'luffyzhao','sex'=>'boy']);
 *         keys 说明:
 *             KEYS pattern 查找符合给定模式的key。
 *             KEYS *命中数据库中所有key。
 *             KEYS h?llo命中hello， hallo and hxllo等。
 *             KEYS h*llo命中hllo和heeeeello等。
 *             KEYS h[ae]llo命中hello和hallo，但不命中hillo。
 *             特殊符号用"\"隔开
 *         用法:
 *             $keys = $redis->keys('*');
 * */
