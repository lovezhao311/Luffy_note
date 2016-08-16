<?php
#加载公共文件
include_once 'common.php';

/**
 * 实例 10 排序
 */
/*
array(
'by' => 'pattern',          // 匹配模式
'limit' => array(0, 1),     // 分页
'get' => 'pattern',         // 返回值匹配
'sort' => 'asc' or 'desc',  // 排序方式
'alpha' => TRUE,            // 修饰符
'store' => 'external-key'   // 结果保存的key
);
 */

$redis->flushdb();
# 一般 sort 用法
# 最简单的 sort 使用方法是 sort key。
# 假设 today_cost 是一个保存数字的列表，SORT命令默认会返回该列表值的递增(从小到大)排序结果。
# 将数据一一加入到列表中
$redis->lpush('today_cost', 30);
$redis->lpush('today_cost', 1.5);
$redis->lpush('today_cost', 10);
$redis->lpush('today_cost', 8);
# 正序
dump($redis->sort('today_cost'));
/**
结果
array (
0 => '1.5',
1 => '8',
2 => '10',
3 => '30',
)
 **/

# 正序
dump($redis->sort('today_cost', ['sort' => 'ASC']));
/**
结果
array (
0 => '1.5',
1 => '8',
2 => '10',
3 => '30',
)
 **/

# 倒序
dump($redis->sort('today_cost', ['sort' => 'DESC']));
/**
结果
array (
0 => '30',
1 => '10',
2 => '8',
3 => '1.5',
)
 */

$redis->flushdb();
# 当数据集中保存的是字符串值时，你可以用 alpha 修饰符(modifier)进行排序。
# 将数据一一加入到列表中
$redis->lpush('website', "baidu.com");
$redis->lpush('website', "github.com");
$redis->lpush('website', "luffyzhaocms.com");
# 默认排序

# 字符串修饰 ALPHA=true
# 默认排序
dump($redis->sort('website', ['ALPHA' => true]));
/**
结果
array (
0 => 'baidu.com',
1 => 'github.com',
2 => 'luffyzhaocms.com',
)
 **/

# 顺序
dump($redis->sort('website', ['ALPHA' => true, 'sort' => 'ASC']));
/**
结果
array (
0 => 'baidu.com',
1 => 'github.com',
2 => 'luffyzhaocms.com',
)
 **/

# 倒序
dump($redis->sort('website', ['ALPHA' => true, 'sort' => 'DESC']));
/**
结果
array (
0 => 'luffyzhaocms.com',
1 => 'github.com',
2 => 'baidu.com',
)
 **/

/**
 * 使用外部key进行排序
 * 有时候你会希望使用外部的key作为权重来比较元素，代替默认的对比方法。
 * 假设现在有用户(user)数据如下：
 *
 * id　　　  name　　　　level         password
 * ------------------------------------------------
 * 1        admin       9999            a_long_long_password
 * 2        huangz      10              nobodyknows
 * 59230    jack 　　   3               jack201022
 * 222      hacker 　   9999            hey,im in
 *
 * id数据保存在key名为user_id的列表中。
 * name数据保存在key名为user_name_{id}的列表中
 * level数据保存在user_level_{id}的key中。
 *
 **/

$redis->flushdb();
# 先将要使用的数据加入到数据库中

# admin
$redis->lpush('user_id', 1);
$redis->set('user_name_1', 'admin');
$redis->set('user_level_1', 9999);
$redis->set('user_password_1', "a_long_long_password");

#huangz
$redis->lpush('user_id', 2);
$redis->set('user_name_2', 'huangz');
$redis->set('user_level_2', 10);
$redis->set('user_password_2', "nobodyknows");

#jack
$redis->lpush('user_id', 59230);
$redis->set('user_name_59230', 'jack');
$redis->set('user_level_59230', 3);
$redis->set('user_password_59230', "jack201022");

#hacker
$redis->lpush('user_id', 222);
$redis->set('user_name_222', 'hacker');
$redis->set('user_level_222', 9999);
$redis->set('user_password_222', "hey,im in");

#如果希望按level从大到小排序user_id，可以使用以下命令：
dump($redis->sort('user_id', [
    'by'   => 'user_level_*',
    'sort' => 'DESC',
]));

/**
结果
array (
0 => '222',
1 => '1',
2 => '2',
3 => '59230',
)
 **/
#通过user_id的倒序查user_name
dump($redis->sort('user_id', [
    'sort' => 'DESC',
    'get'  => 'user_name_*',
]));
/**
结果
array (
0 => 'jack',
1 => 'hacker',
2 => 'huangz',
3 => 'admin',
)
 **/

#但是有时候只是返回相应的id没有什么用，你可能更希望排序后返回id对应的用户名，这样更友好一点，使用GET选项可以做到这一点：
dump($redis->sort('user_id', [
    'by'   => 'user_level_*',
    'sort' => 'DESC',
    'get'  => 'user_name_*',
]));
/**
结果
array (
0 => 'hacker',
1 => 'admin',
2 => 'huangz',
3 => 'jack',
)
 */

# 可以多次地、有序地使用GET操作来获取更多外部key。
# 比如你不但希望获取用户名，还希望连用户的密码也一并列出，可以使用以下命令：
dump($redis->sort('user_id', [
    'by'   => 'user_level_*',
    'sort' => 'DESC',
    'get'  => ['user_name_*', 'user_password_*'],
]));
/**
结果
array (
0 => 'hacker',
1 => 'hey,im in',
2 => 'admin',
3 => 'a_long_long_password',
4 => 'huangz',
5 => 'nobodyknows',
6 => 'jack',
7 => 'jack201022',
)
 **/

# GET还有一个特殊的规则——"GET #"，用于获取被排序对象(我们这里的例子是user_id)的当前元素。
# 比如你希望user_id按level排序，还要列出id、name和password，可以使用以下命令：
dump($redis->SORT('user_id', [
    'by'   => 'user_level_*',
    'sort' => 'DESC',
    'get'  => ['#', 'user_name_*', 'user_password_*'],
]));
/**
结果
array (
0 => '222',
1 => 'hacker',
2 => 'hey,im in',
3 => '1',
4 => 'admin',
5 => 'a_long_long_password',
6 => '2',
7 => 'huangz',
8 => 'nobodyknows',
9 => '59230',
10 => 'jack',
11 => 'jack201022',
)
 **/
$redis->flushdb();
