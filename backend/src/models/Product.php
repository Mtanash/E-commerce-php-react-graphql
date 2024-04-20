<?php

namespace models;


use classes\LoggerFactory;
use models\AbstractProduct;
use models\Price;
use models\AttributeSet;
use models\Category;

class Product extends AbstractProduct
{
  /**
   * @var string
   */
  protected $id;
  /**
   * @var string
   */
  protected $name;
  /**
   * @var bool
   */
  protected $inStock;
  /**
   * @var array
   */
  protected $gallery;
  /**
   * @var string
   */
  protected $description;
  /**
   * @var Category
   */
  protected $category;
  /**
   * @var AttributeSet[]
   */
  protected $attributes = [];
  /**
   * @var Price[]
   */
  protected $prices;
  /**
   * @var string
   */
  protected $brand;

  public function __construct(
    $id,
    $name,
    $inStock,
    $gallery,
    $description,
    $category,
    $attributes,
    $prices,
    $brand
  ) {
    $this->id = $id;
    $this->name = $name;
    $this->setInStock($inStock);
    $this->setGallery($gallery);
    $this->description = $description;
    $this->setCategory($category);
    $this->setAttributes($attributes);
    $this->setPrices($prices);
    $this->brand = $brand;
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function isInStock(): bool
  {
    return $this->inStock;
  }

  public function getGallery(): array
  {
    return $this->gallery;
  }

  public function getDescription(): string
  {
    return $this->description;
  }

  public function getCategory(): Category
  {
    return $this->category;
  }

  public function getAttributes(): array
  {
    return $this->attributes;
  }

  public function getPrices(): array
  {
    return $this->prices;
  }

  public function getBrand(): string
  {
    return $this->brand;
  }

  public function setInStock($inStock): void
  {
    if (!is_bool($inStock)) {
      if ($inStock === 0 || $inStock === 1) {
        $this->inStock = (bool) $inStock;
      } else {
        throw new \InvalidArgumentException('InStock must be 0 or 1');
      }
    } else {
      $this->inStock = $inStock;
    }
  }

  public function setGallery($gallery): void
  {
    if (is_string($gallery)) {
      $this->gallery = json_decode($gallery, true);
    } else if (is_array($gallery)) {
      $this->gallery = $gallery;
    } else {
      throw new \InvalidArgumentException('Gallery must be a json string or an array');
    }
  }

  public function setAttributes($attributes): void
  {
    $logger = LoggerFactory::getLogger();
    $logger->debug('setAttributes' . print_r($attributes, true));

    if (is_string($attributes)) {
      $decodedAttributes = json_decode($attributes);

      if (!is_array($decodedAttributes)) {
        throw new \InvalidArgumentException('Attributes must be a valid JSON array');
      }
    } else if (!is_array($attributes)) {
      throw new \InvalidArgumentException('Attributes must be a JSON string or an array');
    } else {
      $decodedAttributes = $attributes;
    }

    foreach ($decodedAttributes as $attribute) {
      if (is_object($attribute)) {
        $this->attributes[] = new AttributeSet($attribute->id, $attribute->name, $attribute->type, $attribute->items);
      } else {
        $this->attributes[] = new AttributeSet($attribute['id'], $attribute['name'], $attribute['type'], $attribute['items']);
      }
    }
  }

  public function setPrices($prices): void
  {
    if (is_string($prices)) {
      $decodedPrices = json_decode($prices);
      if (!is_array($decodedPrices)) {
        throw new \InvalidArgumentException('Prices must be a valid JSON array');
      }
    } elseif (!is_array($prices)) {
      throw new \InvalidArgumentException('Prices must be a JSON string or an array');
    } else {
      $decodedPrices = $prices;
    }

    foreach ($decodedPrices as $price) {
      if (is_object($price)) {
        $this->prices[] = new Price($price->currency, $price->amount);
      } else {
        $this->prices[] = new Price($price['currency'], $price['amount']);
      }
    }
  }

  public function setCategory($category): void
  {
    if (is_string($category)) {
      $this->category = new Category($category);
    } else if ($category instanceof Category) {
      $this->category = $category;
    } else {
      throw new \InvalidArgumentException('Category must be a string or an object');
    }
  }
}
