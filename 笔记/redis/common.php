<?php
$redis = new Redis();
/**
 * connect, open 链接redis服务
 *     参数
 *         host: string，服务地址
 *         port: int,端口号
 *         timeout: float,链接时长 (可选, 默认为 0 ，不限链接时间)
 *         注: 在redis.conf中也有时间，默认为300
 *
 * pconnect, popen 不会主动关闭的链接
 *     参数: 参考上面
 *
 * setOption 设置redis模式
 * getOption 查看redis设置的模式
 * ping 查看连接状态
 */

#本例用的都是 connect 函数连接redis服务
$redis->connect('127.0.0.1', 6379);

/**
 * 浏览器友好的变量输出
 * @param mixed         $var 变量
 * @param boolean       $echo 是否输出 默认为true 如果为false 则返回输出字符串
 * @param string        $label 标签 默认为空
 * @return void|string
 */
function dump($var, $echo = true, $label = null)
{
    $label = (null === $label) ? '' : rtrim($label) . ':';
    ob_start();
    var_dump($var);
    $output = ob_get_clean();
    $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);

    if (!extension_loaded('xdebug')) {
        $output = htmlspecialchars($output, ENT_QUOTES);
    }
    $output = '<pre>' . $label . $output . '</pre>';

    if ($echo) {
        echo ($output);
        return null;
    } else {
        return $output;
    }
}
