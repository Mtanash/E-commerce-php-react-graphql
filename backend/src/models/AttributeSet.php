<?php

namespace models;

use models\AbstractAttributeSet;
use models\Attribute;

class AttributeSet extends AbstractAttributeSet
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
   * @var string
   */
  protected $type;

  /**
   * @var Attribute[]
   */
  protected $items;

  public function __construct(
    $id,
    $name,
    $type,
    $items
  ) {
    $this->id = $id;
    $this->name = $name;
    $this->type = $type;
    $this->setItems($items);
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getType(): string
  {
    return $this->type;
  }

  public function getItems(): array
  {
    return $this->items;
  }

  /**
   * Sets the items for the object.
   *
   * @param mixed $items The items to set. Can be a JSON string or an array.
   * @throws \InvalidArgumentException If the items are not a valid JSON array.
   * @return void
   */
  public function setItems($items): void
  {
    if (is_string($items)) {
      $decodedItems = json_decode($items);
      if (!is_array($decodedItems)) {
        throw new \InvalidArgumentException('Items must be a valid JSON array');
      }
    } elseif (!is_array($items)) {
      throw new \InvalidArgumentException('Items must be a JSON string or an array');
    } else {
      $decodedItems = $items;
    }

    foreach ($decodedItems as $item) {
      if (is_object($item)) {
        $this->items[] = new Attribute($item->id, $item->value, $item->displayValue);
      } else {
        $this->items[] = new Attribute($item['id'], $item['value'], $item['displayValue']);
      }
    }
  }
}
