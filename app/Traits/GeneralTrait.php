<?php

namespace App\Traits;

trait GeneralTrait
{

    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function returnError( $msg, $type= null, $code = 422)
    {
        if (is_array($msg)) {
            $msg = implode(', ', $msg);
        }

        return response()->json([
            'status' => false,
            'msg' => $msg,
            'type' => $type ?? ''
        ],$code);
    }

    public function unauthorized()
    {
        return response()->json([
            'status' => false,
            'msg' => trans('auth.unauthorized')
        ], 401);
    }

    public function returnSuccessMessage ( $msg = "", $code = 200 )
    {
        return [
            'status' => $code >= 200 && $code < 300,
            'code' => $code,
            'msg' => $msg
        ];
    }

    public function returnData ( $data, $msg =null ,$code = 200 )
    {
        $response = [
            'status' => $code >= 200 && $code < 300,
            'code' => $code,
            'data' => $data,
            'msg' => $msg ??  trans('api.The_action_ran_successfully'),
        ];

        return response()->json($response, $code);

    }


    public function returnValidationError($code = "E001", $validator , $type = null)
    {
        $messages = [];

        foreach ($validator as $index=>$fieldErrors) {
            if (is_array($fieldErrors)) {
                $messages =   array_merge($messages, $fieldErrors);
            }else{
                $messages[$index] = $fieldErrors;
            }

        }

        return $this->returnError($messages, $type);
    }

    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }


}
