<?php  

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ApiResponse {

    /**
     * JSON response for APIs
     *
     * @param bool $status
     * @param string|array $message
     * @param array $data
     * @param int $code
     * @return Response
    */
    public static function returnJSON($data = [], $status = true,
        $code = JsonResponse::HTTP_OK, $message = 'data get successfully')
    { 
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Return response for success opertation
     *
     * @return Response
    */
    public static function returnSuccess($message = 'Your request done successfully',
                   $code = JsonResponse::HTTP_OK)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
        ], $code);
    }

    /**
     * Return response for success opertation
     *
     * @return Response
    */
    public static function returnWrong($message = 'Your Request Is Invalid' ,  
                $code = JsonResponse::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'status'  => false ,
            'message' => $message ,
        ], $code );
    } 

}