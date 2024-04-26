import { useEffect, useRef } from "react";
import { useCart } from "../context/CartContext";
import classes from "./CartOverlay.module.css";

export default function CartOverlay({ toggleCart, cartIsOpen }) {
  const {
    cart,
    getTotalItems,
    getTotalPrice,
    incrementQuantity,
    decrementQuantity,
  } = useCart();

  const cartRef = useRef(null);

  useEffect(() => {
    const handleClickOutsideCart = (event) => {
      if (event.target.classList.contains(classes.cartOverlay)) {
        toggleCart();
      }
    };

    document.addEventListener("click", handleClickOutsideCart);

    return () => {
      document.removeEventListener("click", handleClickOutsideCart);
    };
  }, []);

  const totalItems = getTotalItems();
  const itemsTitle =
    totalItems > 0 ? (totalItems > 1 ? totalItems + " items" : "1 item") : "";
  const cartTotal = getTotalPrice()?.toFixed(2);

  const isItemSelected = (cartProduct, attribute, item) => {
    return Object.entries(cartProduct.product?.selectedAttributes).some(
      ([key, value]) => {
        return key === attribute.id && value.id === item.id;
      }
    );
  };

  const changeQuantity = (cartProduct, changeType) => {
    // changeType = "increase" or "decrease"
    switch (changeType) {
      case "increase":
        incrementQuantity(cartProduct.product.id);
        break;
      case "decrease":
        decrementQuantity(cartProduct.product.id);
        break;
      default:
        break;
    }
  };

  return (
    <div className={classes.cartOverlay}>
      <div className={classes.cart} ref={cartRef}>
        <h2 className={classes.cartTitle}>
          My Bag, <span>{itemsTitle}</span>
        </h2>
        <div className={classes.cartProducts}>
          {cart?.map((cartProduct) => {
            return (
              <div key={cartProduct.product.id} className={classes.cartProduct}>
                <div className={classes.productInfo}>
                  <p className={classes.productName}>
                    {cartProduct.product.name}
                  </p>
                  <p className={classes.productPrice}>
                    {cartProduct.product.prices[0].currency.symbol}
                    {cartProduct.product.prices[0].amount?.toFixed(2)}
                  </p>

                  {/* attributes */}
                  <div className={classes.productAttributes}>
                    {cartProduct.product?.attributes?.map((attribute) => {
                      return (
                        <div className={classes.attribute} key={attribute.id}>
                          <p className={classes.title}>{attribute.name}:</p>
                          <div className={classes.items}>
                            {attribute.items.map((item) => {
                              return (
                                <span
                                  key={item.id}
                                  className={`${classes.item} ${
                                    isItemSelected(
                                      cartProduct,
                                      attribute,
                                      item
                                    ) && classes.selected
                                  }`}
                                >
                                  {item.value}
                                </span>
                              );
                            })}
                          </div>
                        </div>
                      );
                    })}
                  </div>
                </div>
                <div className={classes.quantityContainer}>
                  <button
                    className={classes.increase}
                    onClick={() => changeQuantity(cartProduct, "increase")}
                  >
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <g clipPath="url(#clip0_92234_46)">
                        <path
                          d="M12 8V16"
                          stroke="#1D1F22"
                          stroke-linecap="round"
                          strokeLinejoin="round"
                        />
                        <path
                          d="M8 12H16"
                          stroke="#1D1F22"
                          stroke-linecap="round"
                          strokeLinejoin="round"
                        />
                        <rect
                          x="0.5"
                          y="0.5"
                          width="23"
                          height="23"
                          stroke="#1D1F22"
                        />
                      </g>
                      <defs>
                        <clipPath id="clip0_92234_46">
                          <rect width="24" height="24" fill="white" />
                        </clipPath>
                      </defs>
                    </svg>
                  </button>
                  <p className={classes.quantity}>{cartProduct.quantity}</p>
                  <button
                    className={classes.decrease}
                    onClick={() => changeQuantity(cartProduct, "decrease")}
                  >
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <rect
                        x="0.5"
                        y="0.5"
                        width="23"
                        height="23"
                        stroke="#1D1F22"
                      />
                      <path
                        d="M8 12H16"
                        stroke="#1D1F22"
                        stroke-linecap="round"
                        strokeLinejoin="round"
                      />
                    </svg>
                  </button>
                </div>

                <img
                  src={cartProduct.product.gallery[0]}
                  alt={cartProduct.product.name}
                  width={120}
                  height={165}
                  className={classes.productImage}
                />
              </div>
            );
          })}

          <div className={classes.cartTotal}>
            <p className={classes.total}>Total</p>
            <p className={classes.totalPrice}>
              {cart[0]?.product.prices[0].currency.symbol}
              {cartTotal}
            </p>
          </div>

          <button
            className={classes.placeOrderBtn}
            onClick={() => {}}
            disabled={cart.length === 0}
          >
            Place Order
          </button>
        </div>
      </div>
    </div>
  );
}
