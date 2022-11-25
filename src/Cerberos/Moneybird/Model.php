<?php

namespace Cerberos\Moneybird;

abstract class Model
{
    const NESTING_TYPE_ARRAY_OF_OBJECTS = 0;
    const NESTING_TYPE_NESTED_OBJECTS   = 1;
    const JSON_OPTIONS                  = JSON_FORCE_OBJECT;

    /**
     * @var Connection
     */
    protected Connection $connection;

    /**
     * @var array
     */
    protected array $attributes = [];

    /**
     * @var array
     */
    protected array $attribute_changes = [];

    /**
     * @var bool
     */
    protected bool $initializing = false;

    /**
     * @var string
     */
    protected string $endpoint = '';

    /**
     * @var array
     */
    protected array $fillable = [];

    /**
     * @var string
     */
    protected string $filterEndpoint = '';

    /**
     * @var string
     */
    protected string $primaryKey = 'id';

    /**
     * @var string
     */
    protected string $namespace = '';

    /**
     * @var array
     */
    protected array $singleNestedEntities = [];

    /**
     * Array containing the name of the attribute that contains nested objects as key and an array with the entity name
     * and json representation type.
     *
     * JSON representation of an array of objects (NESTING_TYPE_ARRAY_OF_OBJECTS) : [ {}, {} ]
     * JSON representation of nested objects (NESTING_TYPE_NESTED_OBJECTS): { "0": {}, "1": {} }
     *
     * @var array
     */
    protected array $multipleNestedEntities = [];

    /**
     * @param Connection $connection
     * @param array      $attributes
     */
    public function __construct(Connection $connection, array $attributes = [])
    {
        $this->connection = $connection;

        $this->fill($attributes, false);
    }

