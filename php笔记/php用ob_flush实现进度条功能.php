<div id="notice"></div>
<script type="text/javascript">
function showmessage(message,width) {
    document.getElementById('notice').innerHTML = '<div style="width:200px;border: 1px solid; border-radius: 6px;"><div style="background-color:sandybrown;line-height: 15px;height: 15px;border-radius: 6px; width:' + width + '"><span style="width:200px;position: absolute;text-align: center;">上传进度：' + message + '</span></div></div>';
}
</script>

<?php
	
	function showjsmessage($message,$width)
	{
		echo '<script type="text/javascript">showmessage(\''.addslashes($message) . '\',\'' . $width . '\');</script>';
		ob_flush();
		flush();
	}
	$totalnum = 1000;
	for ($i = 1; $i <= $totalnum; $i++) {
		$message = $i . '/' . $totalnum;
		$width = $i/$totalnum * 100;
		$showwidth = $width . "%";
		showjsmessage($message,$showwidth);
		
		usleep(100000);
	}
?>