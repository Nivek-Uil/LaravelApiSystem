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

//function responseError($errors,$code = 400, $statusCode= 422){
//    $res = [
////		'code' => $code,
//        'message' => 'The given data was invalid.',
//        'errors' => $errors,
////		'data' => []
//    ];
//
//    return response()->json($res)->setStatusCode($statusCode);
//}
