import classes from "./ProductPageAttributes.module.css";

export default function ProductPageAttributes({
  attributes,
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
    <div className={classes.attributes}>
      {attributes?.map((attribute) => (
        <div key={attribute.id} className={classes.attribute}>
          <p className={classes.title}>{attribute.name}:</p>
          <div className={classes.items}>
            {attribute.items.map((item) => (
              <button
                key={item.id}
                className={`${classes.item} ${
                  isItemSelected(attribute, item) && classes.active
                }`}
                onClick={() => handleAttributeClick(attribute, item)}
              >
                {item.displayValue}
              </button>
            ))}
          </div>
        </div>
      ))}
    </div>
  );
}
