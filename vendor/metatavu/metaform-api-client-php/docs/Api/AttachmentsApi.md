# Metatavu\Metaform\AttachmentsApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**findAttachment**](AttachmentsApi.md#findAttachment) | **GET** /realms/{realmId}/attachments/{attachmentId} | Find a attachment by id
[**findAttachmentData**](AttachmentsApi.md#findAttachmentData) | **GET** /realms/{realmId}/attachments/{attachmentId}/data | Find a attachment data by id


# **findAttachment**
> \Metatavu\Metaform\Api\Model\Attachment findAttachment($realmId, $attachmentId)

Find a attachment by id

Returns single attachment

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\AttachmentsApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$attachmentId = "attachmentId_example"; // string | Attachment id

try {
    $result = $api_instance->findAttachment($realmId, $attachmentId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AttachmentsApi->findAttachment: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **attachmentId** | **string**| Attachment id |

### Return type

[**\Metatavu\Metaform\Api\Model\Attachment**](../Model/Attachment.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findAttachmentData**
> string findAttachmentData($realmId, $attachmentId)

Find a attachment data by id

Returns attachment data

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\AttachmentsApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$attachmentId = "attachmentId_example"; // string | Attachment id

try {
    $result = $api_instance->findAttachmentData($realmId, $attachmentId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AttachmentsApi->findAttachmentData: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **attachmentId** | **string**| Attachment id |

### Return type

**string**

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

