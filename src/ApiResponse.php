<?php

namespace Pollitofive\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Traits\Macroable;
use Pollitofive\API\Contracts\ApiInterface;

class ApiResponse implements ApiInterface
{
    use Macroable;

    const HTTP_OK = 200;
    const HTTP_NOT_FOUND = 404;
    const HTTP_FORBIDDEN = 403;
    const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    /**
     * Create API response.
     *
     * @param int    $status
     * @param string | null $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function response(int $status = 200, string | null $message = null, array $data = [], ...$extraData) : JsonResponse
    {
        $json = [
            config('api.keys.status')  => config('api.stringify') ? strval($status) : $status,
            config('api.keys.message') => $message,
            config('api.keys.data')    => $data,
        ];

        if (is_countable($data) && config('api.include_data_count', false) && !empty($data)) {
            $json = array_merge($json, [config('api.keys.data_count') => config('api.stringify') ? strval(count($data)) : count($data)]);
        }

        if ($extraData) {
            foreach ($extraData as $extra) {
                $json = array_merge($json, $extra);
            }
        }

        return (config('api.match_status')) ? response()->json($json, $status) : response()->json($json);
    }

    /**
     * Create successful (200) API response.
     *
     * @param string | null $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function ok(string | null $message = null, array $data = [], array ...$extraData) : JsonResponse
    {
        if (is_null($message)) {
            $message = trans('api-response::messages.success');
        }

        return $this->response(static::HTTP_OK, $message, $data, ...$extraData);
    }

    /**
     * Create successful (200) API response.
     *
     * @param string | null $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function success(string | null $message = null, array $data = [], array ...$extraData) : JsonResponse
    {
        return $this->ok($message, $data, ...$extraData);
    }

    /**
     * Create Not found (404) API response.
     *
     * @param string | null $message
     *
     * @return JsonResponse
     */
    public function notFound(string | null $message = null) : JsonResponse
    {
        if (is_null($message)) {
            $message = trans('api-response::messages.notfound');
        }

        return $this->response(static::HTTP_NOT_FOUND, $message, []);
    }

    /**
     * Create Validation (422) API response.
     *
     * @param string | null $message
     * @param array  $errors
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function validation(string | null $message = null, array $errors = [], array ...$extraData) : JsonResponse
    {
        if (is_null($message)) {
            $message = trans('api-response::messages.validation');
        }

        return $this->response(static::HTTP_UNPROCESSABLE_ENTITY, $message, $errors, ...$extraData);
    }

    /**
     * Create Validation (422) API response.
     *
     * @param string | null $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function forbidden(string | null $message = null, array $data = [], array ...$extraData) : JsonResponse
    {
        if (is_null($message)) {
            $message = trans('api-response::messages.forbidden');
        }

        return $this->response(static::HTTP_FORBIDDEN, $message, $data, ...$extraData);
    }

    /**
     * Create Server error (500) API response.
     *
     * @param string | null $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function error(string | null $message = null, array $data = [], array ...$extraData) : JsonResponse
    {
        if (is_null($message)) {
            $message = trans('api-response::messages.error');
        }

        return $this->response(static::HTTP_INTERNAL_SERVER_ERROR, $message, $data, ...$extraData);
    }
}
