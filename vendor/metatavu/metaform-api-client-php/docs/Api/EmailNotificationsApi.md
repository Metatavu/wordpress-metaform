# Metatavu\Metaform\EmailNotificationsApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createEmailNotification**](EmailNotificationsApi.md#createEmailNotification) | **POST** /realms/{realmId}/metaforms/{metaformId}/emailNotifications | create new form email notification
[**deleteEmailNotification**](EmailNotificationsApi.md#deleteEmailNotification) | **DELETE** /realms/{realmId}/metaforms/{metaformId}/emailNotifications/{emailNotificationId} | Deletes an email notification
[**findEmailNotification**](EmailNotificationsApi.md#findEmailNotification) | **GET** /realms/{realmId}/metaforms/{metaformId}/emailNotifications/{emailNotificationId} | Find a single emai notification
[**listEmailNotifications**](EmailNotificationsApi.md#listEmailNotifications) | **GET** /realms/{realmId}/metaforms/{metaformId}/emailNotifications | Lists form email notifications
[**updateEmailNotification**](EmailNotificationsApi.md#updateEmailNotification) | **PUT** /realms/{realmId}/metaforms/{metaformId}/emailNotifications/{emailNotificationId} | Updates email notification


# **createEmailNotification**
> \Metatavu\Metaform\Api\Model\EmailNotification createEmailNotification($realmId, $metaformId, $payload)

create new form email notification

Creates new form email notification

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\EmailNotificationsApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id
$payload = new \Metatavu\Metaform\Api\Model\EmailNotification(); // \Metatavu\Metaform\Api\Model\EmailNotification | Payload

try {
    $result = $api_instance->createEmailNotification($realmId, $metaformId, $payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmailNotificationsApi->createEmailNotification: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |
 **payload** | [**\Metatavu\Metaform\Api\Model\EmailNotification**](../Model/EmailNotification.md)| Payload |

### Return type

[**\Metatavu\Metaform\Api\Model\EmailNotification**](../Model/EmailNotification.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteEmailNotification**
> deleteEmailNotification($realmId, $metaformId, $emailNotificationId)

Deletes an email notification

Deletes an email notification

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\EmailNotificationsApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id
$emailNotificationId = "emailNotificationId_example"; // string | Email notification id

try {
    $api_instance->deleteEmailNotification($realmId, $metaformId, $emailNotificationId);
} catch (Exception $e) {
    echo 'Exception when calling EmailNotificationsApi->deleteEmailNotification: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |
 **emailNotificationId** | **string**| Email notification id |

### Return type

void (empty response body)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findEmailNotification**
> \Metatavu\Metaform\Api\Model\EmailNotification findEmailNotification($realmId, $metaformId, $emailNotificationId)

Find a single emai notification

Finds single email notification by id

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\EmailNotificationsApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id
$emailNotificationId = "emailNotificationId_example"; // string | EmailNotification id

try {
    $result = $api_instance->findEmailNotification($realmId, $metaformId, $emailNotificationId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmailNotificationsApi->findEmailNotification: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |
 **emailNotificationId** | **string**| EmailNotification id |

### Return type

[**\Metatavu\Metaform\Api\Model\EmailNotification**](../Model/EmailNotification.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listEmailNotifications**
> \Metatavu\Metaform\Api\Model\EmailNotification[] listEmailNotifications($realmId, $metaformId)

Lists form email notifications

Lists email notifications

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\EmailNotificationsApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id

try {
    $result = $api_instance->listEmailNotifications($realmId, $metaformId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmailNotificationsApi->listEmailNotifications: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |

### Return type

[**\Metatavu\Metaform\Api\Model\EmailNotification[]**](../Model/EmailNotification.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateEmailNotification**
> \Metatavu\Metaform\Api\Model\EmailNotification updateEmailNotification($realmId, $metaformId, $emailNotificationId, $payload)

Updates email notification

Updates email notification

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\EmailNotificationsApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$metaformId = "metaformId_example"; // string | Metaform id
$emailNotificationId = "emailNotificationId_example"; // string | EmailNotification id
$payload = new \Metatavu\Metaform\Api\Model\EmailNotification(); // \Metatavu\Metaform\Api\Model\EmailNotification | Payload

try {
    $result = $api_instance->updateEmailNotification($realmId, $metaformId, $emailNotificationId, $payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmailNotificationsApi->updateEmailNotification: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **metaformId** | **string**| Metaform id |
 **emailNotificationId** | **string**| EmailNotification id |
 **payload** | [**\Metatavu\Metaform\Api\Model\EmailNotification**](../Model/EmailNotification.md)| Payload |

### Return type

[**\Metatavu\Metaform\Api\Model\EmailNotification**](../Model/EmailNotification.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

