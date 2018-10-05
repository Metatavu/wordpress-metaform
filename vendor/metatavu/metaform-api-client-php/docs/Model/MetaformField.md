# MetaformField

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**visibleIf** | [**\Metatavu\Metaform\Api\Model\MetaformVisibleIf**](MetaformVisibleIf.md) |  | [optional] 
**name** | **string** | Field name | [optional] 
**type** | [**\Metatavu\Metaform\Api\Model\MetaformFieldType**](MetaformFieldType.md) |  | 
**title** | **string** |  | [optional] 
**required** | **bool** |  | [optional] 
**contexts** | **string[]** |  | [optional] 
**flags** | [**\Metatavu\Metaform\Api\Model\MetaformFieldFlags**](MetaformFieldFlags.md) |  | [optional] 
**placeholder** | **string** |  | [optional] 
**class** | **string** |  | [optional] 
**readonly** | **bool** |  | [optional] 
**help** | **string** |  | [optional] 
**default** | **string** | a default value for a field | [optional] 
**min** | **int** | Minimum value for a field. Only for number fields | [optional] 
**max** | **int** | Maximum value for a field. Only for number fields | [optional] 
**step** | **int** | Value step for a field. Only for number fields | [optional] 
**checked** | **bool** | Whether checkbox should be checked by default. Only for checkbox fields | [optional] 
**printable** | **bool** | Defines whether field is printable or not. Only for table fields | [optional] 
**options** | [**\Metatavu\Metaform\Api\Model\MetaformFieldOption[]**](MetaformFieldOption.md) | Options for radio, checklist, select fields | [optional] 
**sourceUrl** | **string** | Source url for autocomplete and autocomplete-multiple fields | [optional] 
**uploadUrl** | **string** | Upload url for files field. | [optional] 
**singleFile** | **bool** | Defines whether file fields allow multiple files or just one | [optional] 
**onlyImages** | **bool** | Defines whether file fields allow only images | [optional] 
**maxFileSize** | **int** | Maximum upload size for image filds | [optional] 
**addRows** | **bool** | Defines whether user can add more table rows. | [optional] 
**draggable** | **bool** | Defines whether table rows should be draggable. | [optional] 
**columns** | [**\Metatavu\Metaform\Api\Model\MetaformTableColumn[]**](MetaformTableColumn.md) | Columns for table fields | [optional] 
**src** | **string** | Url for logo field. | [optional] 
**text** | **string** | Text for small field. | [optional] 
**html** | **string** | Html code for html field. | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


