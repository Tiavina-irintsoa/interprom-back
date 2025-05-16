<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Cross-Origin Resource Sharing (CORS) Configuration
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
 */
class Cors extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Allowed Origins
     * --------------------------------------------------------------------------
     *
     * The origins that are allowed to make requests to this API.
     *
     * @var array<string>
     */
    public array $allowedOrigins = ['*'];

    /**
     * --------------------------------------------------------------------------
     * Allowed Methods
     * --------------------------------------------------------------------------
     *
     * The HTTP methods that are allowed to be used.
     *
     * @var array<string>
     */
    public array $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];

    /**
     * --------------------------------------------------------------------------
     * Allowed Headers
     * --------------------------------------------------------------------------
     *
     * The headers that are allowed to be sent with the request.
     *
     * @var array<string>
     */
    public array $allowedHeaders = [
        'X-API-KEY',
        'Origin',
        'X-Requested-With',
        'Content-Type',
        'Accept',
        'Access-Control-Request-Method',
        'Authorization'
    ];

    /**
     * --------------------------------------------------------------------------
     * Exposed Headers
     * --------------------------------------------------------------------------
     *
     * The headers that are allowed to be exposed to the client.
     *
     * @var array<string>
     */
    public array $exposedHeaders = [];

    /**
     * --------------------------------------------------------------------------
     * Max Age
     * --------------------------------------------------------------------------
     *
     * The maximum time in seconds that the preflight request can be cached.
     *
     * @var int
     */
    public int $maxAge = 0;

    /**
     * --------------------------------------------------------------------------
     * Support Credentials
     * --------------------------------------------------------------------------
     *
     * Whether to allow credentials (cookies, authorization headers, etc.) to be
     * included in the request.
     *
     * @var bool
     */
    public bool $supportCredentials = false;
}
