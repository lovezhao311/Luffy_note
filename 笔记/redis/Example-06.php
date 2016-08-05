<?php

echo time();
exit;
#加载公共文件
include_once 'common.php';

/**
 * 实例 6 将key改名为newkey。
 */

# 清空当前数据库中的所有 key 。
$redis->flushdb();
# 情况1：key存在且newkey不存在
$redis->set('message', "hello world");
dump($redis->rename('message', 'once')); # bool(true)
dump($redis->exists('message')); # message不复存在 //bool(false)
dump($redis->exists('once')); # greeting取而代之 //bool(true)

# 情况2：当key不存在时，返回错误 ,php返回false;
dump($redis->rename('fake_key', 'never_exists')); //bool(false)

# 情况3：newkey已存在时，RENAME会覆盖旧newkey
$redis->set('pc', "lenovo");
$redis->set('personal_computer', "dell");
dump($redis->rename('pc', 'personal_computer')); //bool(true)
dump($redis->get('pc')); //(nil)   bool(false)
dump($redis->get('personal_computer')); # dell“没有”了 //string(6) "lenovo"

# 清空当前数据库中的所有 key 。
$redis->flushdb();

# 情况1：newkey不存在，成功
$redis->set('player', "MPlyaer");
$redis->exists('best_player'); //int(0)
dump($redis->renamenx('player', 'best_player')); // bool(true)

# 情况2：newkey存在时，失败
$redis->set('animal', "bear");
$redis->set('favorite_animal', "butterfly");

dump($redis->renamenx('animal', 'favorite_animal')); // bool(false)

dump($redis->get('animal')); //string(4) "bear"
dump($redis->get('favorite_animal')); //string(9) "butterfly"

/**
 *
 *     本例总共用到函数 rename renamenx
 *         select 说明:
 *             将key改名为newkey。当key和newkey相同或者key不存在时，返回一个错误。当newkey已经存在时，RENAME命令将覆盖旧值。
 *         用法:
 *             $redis->rename($key, $newkey);
 *          select 说明:
 *             当且仅当newkey不存在时，将key改为newkey。出错的情况和RENAME一样(key不存在时报错)。
 *         用法:
 *             $redis->renamenx($key, $newkey);
 * */
