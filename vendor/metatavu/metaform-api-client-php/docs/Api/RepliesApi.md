# Metatavu\Metaform\RepliesApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createReply**](RepliesApi.md#createReply) | **POST** /realms/{realmId}/metaforms/{metaformId}/replies | create new form reply
[**export**](RepliesApi.md#export) | **GET** /realms/{realmId}/metaforms/{metaformId}/export | Exports metaform data
[**findReply**](RepliesApi.md#findReply) | **GET** /realms/{realmId}/metaforms/{metaformId}/replies/{replyId} | Find a single reply
[**findReplyMeta**](RepliesApi.md#findReplyMeta) | **GET** /realms/{realmId}/metaforms/{metaformId}/replies/{replyId}/meta | Returns reply meta
[**listReplies**](RepliesApi.md#listReplies) | **GET** /realms/{realmId}/metaforms/{metaformId}/replies | Lists form replies
[**updateReply**](RepliesApi.md#updateReply) | **PUT** /realms/{realmId}/metaforms/{metaformId}/replies/{replyId} | Updates reply


# **createReply**
> createReply($realmId, $metaformId, $payload, $updateExisting)

create new form reply

Creates new form reply

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\RepliesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id
$payload = new \Metatavu\Metaform\Api\Model\Reply(); // \Metatavu\Metaform\Api\Model\Reply | Payload
$updateExisting = true; // bool | specifies that existing reply should be updated

try {
    $api_instance->createReply($realmId, $metaformId, $payload, $updateExisting);
} catch (Exception $e) {
    echo 'Exception when calling RepliesApi->createReply: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |
 **payload** | [**\Metatavu\Metaform\Api\Model\Reply**](../Model/Reply.md)| Payload |
 **updateExisting** | **bool**| specifies that existing reply should be updated | [optional]

### Return type

void (empty response body)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **export**
> string export($realmId, $metaformId, $format)

Exports metaform data

Exports metaform data

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\RepliesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id
$format = "format_example"; // string | Export results in specified format (XLSX)

try {
    $result = $api_instance->export($realmId, $metaformId, $format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RepliesApi->export: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |
 **format** | **string**| Export results in specified format (XLSX) |

### Return type

**string**

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findReply**
> \Metatavu\Metaform\Api\Model\Reply findReply($realmId, $metaformId, $replyId)

Find a single reply

Finds single reply by id

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\RepliesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id
$replyId = "replyId_example"; // string | Reply id

try {
    $result = $api_instance->findReply($realmId, $metaformId, $replyId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RepliesApi->findReply: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |
 **replyId** | **string**| Reply id |

### Return type

[**\Metatavu\Metaform\Api\Model\Reply**](../Model/Reply.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findReplyMeta**
> \Metatavu\Metaform\Api\Model\ReplyMeta findReplyMeta($realmId, $metaformId, $replyId)

Returns reply meta

Returns meta data from the reply

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\RepliesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id
$replyId = "replyId_example"; // string | Reply id

try {
    $result = $api_instance->findReplyMeta($realmId, $metaformId, $replyId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RepliesApi->findReplyMeta: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |
 **replyId** | **string**| Reply id |

### Return type

[**\Metatavu\Metaform\Api\Model\ReplyMeta**](../Model/ReplyMeta.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listReplies**
> \Metatavu\Metaform\Api\Model\Reply[] listReplies($realmId, $metaformId, $userId)

Lists form replies

Lists form replies

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\RepliesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id
$userId = "userId_example"; // string | Filter results by user id. If this parameter is not specified all replies are returned, this requires logged user to have proper permission to do so

try {
    $result = $api_instance->listReplies($realmId, $metaformId, $userId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RepliesApi->listReplies: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |
 **userId** | **string**| Filter results by user id. If this parameter is not specified all replies are returned, this requires logged user to have proper permission to do so | [optional]

### Return type

[**\Metatavu\Metaform\Api\Model\Reply[]**](../Model/Reply.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateReply**
> updateReply($realmId, $metaformId, $replyId, $payload)

Updates reply

Updates reply

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\RepliesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id
$replyId = "replyId_example"; // string | Reply id
$payload = new \Metatavu\Metaform\Api\Model\Reply(); // \Metatavu\Metaform\Api\Model\Reply | Payload

try {
    $api_instance->updateReply($realmId, $metaformId, $replyId, $payload);
} catch (Exception $e) {
    echo 'Exception when calling RepliesApi->updateReply: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |
 **replyId** | **string**| Reply id |
 **payload** | [**\Metatavu\Metaform\Api\Model\Reply**](../Model/Reply.md)| Payload |

### Return type

void (empty response body)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

