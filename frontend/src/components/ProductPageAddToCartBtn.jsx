import PropTypes from "prop-types";
import { useCart } from "../context/CartContext";
import toaster from "../toaster";
import classes from "./ProductPageAddToCartBtn.module.css";

export default function ProductPageAddToCartBtn({
  product,
  disabled,
  selectedAttributes,
}) {
  const { addProductToCart, toggleCart } = useCart();

  const handleAddToCart = (product) => {
    addProductToCart({
      ...product,
      selectedAttributes,
    });

    toggleCart();
    toaster.success("Product added to cart");
  };

  return (
    <button
      className={classes.addToCardBtn}
      disabled={disabled}
      onClick={() => handleAddToCart(product?.product)}
    >
      Add to cart
    </button>
  );
}

ProductPageAddToCartBtn.propTypes = {
  product: PropTypes.object,
  disabled: PropTypes.bool,
  selectedAttributes: PropTypes.object,
};

ProductPageAddToCartBtn.defaultProps = {
  disabled: false,
  product: {},
};