    /**
     * @return Connection
     */
    public function connection(): Connection
    {
        return $this->connection;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return int[]|string[]
     */
    public function getDirty(): array
    {
        return array_keys($this->attribute_changes);
    }

    /**
     * @return array
     */
    public function getDirtyValues(): array
    {
        return $this->attribute_changes;
    }

    /**
     * @param $attributeName
     *
     * @return bool
     */
    public function isAttributeDirty($attributeName): bool
    {
        if (array_key_exists($attributeName, $this->attribute_changes)) {
            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    public function clearDirty(): void
    {
        $this->attribute_changes = [];
    }

    /**
     * @param $key
     *
     * @return mixed|null
     */
    public function __get($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        return null;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return void
     */
    public function __set($key, $value)
    {
        if ($this->isFillable($key)) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        if (!array_key_exists($this->primaryKey, $this->attributes)) {
            return false;
        }

        return !empty($this->attributes[$this->primaryKey]);
    }

    /**
     * @return false|string
     */
    public function json(): bool|string
    {
        $array = $this->getArrayWithNestedObjects();

        return json_encode($array, static::JSON_OPTIONS);
    }

    /**
     * @return false|string
     */
    public function jsonWithNamespace(): bool|string
    {
        if ($this->namespace !== '') {
            return json_encode([$this->namespace => $this->getArrayWithNestedObjects()], static::JSON_OPTIONS);
        } else {
            return $this->json();
        }
    }

    /**
     * @param array $response
     *
     * @return $this
     */
    public function makeFromResponse(array $response): static
    {
        $entity = new static($this->connection);
        $entity->selfFromResponse($response);

        return $entity;
    }

    /**
     * @param array $response
     *
     * @return $this
     */
    public function selfFromResponse(array $response): static
    {
        $this->fill($response, true);

        foreach ($this->getSingleNestedEntities() as $key => $value) {
            if (isset($response[$key])) {
                $entityName = $value;

                $this->$key = new $entityName($this->connection, $response[$key]);
            }
        }

        foreach ($this->getMultipleNestedEntities() as $key => $value) {
            if (isset($response[$key])) {
                $entityName = $value['entity'];

                /** @var self $instantiatedEntity */
                $instantiatedEntity = new $entityName($this->connection);

                $this->$key = $instantiatedEntity->collectionFromResult($response[$key]);
            }
        }

        return $this;
    }

    /**
     * @param array $result
     *
     * @return array
     */
    public function collectionFromResult(array $result): array
    {
        if (count(array_filter(array_keys($result), 'is_string'))) {
            $result = [$result];
        }

        $collection = [];
        foreach ($result as $r) {
            $collection[] = $this->makeFromResponse($r);
        }

        return $collection;
    }

    /**
     * @return array
     */
    public function getSingleNestedEntities(): array
    {
        return $this->singleNestedEntities;
    }

    /**
     * @return array
     */
    public function getMultipleNestedEntities(): array
    {
        return $this->multipleNestedEntities;
    }

    /**
     * @return array
     */
    public function __debugInfo()
    {
        $result = [];

        foreach ($this->fillable as $attribute) {
            $result[$attribute] = $this->$attribute;
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function getFilterEndpoint(): string
    {
        return $this->filterEndpoint ?: $this->endpoint;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->attributes[$name]) && null !== $this->attributes[$name];
    }

    /**
     * @param array $attributes
     * @param       $first_initialize
     *
     * @return void
     */
    protected function fill(array $attributes, $first_initialize): void
    {
        if ($first_initialize) {
            $this->enableFirstInitialize();
        }

        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }

        if ($first_initialize) {
            $this->disableFirstInitialize();
        }
    }

    /**
     * @return void
     */
    protected function enableFirstInitialize(): void
    {
        $this->initializing = true;
    }

    /**
     * @return void
     */
    protected function disableFirstInitialize(): void
    {
        $this->initializing = false;
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    protected function fillableFromArray(array $attributes): array
    {
        if (count($this->fillable) > 0) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        return $attributes;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    protected function isFillable($key): bool
    {
        return in_array($key, $this->fillable, true);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setAttribute($key, $value): void
    {
        if (!isset($this->attribute_changes[$key])) {
            $from = null;

            if (isset($this->attributes[$key])) {
                $from = $this->attributes[$key];
            }

            $this->attribute_changes[$key] = [
                'from' => $from,
                'to'   => $value,
            ];
        } else {
            $this->attribute_changes[$key]['to'] = $value;
        }

        $this->attributes[$key] = $value;
    }

    /**
     * @param $useAttributesAppend
     *
     * @return array
     */
    private function getArrayWithNestedObjects($useAttributesAppend = true): array
    {
        $result = [];
        $multipleNestedEntities = $this->getMultipleNestedEntities();

        foreach ($this->attributes as $attributeName => $attributeValue) {
            if (!is_object($attributeValue)) {
                //check if result is changed
                if ($this->isAttributeDirty($attributeName)) {
                    $result[$attributeName] = $attributeValue;
                }
            }

            if (array_key_exists($attributeName, $this->getSingleNestedEntities())) {
                $result[$attributeName] = $attributeValue->attributes;
            }

            if (array_key_exists($attributeName, $multipleNestedEntities)) {
                if ($useAttributesAppend) {
                    $attributeNameToUse = $attributeName . '_attributes';
                } else {
                    $attributeNameToUse = $attributeName;
                }

                $result[$attributeNameToUse] = [];

                foreach ($attributeValue as $attributeEntity) {
                    $result[$attributeNameToUse][] = $attributeEntity->attributes;
                }

                if ($multipleNestedEntities[$attributeName]['type'] === self::NESTING_TYPE_NESTED_OBJECTS) {
                    $result[$attributeNameToUse] = (object) $result[$attributeNameToUse];
                }

                if ($multipleNestedEntities[$attributeName]['type'] === self::NESTING_TYPE_NESTED_OBJECTS
                    && empty($result[$attributeNameToUse])
                ) {
                    $result[$attributeNameToUse] = new \stdClass();
                }
            }
        }

        return $result;
    }
}
