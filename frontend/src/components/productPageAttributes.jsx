import Attribute from "./Attribute";
import classes from "./ProductPageAttributes.module.css";

export default function ProductPageAttributes({
  attributes,
  selectedAttributes,
  setSelectedAttributes,
}) {
  return (
    <div className={classes.attributes}>
      {attributes?.map((attribute) => (
        <Attribute
          key={attribute.id}
          attribute={attribute}
          selectedAttributes={selectedAttributes}
          setSelectedAttributes={setSelectedAttributes}
        />
      ))}
    </div>
  );
}
