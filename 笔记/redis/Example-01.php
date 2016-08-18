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

#setnx 给一个key赋值 如果key 存在 setnx 则不做任何动作。
$redis->setnx('name', 'william');

# setex 给key 赋值并设置生存时间, 如果 key 存在 setex将覆盖原来的值
$redis->setex('name', 600, 'william');

#用value参数覆写(Overwrite)给定key所储存的字符串值，从偏移量offset开始。
#不存在的key当作空白字符串处理。
# 当生成一个很长的字符串时，Redis需要分配内存空间，该操作有时候可能会造成服务器阻塞(block)。
# 在2010年的Macbook Pro上，设置偏移量为536870911(512MB内存分配)，耗费约300毫秒，
# 设置偏移量为134217728(128MB内存分配)，耗费约80毫秒，
# 设置偏移量33554432(32MB内存分配)，耗费约30毫秒，
# 设置偏移量为8388608(8MB内存分配)，耗费约8毫秒。
# 注意若首次内存分配成功之后，再对同一个key调用SETRANGE操作，无须再重新内存。

# 情况1：对非空字符串进行SETRANGE
$redis->set('greeting', "hello world");
$redis->setrange('greeting', 6, "Redis"); //int(11)
dump($redis->get('greeting')); //"hello Redis"

# 情况2：对空字符串/不存在的key进行SETRANGE
$redis->exists('empty_string'); //bool(false)
# 对不存在的key使用SETRANGE //int(11)
$redis->setrange('empty_string', 5, "Redis!");
# 空白处被"\x00"填充  #"\x00\x00\x00\x00\x00Redis!"   //return string(11) "Redis!"
dump($redis->get('empty_string'));

#如果key已经存在并且是一个字符串，APPEND命令将value追加到key原来的值之后。
#如果key不存在，APPEND就简单地将给定key设为value，就像执行SET key value一样。
$redis->append('name', ' is dog!');
dump($redis->get('name')); // william is dog!

# 返回key中字符串值的子字符串，字符串的截取范围由start和end两个偏移量决定(包括start和end在内)。
# 负数偏移量表示从字符串最后开始计数，-1表示最后一个字符，-2表示倒数第二个，以此类推。
# getrange通过保证子字符串的值域(range)不超过实际字符串的值域来处理超出范围的值域请求。

dump($redis->getrange('name', 0, 6)); // william

#将给定key的值设为value，并返回key的旧值。
#当key存在但不是字符串类型时，返回一个错误。
dump($redis->getset('name', 'pony is cat!')); // william is dog!
dump($redis->get('name')); // pony is cat!

#返回key所储存的字符串值的长度。
#当key储存的不是字符串值时，返回一个错误。
dump($redis->strlen('name')); // 12
dump($redis->strlen('null_key')); // 0
$redis->set('number', 4);
dump($redis->strlen('number')); //1
$redis->lpush('list', 5);
dump($redis->strlen('list')); //false

#将key中储存的数字值增一。
#如果key不存在，以0为key的初始值，然后执行INCR操作。
#如果值包含错误的类型，或字符串类型的值不能表示为数字，那么返回一个错误。
#本操作的值限制在64位(bit)有符号数字表示之内。
$redis->incr('number');
dump($redis->get('number')); // 5

#将key所储存的值加上增量increment。
#如果key不存在，以0为key的初始值，然后执行INCRBY命令。
#如果值包含错误的类型，或字符串类型的值不能表示为数字，那么返回一个错误。
#本操作的值限制在64位(bit)有符号数字表示之内。
#关于更多递增(increment)/递减(decrement)操作信息，参见INCR命令。
$redis->incrby('number', 5);
dump($redis->get('number')); // 10

# 将key中储存的数字值减一。
# 如果key不存在，以0为key的初始值，然后执行DECR操作。
# 如果值包含错误的类型，或字符串类型的值不能表示为数字，那么返回一个错误。
# 本操作的值限制在64位(bit)有符号数字表示之内。
#
$redis->decr('number');
dump($redis->get('number')); // 9

# 将key所储存的值减去减量decrement。
$redis->decrby('number', 4);
dump($redis->get('number')); // 5

$redis->flushdb();
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
