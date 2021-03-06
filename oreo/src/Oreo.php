<?php
namespace Hqbox\Oreo;

class Oreo
{
    /**
     * 统一返回值格式
     */
    public function formResponseData($data = array(), $message='success', $code=200)
    {
        return array(
            'code'    => $code,
            'message' => $message,
            'data'    => $data
        );
    }
}
