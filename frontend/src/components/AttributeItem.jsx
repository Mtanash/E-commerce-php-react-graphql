import classes from "./AttributeItem.module.css";

export default function AttributeItem({
  item,
  itemSelected,
  handleAttributeClick,
  attribute,
}) {
  const isSwatch = attribute.type === "swatch";

  console.log(item);

  return (
    <button
      key={item.id}
      className={`${isSwatch ? classes.swatch : classes.item} ${
        itemSelected && classes.active
      }`}
      onClick={() => handleAttributeClick(attribute, item)}
      style={isSwatch ? { backgroundColor: item.value } : {}}
    >
      {!isSwatch && item.displayValue}
    </button>
  );
}
