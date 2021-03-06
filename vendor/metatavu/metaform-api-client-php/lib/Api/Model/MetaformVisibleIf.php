<?php
/**
 * MetaformVisibleIf
 *
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

namespace Metatavu\Metaform\Api\Model;

use \ArrayAccess;
use \Metatavu\Metaform\ObjectSerializer;

/**
 * MetaformVisibleIf Class Doc Comment
 *
 * @category Class
 * @description Rule that defines whether specified object is visible
 * @package  Metatavu\Metaform
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class MetaformVisibleIf implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'MetaformVisibleIf';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'field' => 'string',
        'equals' => 'string',
        'notEquals' => 'string',
        'and' => '\Metatavu\Metaform\Api\Model\MetaformVisibleIf[]',
        'or' => '\Metatavu\Metaform\Api\Model\MetaformVisibleIf[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'field' => null,
        'equals' => null,
        'notEquals' => null,
        'and' => null,
        'or' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'field' => 'field',
        'equals' => 'equals',
        'notEquals' => 'not-equals',
        'and' => 'and',
        'or' => 'or'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'field' => 'setField',
        'equals' => 'setEquals',
        'notEquals' => 'setNotEquals',
        'and' => 'setAnd',
        'or' => 'setOr'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'field' => 'getField',
        'equals' => 'getEquals',
        'notEquals' => 'getNotEquals',
        'and' => 'getAnd',
        'or' => 'getOr'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['field'] = isset($data['field']) ? $data['field'] : null;
        $this->container['equals'] = isset($data['equals']) ? $data['equals'] : null;
        $this->container['notEquals'] = isset($data['notEquals']) ? $data['notEquals'] : null;
        $this->container['and'] = isset($data['and']) ? $data['and'] : null;
        $this->container['or'] = isset($data['or']) ? $data['or'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        return true;
    }


    /**
     * Gets field
     *
     * @return string
     */
    public function getField()
    {
        return $this->container['field'];
    }

    /**
     * Sets field
     *
     * @param string $field Field where the visible if rule is relative to
     *
     * @return $this
     */
    public function setField($field)
    {
        $this->container['field'] = $field;

        return $this;
    }

    /**
     * Gets equals
     *
     * @return string
     */
    public function getEquals()
    {
        return $this->container['equals'];
    }

    /**
     * Sets equals
     *
     * @param string $equals Value must be equal to this value. If value is specified \"true\" field must have any value selected
     *
     * @return $this
     */
    public function setEquals($equals)
    {
        $this->container['equals'] = $equals;

        return $this;
    }

    /**
     * Gets notEquals
     *
     * @return string
     */
    public function getNotEquals()
    {
        return $this->container['notEquals'];
    }

    /**
     * Sets notEquals
     *
     * @param string $notEquals Value must be not equal to this value.
     *
     * @return $this
     */
    public function setNotEquals($notEquals)
    {
        $this->container['notEquals'] = $notEquals;

        return $this;
    }

    /**
     * Gets and
     *
     * @return \Metatavu\Metaform\Api\Model\MetaformVisibleIf[]
     */
    public function getAnd()
    {
        return $this->container['and'];
    }

    /**
     * Sets and
     *
     * @param \Metatavu\Metaform\Api\Model\MetaformVisibleIf[] $and
     *
     * @return $this
     */
    public function setAnd($and)
    {
        $this->container['and'] = $and;

        return $this;
    }

    /**
     * Gets or
     *
     * @return \Metatavu\Metaform\Api\Model\MetaformVisibleIf[]
     */
    public function getOr()
    {
        return $this->container['or'];
    }

    /**
     * Sets or
     *
     * @param \Metatavu\Metaform\Api\Model\MetaformVisibleIf[] $or
     *
     * @return $this
     */
    public function setOr($or)
    {
        $this->container['or'] = $or;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


