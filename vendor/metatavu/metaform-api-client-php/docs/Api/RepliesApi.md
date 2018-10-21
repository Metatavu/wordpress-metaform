# Metatavu\Metaform\RepliesApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createReply**](RepliesApi.md#createReply) | **POST** /realms/{realmId}/metaforms/{metaformId}/replies | create new form reply
[**deleteReply**](RepliesApi.md#deleteReply) | **DELETE** /realms/{realmId}/metaforms/{metaformId}/replies/{replyId} | Deletes a reply
[**export**](RepliesApi.md#export) | **GET** /realms/{realmId}/metaforms/{metaformId}/export | Exports metaform data
[**findReply**](RepliesApi.md#findReply) | **GET** /realms/{realmId}/metaforms/{metaformId}/replies/{replyId} | Find a single reply
[**listReplies**](RepliesApi.md#listReplies) | **GET** /realms/{realmId}/metaforms/{metaformId}/replies | Lists form replies
[**replyExport**](RepliesApi.md#replyExport) | **GET** /realms/{realmId}/metaforms/{metaformId}/replies/{replyId}/export | Exports reply data
[**updateReply**](RepliesApi.md#updateReply) | **PUT** /realms/{realmId}/metaforms/{metaformId}/replies/{replyId} | Updates reply


# **createReply**
> \Metatavu\Metaform\Api\Model\Reply createReply($realmId, $metaformId, $payload, $updateExisting, $replyMode)

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
$updateExisting = true; // bool | specifies that existing reply should be updated. DEPRECATED, use replymode instead
$replyMode = "replyMode_example"; // string | specifies reply mode that will be used. possible values UPDATE, REVISION, CUMULATIVE

try {
    $result = $api_instance->createReply($realmId, $metaformId, $payload, $updateExisting, $replyMode);
    print_r($result);
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
 **updateExisting** | **bool**| specifies that existing reply should be updated. DEPRECATED, use replymode instead | [optional]
 **replyMode** | **string**| specifies reply mode that will be used. possible values UPDATE, REVISION, CUMULATIVE | [optional]

### Return type

[**\Metatavu\Metaform\Api\Model\Reply**](../Model/Reply.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteReply**
> deleteReply($realmId, $metaformId, $replyId)

Deletes a reply

Deletes a reply

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
    $api_instance->deleteReply($realmId, $metaformId, $replyId);
} catch (Exception $e) {
    echo 'Exception when calling RepliesApi->deleteReply: ', $e->getMessage(), PHP_EOL;
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

# **listReplies**
> \Metatavu\Metaform\Api\Model\Reply[] listReplies($realmId, $metaformId, $userId, $createdBefore, $createdAfter, $modifiedBefore, $modifiedAfter, $includeRevisions, $fields)

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
$createdBefore = "createdBefore_example"; // string | Filter results created before specified time
$createdAfter = "createdAfter_example"; // string | Filter results created after specified time
$modifiedBefore = "modifiedBefore_example"; // string | Filter results modified before specified time
$modifiedAfter = "modifiedAfter_example"; // string | Filter results modified after specified time
$includeRevisions = true; // bool | Specifies that revisions should be included into response
$fields = array("fields_example"); // string[] | Filter results by field values. Format is field:value, multiple values can be added by using comma separator. E.g. field1=value,field2=another

try {
    $result = $api_instance->listReplies($realmId, $metaformId, $userId, $createdBefore, $createdAfter, $modifiedBefore, $modifiedAfter, $includeRevisions, $fields);
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
 **createdBefore** | **string**| Filter results created before specified time | [optional]
 **createdAfter** | **string**| Filter results created after specified time | [optional]
 **modifiedBefore** | **string**| Filter results modified before specified time | [optional]
 **modifiedAfter** | **string**| Filter results modified after specified time | [optional]
 **includeRevisions** | **bool**| Specifies that revisions should be included into response | [optional]
 **fields** | [**string[]**](../Model/string.md)| Filter results by field values. Format is field:value, multiple values can be added by using comma separator. E.g. field1&#x3D;value,field2&#x3D;another | [optional]

### Return type

[**\Metatavu\Metaform\Api\Model\Reply[]**](../Model/Reply.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **replyExport**
> string replyExport($realmId, $metaformId, $replyId, $format)

Exports reply data

Exports reply data

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
$format = "format_example"; // string | Export results in specified format (PDF)

try {
    $result = $api_instance->replyExport($realmId, $metaformId, $replyId, $format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RepliesApi->replyExport: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |
 **replyId** | **string**| Reply id |
 **format** | **string**| Export results in specified format (PDF) |

### Return type

**string**

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

