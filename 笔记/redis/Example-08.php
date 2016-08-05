<?php

#加载公共文件
include_once 'common.php';

$redis->flushdb();
# 设置一个字符串
$redis->set('name', "luffyzhao");
# 查看引用次数
dump($redis->object('REFCOUNT', 'name')); #> int(1)

// sleep(1);
# 查看空闲时间
dump($redis->object('IDLETIME', 'name')); # > int(1)

# 字符串的编码方式
dump($redis->object('ENCODING', 'name')); # > string(6)"embstr" 注：3.0开始 字节长度大于 39 时 字符串编码返回的是 string(3) "raw"

/**
 * ENCODING：讲解, 大的数字返回的也是 "raw" 或者 "embstr" 小的数字返回int
 * 字符串可以被编码为raw(一般字符串)或int(用字符串表示64位数字是为了节约空间)。3.0开始 字节长度小于 39 时 字符串编码返回的是 embstr
 * 列表可以被编码为ziplist或linkedlist。ziplist是为节约大小较小的列表空间而作的特殊表示。
 * 集合可以被编码为intset或者hashtable。intset是只储存数字的小集合的特殊表示。
 * 哈希表可以编码为zipmap或者hashtable。zipmap是小哈希表的特殊表示。
 * 有序集合可以被编码为ziplist或者skiplist格式。ziplist用于表示小的有序集合，而skiplist则用于表示任何大小的有序集合。
 **/
