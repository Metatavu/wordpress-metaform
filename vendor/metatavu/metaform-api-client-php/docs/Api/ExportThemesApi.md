# Metatavu\Metaform\ExportThemesApi

All URIs are relative to *https://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createExportTheme**](ExportThemesApi.md#createExportTheme) | **POST** /realms/{realmId}/exportThemes | create new form export theme
[**createExportThemeFile**](ExportThemesApi.md#createExportThemeFile) | **POST** /realms/{realmId}/exportThemes/{exportThemeId}/files | create new export theme file
[**deleteExportTheme**](ExportThemesApi.md#deleteExportTheme) | **DELETE** /realms/{realmId}/exportThemes/{exportThemeId} | Deletes an export theme
[**deleteExportThemeFile**](ExportThemesApi.md#deleteExportThemeFile) | **DELETE** /realms/{realmId}/exportThemes/{exportThemeId}/files/{exportThemeFileId} | Deletes an export theme file
[**findExportTheme**](ExportThemesApi.md#findExportTheme) | **GET** /realms/{realmId}/exportThemes/{exportThemeId} | Finds single export theme
[**findExportThemeFile**](ExportThemesApi.md#findExportThemeFile) | **GET** /realms/{realmId}/exportThemes/{exportThemeId}/files/{exportThemeFileId} | Finds single export theme file
[**listExportThemeFiles**](ExportThemesApi.md#listExportThemeFiles) | **GET** /realms/{realmId}/exportThemes/{exportThemeId}/files | Lists files of export theme
[**listExportThemes**](ExportThemesApi.md#listExportThemes) | **GET** /realms/{realmId}/exportThemes | Lists form export themes
[**updateExportTheme**](ExportThemesApi.md#updateExportTheme) | **PUT** /realms/{realmId}/exportThemes/{exportThemeId} | Updates export theme
[**updateExportThemeFile**](ExportThemesApi.md#updateExportThemeFile) | **PUT** /realms/{realmId}/exportThemes/{exportThemeId}/files/{exportThemeFileId} | Updates export theme file


# **createExportTheme**
> \Metatavu\Metaform\Api\Model\ExportTheme createExportTheme($realmId, $payload)

create new form export theme

Creates new form export theme

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\ExportThemesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$payload = new \Metatavu\Metaform\Api\Model\ExportTheme(); // \Metatavu\Metaform\Api\Model\ExportTheme | Payload

try {
    $result = $api_instance->createExportTheme($realmId, $payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExportThemesApi->createExportTheme: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **payload** | [**\Metatavu\Metaform\Api\Model\ExportTheme**](../Model/ExportTheme.md)| Payload |

### Return type

[**\Metatavu\Metaform\Api\Model\ExportTheme**](../Model/ExportTheme.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **createExportThemeFile**
> \Metatavu\Metaform\Api\Model\ExportThemeFile createExportThemeFile($realmId, $exportThemeId, $payload)

create new export theme file

Creates new export theme file

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\ExportThemesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$exportThemeId = "exportThemeId_example"; // string | export theme id
$payload = new \Metatavu\Metaform\Api\Model\ExportThemeFile(); // \Metatavu\Metaform\Api\Model\ExportThemeFile | Payload

try {
    $result = $api_instance->createExportThemeFile($realmId, $exportThemeId, $payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExportThemesApi->createExportThemeFile: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **exportThemeId** | **string**| export theme id |
 **payload** | [**\Metatavu\Metaform\Api\Model\ExportThemeFile**](../Model/ExportThemeFile.md)| Payload |

### Return type

[**\Metatavu\Metaform\Api\Model\ExportThemeFile**](../Model/ExportThemeFile.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteExportTheme**
> deleteExportTheme($realmId, $exportThemeId)

Deletes an export theme

Deletes an export theme

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\ExportThemesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$exportThemeId = "exportThemeId_example"; // string | export theme id

try {
    $api_instance->deleteExportTheme($realmId, $exportThemeId);
} catch (Exception $e) {
    echo 'Exception when calling ExportThemesApi->deleteExportTheme: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **exportThemeId** | **string**| export theme id |

### Return type

void (empty response body)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteExportThemeFile**
> deleteExportThemeFile($realmId, $exportThemeId, $exportThemeFileId)

Deletes an export theme file

Deletes an export theme file

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\ExportThemesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$exportThemeId = "exportThemeId_example"; // string | export theme id
$exportThemeFileId = "exportThemeFileId_example"; // string | export theme file id

try {
    $api_instance->deleteExportThemeFile($realmId, $exportThemeId, $exportThemeFileId);
} catch (Exception $e) {
    echo 'Exception when calling ExportThemesApi->deleteExportThemeFile: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **exportThemeId** | **string**| export theme id |
 **exportThemeFileId** | **string**| export theme file id |

### Return type

void (empty response body)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findExportTheme**
> \Metatavu\Metaform\Api\Model\ExportTheme findExportTheme($realmId, $exportThemeId)

Finds single export theme

Finds single export theme

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\ExportThemesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$exportThemeId = "exportThemeId_example"; // string | export theme id

try {
    $result = $api_instance->findExportTheme($realmId, $exportThemeId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExportThemesApi->findExportTheme: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **exportThemeId** | **string**| export theme id |

### Return type

[**\Metatavu\Metaform\Api\Model\ExportTheme**](../Model/ExportTheme.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findExportThemeFile**
> \Metatavu\Metaform\Api\Model\ExportThemeFile findExportThemeFile($realmId, $exportThemeId, $exportThemeFileId)

Finds single export theme file

Finds single export theme file

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\ExportThemesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$exportThemeId = "exportThemeId_example"; // string | export theme id
$exportThemeFileId = "exportThemeFileId_example"; // string | export theme file id

try {
    $result = $api_instance->findExportThemeFile($realmId, $exportThemeId, $exportThemeFileId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExportThemesApi->findExportThemeFile: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **exportThemeId** | **string**| export theme id |
 **exportThemeFileId** | **string**| export theme file id |

### Return type

[**\Metatavu\Metaform\Api\Model\ExportThemeFile**](../Model/ExportThemeFile.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listExportThemeFiles**
> \Metatavu\Metaform\Api\Model\ExportThemeFile[] listExportThemeFiles($realmId, $exportThemeId)

Lists files of export theme

Lists files of export theme

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\ExportThemesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$exportThemeId = "exportThemeId_example"; // string | export theme id

try {
    $result = $api_instance->listExportThemeFiles($realmId, $exportThemeId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExportThemesApi->listExportThemeFiles: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **exportThemeId** | **string**| export theme id |

### Return type

[**\Metatavu\Metaform\Api\Model\ExportThemeFile[]**](../Model/ExportThemeFile.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listExportThemes**
> \Metatavu\Metaform\Api\Model\ExportTheme[] listExportThemes($realmId)

Lists form export themes

Lists export themes

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\ExportThemesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id

try {
    $result = $api_instance->listExportThemes($realmId);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExportThemesApi->listExportThemes: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |

### Return type

[**\Metatavu\Metaform\Api\Model\ExportTheme[]**](../Model/ExportTheme.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateExportTheme**
> \Metatavu\Metaform\Api\Model\ExportTheme updateExportTheme($realmId, $exportThemeId, $payload)

Updates export theme

Updates export theme

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\ExportThemesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$exportThemeId = "exportThemeId_example"; // string | ExportTheme id
$payload = new \Metatavu\Metaform\Api\Model\ExportTheme(); // \Metatavu\Metaform\Api\Model\ExportTheme | Payload

try {
    $result = $api_instance->updateExportTheme($realmId, $exportThemeId, $payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExportThemesApi->updateExportTheme: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **exportThemeId** | **string**| ExportTheme id |
 **payload** | [**\Metatavu\Metaform\Api\Model\ExportTheme**](../Model/ExportTheme.md)| Payload |

### Return type

[**\Metatavu\Metaform\Api\Model\ExportTheme**](../Model/ExportTheme.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateExportThemeFile**
> \Metatavu\Metaform\Api\Model\ExportThemeFile updateExportThemeFile($realmId, $exportThemeId, $exportThemeFileId, $payload)

Updates export theme file

Updates export theme file

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: bearer
Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Metatavu\Metaform\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$api_instance = new Metatavu\Metaform\Api\ExportThemesApi(new \Http\Adapter\Guzzle6\Client());
$realmId = "realmId_example"; // string | realm id
$exportThemeId = "exportThemeId_example"; // string | ExportTheme id
$exportThemeFileId = "exportThemeFileId_example"; // string | ExportThemeFile file id
$payload = new \Metatavu\Metaform\Api\Model\ExportThemeFile(); // \Metatavu\Metaform\Api\Model\ExportThemeFile | Payload

try {
    $result = $api_instance->updateExportThemeFile($realmId, $exportThemeId, $exportThemeFileId, $payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExportThemesApi->updateExportThemeFile: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **realmId** | **string**| realm id |
 **exportThemeId** | **string**| ExportTheme id |
 **exportThemeFileId** | **string**| ExportThemeFile file id |
 **payload** | [**\Metatavu\Metaform\Api\Model\ExportThemeFile**](../Model/ExportThemeFile.md)| Payload |

### Return type

[**\Metatavu\Metaform\Api\Model\ExportThemeFile**](../Model/ExportThemeFile.md)

### Authorization

[bearer](../../README.md#bearer)

### HTTP request headers

 - **Content-Type**: application/json;charset=utf-8
 - **Accept**: application/json;charset=utf-8

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

