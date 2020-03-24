<?php
namespace App\Helpers;

use Illuminate\Contracts\Pagination\Paginator;

function responseData($data = [], $message = '', $code = 200, $statusCode = 200)
{
    $res = [
        'code' => $code,
        'msg' => $message,
        'data' => $data
    ];

    //分页特殊处理
    if ($data instanceof Paginator) {
        $data = $data->toArray();
        $page = [
            'current_page' => $data['current_page'],
            'last_page' => $data['last_page'],
            'per_page' => $data['per_page'],
            'total' => $data['total']
        ];

        $res['data'] = $data['data'];
        $res['pages'] = $page;
    }
    return response()->json($res)->setStatusCode($statusCode);
}

function responseMessage($message= '',$code = 400,$statusCode = 200){
    $res = [
        'code' => $code,
        'msg' => $message,
        'data' => []
    ];

    return response()->json($res)->setStatusCode($statusCode);
}

// 递归获取子元素
function get_child($data, $pid)
{
    $tree = array(); //每次声明一个新数组用来放子元素
    foreach ($data as $key => $v) {
        //匹配子记录
        if ($v['parent_id'] === $pid) {
            if (get_child($data, $v['id'])){
                $v['children'] = get_child($data, $v['id']);  //递归获取子记录
            }
            $tree[] = $v;//将记录存入新数组
        }
    }
    return $tree; //返回新数组
}

