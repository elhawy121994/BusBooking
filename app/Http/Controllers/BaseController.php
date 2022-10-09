<?php

namespace App\Http\Controllers;

use finfo;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{
    public function ok($data)
    {
        return response()->json($data, Response::HTTP_OK);
    }

    public function accepted($data)
    {
        return response()->json($data, Response::HTTP_ACCEPTED);
    }

    public function created($data = ['status' => true])
    {
        return response()->json($data, Response::HTTP_CREATED);
    }

    public function successResponse($data, $statusCode = Response::HTTP_OK)
    {
        return response()->json($data, $statusCode);
    }

    public function errorResponse($errorCode, $message, $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $data = array(
            'code' => $errorCode,
            'message' => $message,

        );

        return response()->json($data, $statusCode);
    }
}
