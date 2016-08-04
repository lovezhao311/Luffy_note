<?php
#加载公共文件
include_once 'common.php';

/**
 * 5 将当前数据库(默认为0)的key移动到给定的数据库db当中。
 */

# 清空所有数据库中的所有key
$redis->flushall();

# redis默认使用数据库0，为了清晰起见，这里再显式指定一次。
$redis->select(0);
$redis->set('name', "luffyzhao");
dump($redis->move('name', 1)); # 将name移动到数据库1 > bool(true)
# 当 key 不存在的时候
$redis->select(1);
dump($redis->exists('sex')); # > bool(false);
dump($redis->move('sex', 0)); # 试图从数据库1移动一个不存在的key到数据库0，失败 > bool(false)

/**
 *
 *     本例总共用到函数 select move
 *         select 说明:
 *             指定当前使用的数据库
 *         用法:
 *             $redis->select($databasename);
 *         move 说明:
 *             将当前数据库(默认为0)的key移动到给定的数据库db当中。
 *             如果当前数据库(源数据库)和给定数据库(目标数据库)有相同名字的给定key，或者key不存在于当前数据库，那么MOVE没有任何效果。
 *             因此，也可以利用这一特性，将MOVE当作锁(locking)原语。
 *         用法:
 *             $redis->move(String $key, $databasename);
 * */
