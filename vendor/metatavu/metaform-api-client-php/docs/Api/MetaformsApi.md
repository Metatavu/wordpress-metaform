# Metatavu\Metaform\MetaformsApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createMetaform**](MetaformsApi.md#createMetaform) | **POST** /realms/{realmId}/metaforms | create new Metaform
[**findMetaform**](MetaformsApi.md#findMetaform) | **GET** /realms/{realmId}/metaforms/{metaformId} | Finds single Metaform
[**listMetaforms**](MetaformsApi.md#listMetaforms) | **GET** /realms/{realmId}/metaforms | Lists Metaforms
[**updateMetaform**](MetaformsApi.md#updateMetaform) | **PUT** /realms/{realmId}/metaforms/{metaformId} | Updates Metaform


# **createMetaform**
> \Metatavu\Metaform\Api\Model\Metaform createMetaform($realmId, $payload)

create new Metaform

Creates new Metaform

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\MetaformsApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$payload = new \Metatavu\Metaform\Api\Model\Metaform(); // \Metatavu\Metaform\Api\Model\Metaform | Payload

try {
    $result = $api_instance->createMetaform($realmId, $payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MetaformsApi->createMetaform: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **payload** | [**\Metatavu\Metaform\Api\Model\Metaform**](../Model/Metaform.md)| Payload |

### Return type

[**\Metatavu\Metaform\Api\Model\Metaform**](../Model/Metaform.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findMetaform**
> \Metatavu\Metaform\Api\Model\Metaform findMetaform($realmId, $metaformId)

Finds single Metaform

Finds a single Metaform

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\MetaformsApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id

try {
    $result = $api_instance->findMetaform($realmId, $metaformId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MetaformsApi->findMetaform: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |

### Return type

[**\Metatavu\Metaform\Api\Model\Metaform**](../Model/Metaform.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listMetaforms**
> \Metatavu\Metaform\Api\Model\Metaform[] listMetaforms($realmId)

Lists Metaforms

Lists Metaforms from the realm. User receives only metaforms where he/she has permission to.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\MetaformsApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id

try {
    $result = $api_instance->listMetaforms($realmId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MetaformsApi->listMetaforms: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |

### Return type

[**\Metatavu\Metaform\Api\Model\Metaform[]**](../Model/Metaform.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateMetaform**
> \Metatavu\Metaform\Api\Model\Metaform updateMetaform($realmId, $metaformId, $payload)

Updates Metaform

Updates a Metaform

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\MetaformsApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id
$payload = new \Metatavu\Metaform\Api\Model\Metaform(); // \Metatavu\Metaform\Api\Model\Metaform | Payload

try {
    $result = $api_instance->updateMetaform($realmId, $metaformId, $payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MetaformsApi->updateMetaform: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |
 **payload** | [**\Metatavu\Metaform\Api\Model\Metaform**](../Model/Metaform.md)| Payload |

### Return type

[**\Metatavu\Metaform\Api\Model\Metaform**](../Model/Metaform.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

