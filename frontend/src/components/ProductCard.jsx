import classes from "./ProductCard.module.css";

export default function ProductCard({ product }) {
  const isOutOfStock = !product.inStock;

  return (
    <div
      className={`${classes.productCard} ${
        isOutOfStock ? classes.outOfStock : ""
      }`}
    >
      <div className={classes.imageContainer}>
        <img
          src={product.gallery[0]}
          alt={product.name}
          className={classes.productImage}
        />
      </div>
      <h3 className={classes.productName}>{product.name}</h3>
      <p className={classes.productPrice}>
        {product.prices[0].currency.symbol}
        {product.prices[0].amount?.toFixed(2)}
      </p>
    </div>
  );
}
