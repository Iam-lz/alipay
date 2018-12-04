public function detailAccountList()
{
$return = [
'msg' => '',
'code' => 200,
'rows' => '',
'success' => false,
];

$list_id = $this->request->get('list_id');
$search = $this->request->get('account_name');
$order = $this->request->get('order');
$sort = $this->request->get('sort');
$offset = $this->request->get('offset');
$limit = $this->request->get('limit');
$map = [];
$ids = [];
if (!empty($list_id)) {
$map['status'] = 0;
$map['list_id'] = $list_id;
$map['manager_id'] = $this->member['uid'];
}
try {
$list_total = WeiPlusAccountList::get_detail_list($map, $offset, $limit, 'all');
$list_detail = WeiPlusAccountList::get_detail_list($map, $offset, $limit, 'limit');
if ($list_detail) {
foreach ($list_detail as $k => $v) {
$ids[] = $v['account_id'];
}
} else {
$return['msg'] = '暂无数据！';
$return['success'] = true;
return Response::create($return, 'json', 200)->send();
}


$params = esConn($this->searchIndex, $this->searchType);
if (!empty ($search)) {
$params['body']['query']['function_score']['query']['bool']['filter'][] = ['wildcard' => ['weibo_name.keyword' => "*" . $search . "*"]];
}
$params['body']['query']['function_score']['query']['bool']['filter'][] = ['terms' => ['weibo_uid' => $ids]];

if (empty($offset) && empty($limit)) {
$offset = '0';
$limit = '10';
}
if (empty($sort)) {
$sort = 'weiq.weiq_index';
$order = 'desc';
} elseif ($sort == 'read_median') {
$sort = 'analysis.read_median';
} elseif ($sort == 'interact_median') {
$sort = 'analysis.interaction_median';
} elseif ($sort == 'cpm') {
$params['body']['query']['function_score']['script_score']['script'] = ['lang' => 'painless', 'inline' => "100*doc['weiq.cpm'].value"];
$sort = '_score';
} elseif ($sort == 'cpe') {
$params['body']['query']['function_score']['script_score']['script'] = ['lang' => 'painless', 'inline' => "100*doc['weiq.cpe'].value"];
$sort = '_score';
} elseif ($sort == 'weiq_index') {
$sort = 'weiq.weiq_index';
} elseif ($sort == 'weiq_post_price_adver') {
$sort = 'weiq.postprice_adver';
} elseif ($sort == 'weiq_forward_price_adver') {
$sort = 'weiq.forwardprice_adver';
} else {
$sort = $sort;
}
$params['body']['sort'] = [$sort => ['order' => $order]];
$params['body']['from'] = 0;
$params['body']['size'] = 10;

$es_config = config("data_api.es_host");
$client = ClientBuilder::create()->setHosts($es_config)->build();
$selectResult = $client->search($params);

if (empty($selectResult['hits']['hits'])) {
$return ['rows'] = '';
$return ['success'] = true;
$return ['msg'] = '暂无数据2！';
Response::create($return, 'json')->code(200)->send();
exit();
}
$hits = array_reverse($selectResult['hits']['hits']);
foreach ($hits as $k => $data) {
$arrResultCsv[$k] = $data['_source'];
}
foreach ($arrResultCsv as $k => $data) {
if (isset($data ['verified_type'])) {
if ($data ['verified_type'] == "0") {
$verified_type = '黄V';
} elseif ($data  ['verified_type'] >= 1 && $data  ['verified_type'] <= 7) {
$verified_type = '蓝V';
} elseif ($data  ['verified_type'] == "400") {
$verified_type = '已故认证用户';
} elseif ($data['verified_type'] >= 200 && $data  ['verified_type'] < 400) {
$verified_type = '微博达人';
} else {
$verified_type = '未认证';
}
} else {
$verified_type = '未认证';
}
if (isset($data ['followers_count'])) {
if ($data['followers_count'] >= 10000 && $data['followers_count'] <= 100000) {
$followers_count = (ceil(round(($data['followers_count'] / 10000), 2) * 10)) / 10 . "万";
} elseif ($data['followers_count'] > 100000) {
$followers_count = ceil(($data['followers_count'] / 10000)) . "万";
} else {
$followers_count = $data['followers_count'];
}
} else {
$followers_count = 0;
}
$returnResult[$k]['weibo_uid'] = isset($data ['weibo_uid']) ? $data ['weibo_uid'] : '';
$returnResult[$k]['weibo_name'] = isset($data ['weibo_name']) ? $data ['weibo_name'] : '';
$returnResult[$k]['weibo_avatar'] = isset($data ['weibo_avatar']) ? $data ['weibo_avatar'] : '';
$returnResult[$k]['followers_count'] = $followers_count;
$returnResult[$k]['verified_type'] = $verified_type;
$returnResult[$k]['major_tag'] = isset($data ['major_tag']) ? $data ['major_tag'] : '';
$returnResult[$k]['weiq_index'] = isset($data ['weiq']['weiq_index']) ? number_format($data ['weiq']['weiq_index']) : '0';
$returnResult[$k]['read_median'] = isset($data ['analysis']['read_median']) ? number_format($data ['analysis']['read_median']) : '0';
$returnResult[$k]['interact_median'] = isset($data ['analysis']['interaction_median']) ? number_format($data ['analysis']['interaction_median']) : '0';
$returnResult[$k]['cpm'] = isset($data ['weiq']['cpm']) ? $data ['weiq']['cpm'] : '0';
$returnResult[$k]['cpe'] = isset($data ['weiq']['cpe']) ? $data ['weiq']['cpe'] : '0';
$returnResult[$k]['weiq_post_price_adver'] = isset($data ['weiq']['postprice_adver']) ? number_format($data ['weiq']['postprice_adver'] / 100) : '0';
$returnResult[$k]['weiq_forward_price_adver'] = isset($data ['weiq']['forwardprice_adver']) ? number_format($data ['weiq']['forwardprice_adver'] / 100) : '0';
}
$return ['success'] = true;
$return ['rows'] = $returnResult;
$return ['total'] = $list_total;
} catch (\Exception $e) {
$return ['code'] = 500;
$return ['success'] = false;
$return ['msg'] = '系统异常，请稍后再试！'.$e->getMessage();
Log::record('function detailAccountList error:' . $e->getMessage(), Log::INFO);
}
Response::create($return, 'json', 200)->send();
}