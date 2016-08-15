<?php
#加载公共文件
include_once 'common.php';

/**
 * 实例 10 排序
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
# 排序
dump($redis->sort('today_cost'));

/**
结果
array (
0 => '1.5',
1 => '8',
2 => '10',
3 => '30',
)
 */

# 当数据集中保存的是字符串值时，你可以用 alpha 修饰符(modifier)进行排序。

# 将数据一一加入到列表中
$redis->lpush('website', "baidu.com");
$redis->lpush('website', "github.com");
$redis->lpush('website', "luffyzhaocms.com");
# 默认排序
dump($redis->sort('website'));

# 按字符排序 ALPHA=true
dump($redis->sort('website', ['ALPHA' => true]));
