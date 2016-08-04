<?php
#加载公共文件
include_once 'common.php';

/**
 * 实例 2 多个key的 赋值、获取、删除
 */

# 清空当前数据库中的所有 key 。
$redis->flushdb();
$array_mset = [
    'name'     => 'luffyzhao',
    'sex'      => 'boy',
    'birthday' => '3.11',
];
# mset 多个key赋值
$redis->mset($array_mset);
$array_mget = ['name', 'sex', 'birthday'];
# mget 多个key 获取方法
$mset = $redis->mget($array_mget);
dump($mset); #  ['0'=>'luffyzhao','1'=>'boy']
# 用 mset 赋值的key 也可以用 get 来获取 反之也可
$birthday = $redis->get('birthday');
dump($birthday); # 3.11

# 同时删除多个 key 从这里可以看出 del 可以传数组也可以传字符串
$redis->del($array_mget);
$mget = $redis->mget($array_mget);
dump($mget); # ['0'=>bool(false),'1'=>bool(false)]

/**
 *
 *     本例总共用到函数 mset mget
 *         mset 说明:
 *             同时设置一个或多个key-value对。
 *             当发现同名的key存在时，MSET会用新值覆盖旧值，如果你不希望覆盖同名key，请使用MSETNX命令。
 *             MSET是一个原子性(atomic)操作，所有给定key都在同一时间内被设置，某些给定key被更新而另一些给定key没有改变的情况，不可能发生。
 *         用法:
 *             $redis->mset(['name'=>'luffyzhao','sex'=>'boy']);
 *         mget 说明
 *             返回所有(一个或多个)给定key的值。如果某个指定key不存在，那么返回bool(false)。因此，该命令永不失败。
 *         用法：
 *             $redis->mget(['name','sex']);
 * */
