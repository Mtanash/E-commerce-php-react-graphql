import classes from "./Attribute.module.css";
import AttributeItem from "./AttributeItem";

export default function Attribute({
  attribute,
  selectedAttributes,
  setSelectedAttributes,
}) {
  const isItemSelected = (attribute, item) => {
    return Object.entries(selectedAttributes).some(([key, value]) => {
      return key === attribute.id && value.id === item.id;
    });
  };

  const handleAttributeClick = (attribute, item) => {
    setSelectedAttributes((prev) => {
      return {
        ...prev,
        [attribute.id]: item,
      };
    });
  };

  return (
    <div key={attribute.id} className={classes.attribute}>
      <p className={classes.title}>{attribute.name}:</p>
      <div className={classes.items}>
        {attribute.items.map((item) => (
          <AttributeItem
            key={item.id}
            item={item}
            attribute={attribute}
            itemSelected={isItemSelected(attribute, item)}
            handleAttributeClick={handleAttributeClick}
          />
        ))}
      </div>
    </div>
  );
}
