<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /***
     * @param int $code
     * @param string $message
     * @param null $data
     * @return JsonResponse
     */
    public function BuildResponse(int $code, string $message, $data = null): JsonResponse
    {
        $response = [
            'response' => [
                'code' => $code,
                'message' => $message,
            ],
            'data' => $data,
        ];
        return response()->json($response, $code);
    }

    /**
     * @return string[]
     */
    private function CustomValidateResponse(): array
    {
        return [
            'required'  => 'The :attribute field is required.',
            'unique'    => 'The :attribute is already used',
            'min'       => 'The :attribute minimum length :min character',
            'date_format' => 'Value :input is not support format Y-m-d',
            'email' => ':input is not format email'
        ];
    }

    /**
     * Validate request
     * @throws CustomValidationException
     */
    public function validate_request(Request $request, $rules): array
    {
        $validator = Validator::make($request->all(), $rules, $this->CustomValidateResponse());
        if ($validator->fails()){
            $this->throw_validation_exception($validator);
        }

        return $this->extractInputFromRules($request, $rules);
    }

    /**
     * Throw error validation
     * @throws CustomValidationException
     */
    protected function throw_validation_exception($validator)
    {
        throw new CustomValidationException(422, $this->build_failed_validation($validator));
    }

    /**
     * Build response for exception validation
     * @param $validator
     * @return false|string
     */
    protected function build_failed_validation($validator)
    {
        $response = [];
        foreach (json_decode($validator->errors()) as $key => $val) {
            array_push($response, [$key => $val[0]]);
        }
        return json_encode($response);
    }
}
