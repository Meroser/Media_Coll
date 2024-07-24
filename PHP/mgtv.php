<?php
// 获取传入的 ID
$id = $_GET['id'];

$channelIDDict = array(
    'klg' => '267',  // 快乐购
    'hnjs' => '280',  // 湖南经视
    'hnyl' => '344',  // 湖南娱乐
    'hndy' => '221',  // 湖南电影
    'hnds' => '346',  // 湖南都市
    'hndsj' => '484',  // 湖南电视剧
    'jyjs' => '316',  // 金鹰纪实
    'hnaw' => '261',  // 湖南爱晚
    'jykt' => '287',  // 金鹰卡通
    'gjpd' => '229',  // 国际频道
    'xfpy' => '329',  // 先锋乒羽
    'cpd' => '578',  // 茶频道
    'klcd' => '218',  // 快乐垂钓
    'csxw' => '269',  // 长沙新闻综合
    'cszf' => '254',  // 长沙政法
);

// 检查 ID 是否存在于字典中
if (array_key_exists($id, $channelIDDict)) {

    // 构建HTTP请求头
    $headers = array(
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0',
    );

    $url = 'http://mpp.liveapi.mgtv.com/v1/epg/turnplay/getLivePlayUrlMPP?version=PCweb_1.0&platform=1&buss_id=2000001&channel_id=' . $channelIDDict[$id];

    // 初始化 cURL
    $ch = curl_init();

    // 设置 cURL 选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    // 执行请求并获取响应
    $response = curl_exec($ch);

    // 关闭 cURL 资源
    curl_close($ch);

    // 数据转换
    $data = json_decode($response, true);

    // print_r($data);
    $playUrl = $data['data']['url'];
    header('Location: ' . $playUrl);
    // echo $playUrl;

} else {
    // ID 不存在于字典中，返回预设定视频流
    $playUrl = 'http://liveflash.sxrtv.com/live/huanghe.m3u8?sub_m3u8=true&edge_slice=true';
    header('Location: ' . $playUrl);
    // echo "https://raw.githubusercontent.com/Meroser/Media_Coll/main/demo.m3u8";
}
?>
