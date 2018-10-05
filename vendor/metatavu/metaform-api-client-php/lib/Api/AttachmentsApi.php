<?php
/**
 * AttachmentsApi
 * PHP version 5
 *
 * @category Class
 * @package  Metatavu\Metaform
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Metaform REST API
 *
 * REST API for Metaform
 *
 * OpenAPI spec version: 0.0.1
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Metatavu\Metaform\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use Metatavu\Metaform\ApiException;
use Metatavu\Metaform\Configuration;
use Metatavu\Metaform\HeaderSelector;
use Metatavu\Metaform\ObjectSerializer;

/**
 * AttachmentsApi Class Doc Comment
 *
 * @category Class
 * @package  Metatavu\Metaform
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class AttachmentsApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation findAttachment
     *
     * Find a attachment by id
     *
     * @param  string $realmId realm id (required)
     * @param  string $attachmentId Attachment id (required)
     *
     * @throws \Metatavu\Metaform\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Metatavu\Metaform\Api\Model\Attachment
     */
    public function findAttachment($realmId, $attachmentId)
    {
        list($response) = $this->findAttachmentWithHttpInfo($realmId, $attachmentId);
        return $response;
    }

    /**
     * Operation findAttachmentWithHttpInfo
     *
     * Find a attachment by id
     *
     * @param  string $realmId realm id (required)
     * @param  string $attachmentId Attachment id (required)
     *
     * @throws \Metatavu\Metaform\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Metatavu\Metaform\Api\Model\Attachment, HTTP status code, HTTP response headers (array of strings)
     */
    public function findAttachmentWithHttpInfo($realmId, $attachmentId)
    {
        $returnType = '\Metatavu\Metaform\Api\Model\Attachment';
        $request = $this->findAttachmentRequest($realmId, $attachmentId);

        try {

            try {
                $response = $this->client->send($request);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Metaform\Api\Model\Attachment',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Metaform\Api\Model\BadRequest',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Metaform\Api\Model\Forbidden',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Metaform\Api\Model\InternalServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation findAttachmentAsync
     *
     * Find a attachment by id
     *
     * @param  string $realmId realm id (required)
     * @param  string $attachmentId Attachment id (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function findAttachmentAsync($realmId, $attachmentId)
    {
        return $this->findAttachmentAsyncWithHttpInfo($realmId, $attachmentId)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation findAttachmentAsyncWithHttpInfo
     *
     * Find a attachment by id
     *
     * @param  string $realmId realm id (required)
     * @param  string $attachmentId Attachment id (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function findAttachmentAsyncWithHttpInfo($realmId, $attachmentId)
    {
        $returnType = '\Metatavu\Metaform\Api\Model\Attachment';
        $request = $this->findAttachmentRequest($realmId, $attachmentId);

        return $this->client
            ->sendAsync($request)
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'findAttachment'
     *
     * @param  string $realmId realm id (required)
     * @param  string $attachmentId Attachment id (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function findAttachmentRequest($realmId, $attachmentId)
    {
        // verify the required parameter 'realmId' is set
        if ($realmId === null) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $realmId when calling findAttachment'
            );
        }
        // verify the required parameter 'attachmentId' is set
        if ($attachmentId === null) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $attachmentId when calling findAttachment'
            );
        }

        $resourcePath = '/realms/{realmId}/attachments/{attachmentId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // path params
        if ($realmId !== null) {
            $resourcePath = str_replace(
                '{' . 'realmId' . '}',
                ObjectSerializer::toPathValue($realmId),
                $resourcePath
            );
        }
        // path params
        if ($attachmentId !== null) {
            $resourcePath = str_replace(
                '{' . 'attachmentId' . '}',
                ObjectSerializer::toPathValue($attachmentId),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers= $this->headerSelector->selectHeadersForMultipart(
                ['application/json;charset=utf-8']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json;charset=utf-8'],
                ['application/json;charset=utf-8']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present

        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKeyWithPrefix('Authorization');
        if ($apiKey !== null) {
            $headers['Authorization'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);
        return new Request(
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation findAttachmentData
     *
     * Find a attachment data by id
     *
     * @param  string $realmId realm id (required)
     * @param  string $attachmentId Attachment id (required)
     *
     * @throws \Metatavu\Metaform\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return string
     */
    public function findAttachmentData($realmId, $attachmentId)
    {
        list($response) = $this->findAttachmentDataWithHttpInfo($realmId, $attachmentId);
        return $response;
    }

    /**
     * Operation findAttachmentDataWithHttpInfo
     *
     * Find a attachment data by id
     *
     * @param  string $realmId realm id (required)
     * @param  string $attachmentId Attachment id (required)
     *
     * @throws \Metatavu\Metaform\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of string, HTTP status code, HTTP response headers (array of strings)
     */
    public function findAttachmentDataWithHttpInfo($realmId, $attachmentId)
    {
        $returnType = 'string';
        $request = $this->findAttachmentDataRequest($realmId, $attachmentId);

        try {

            try {
                $response = $this->client->send($request);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        'string',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Metaform\Api\Model\BadRequest',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Metaform\Api\Model\Forbidden',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Metatavu\Metaform\Api\Model\InternalServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation findAttachmentDataAsync
     *
     * Find a attachment data by id
     *
     * @param  string $realmId realm id (required)
     * @param  string $attachmentId Attachment id (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function findAttachmentDataAsync($realmId, $attachmentId)
    {
        return $this->findAttachmentDataAsyncWithHttpInfo($realmId, $attachmentId)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation findAttachmentDataAsyncWithHttpInfo
     *
     * Find a attachment data by id
     *
     * @param  string $realmId realm id (required)
     * @param  string $attachmentId Attachment id (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function findAttachmentDataAsyncWithHttpInfo($realmId, $attachmentId)
    {
        $returnType = 'string';
        $request = $this->findAttachmentDataRequest($realmId, $attachmentId);

        return $this->client
            ->sendAsync($request)
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'findAttachmentData'
     *
     * @param  string $realmId realm id (required)
     * @param  string $attachmentId Attachment id (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function findAttachmentDataRequest($realmId, $attachmentId)
    {
        // verify the required parameter 'realmId' is set
        if ($realmId === null) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $realmId when calling findAttachmentData'
            );
        }
        // verify the required parameter 'attachmentId' is set
        if ($attachmentId === null) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $attachmentId when calling findAttachmentData'
            );
        }

        $resourcePath = '/realms/{realmId}/attachments/{attachmentId}/data';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // path params
        if ($realmId !== null) {
            $resourcePath = str_replace(
                '{' . 'realmId' . '}',
                ObjectSerializer::toPathValue($realmId),
                $resourcePath
            );
        }
        // path params
        if ($attachmentId !== null) {
            $resourcePath = str_replace(
                '{' . 'attachmentId' . '}',
                ObjectSerializer::toPathValue($attachmentId),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers= $this->headerSelector->selectHeadersForMultipart(
                ['application/json;charset=utf-8']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json;charset=utf-8'],
                ['application/json;charset=utf-8']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present

        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKeyWithPrefix('Authorization');
        if ($apiKey !== null) {
            $headers['Authorization'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);
        return new Request(
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

}
