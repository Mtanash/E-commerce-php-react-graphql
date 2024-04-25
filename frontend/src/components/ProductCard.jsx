import { useNavigate } from "react-router-dom";
import AddToCartButton from "./AddToCartButton";
import classes from "./ProductCard.module.css";

export default function ProductCard({ product }) {
  const navigate = useNavigate();
  const isOutOfStock = !product.inStock;

  const handleProductClick = () => {
    navigate(`/products/${product.id}`);
  };

  return (
    <div
      onClick={handleProductClick}
      className={`${classes.productCard} ${
        isOutOfStock ? classes.outOfStock : ""
      }`}
    >
      <div className={classes.addToCardBtnContainer}>
        <AddToCartButton product={product} />
      </div>

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
