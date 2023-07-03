<?php

namespace Pollitofive\API\Contracts;

use Illuminate\Http\JsonResponse;

interface ApiInterface
{
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
    public function response(int $status = 200, string | null $message = null, array $data = [], array ...$extraData) : JsonResponse;

    /**
     * Create successful (200) API response.
     *
     * @param string | null $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function ok(string | null $message = null, array $data = [], array ...$extraData) : JsonResponse;


    /**
     * Create successful (200) API response.
     *
     * @param string | null $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function success(string | null $message = null, array $data = [], array ...$extraData) : JsonResponse;
    /**
     * Create Not found (404) API response.
     *
     * @param string | null $message
     *
     * @return JsonResponse
     */
    public function notFound(string | null $message = null) : JsonResponse;

    /**
     * Create Validation (422) API response.
     *
     * @param string | null $message
     * @param array  $errors
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function validation(string | null $message = null, array $errors = [], array...$extraData) : JsonResponse;

    /**
     * Create Validation (422) API response.
     *
     * @param string | null $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function forbidden(string | null $message = null, array $data = [], array ...$extraData) : JsonResponse;

    /**
     * Create Server error (500) API response.
     *
     * @param string | null $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function error(string | null $message = null, array $data = [], array ...$extraData) : JsonResponse;
}
