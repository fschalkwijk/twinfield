<?php

namespace PhpTwinfield\Fields\Dimensions\Level2\Customer;

use PhpTwinfield\Enums\CollectionSchema;

trait CollectionSchemaField
{
    /**
     * Collection schema field
     * Used by: CustomerFinancials
     *
     * @var CollectionSchema|null
     */
    private $collectionSchema;

    public function getCollectionSchema(): ?CollectionSchema
    {
        return $this->collectionSchema;
    }

    /**
     * @param CollectionSchema|null $collectionSchema
     * @return $this
     */
    public function setCollectionSchema(?CollectionSchema $collectionSchema): self
    {
        $this->collectionSchema = $collectionSchema;
        return $this;
    }

    /**
     * @param string|null $collectionSchemaString
     * @return $this
     * @throws Exception
     */
    public function setCollectionSchemaFromString(?string $collectionSchemaString)
    {
        return $this->setCollectionSchema(new CollectionSchema((string)$collectionSchemaString));
    }
}