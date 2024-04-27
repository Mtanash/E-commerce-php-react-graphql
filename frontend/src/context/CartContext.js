import { equals } from "ramda";
import React, {
  createContext,
  useCallback,
  useContext,
  useEffect,
  useState,
} from "react";
import generateID from "../utils/generateID";

// {
//   "__typename": "Product",
//   "id": "apple-imac-2021",
//   "name": "iMac 2021",
//   "inStock": true,
//   "gallery": [
//       "https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/imac-24-blue-selection-hero-202104?wid=904&hei=840&fmt=jpeg&qlt=80&.v=1617492405000"
//   ],
//   "description": "The new iMac!",
//   "category": {
//       "__typename": "Category",
//       "name": "tech"
//   },
//   "attributes": [
//       {
//           "__typename": "AttributeSet",
//           "id": "Capacity",
//           "name": "Capacity",
//           "type": "text",
//           "items": [
//               {
//                   "__typename": "Attribute",
//                   "displayValue": "256GB",
//                   "value": "256GB",
//                   "id": "256GB"
//               },
//               {
//                   "__typename": "Attribute",
//                   "displayValue": "512GB",
//                   "value": "512GB",
//                   "id": "512GB"
//               }
//           ]
//       },
//       {
//           "__typename": "AttributeSet",
//           "id": "With USB 3 ports",
//           "name": "With USB 3 ports",
//           "type": "text",
//           "items": [
//               {
//                   "__typename": "Attribute",
//                   "displayValue": "Yes",
//                   "value": "Yes",
//                   "id": "Yes"
//               },
//               {
//                   "__typename": "Attribute",
//                   "displayValue": "No",
//                   "value": "No",
//                   "id": "No"
//               }
//           ]
//       },
//       {
//           "__typename": "AttributeSet",
//           "id": "Touch ID in keyboard",
//           "name": "Touch ID in keyboard",
//           "type": "text",
//           "items": [
//               {
//                   "__typename": "Attribute",
//                   "displayValue": "Yes",
//                   "value": "Yes",
//                   "id": "Yes"
//               },
//               {
//                   "__typename": "Attribute",
//                   "displayValue": "No",
//                   "value": "No",
//                   "id": "No"
//               }
//           ]
//       }
//   ],
//   "prices": [
//       {
//           "__typename": "Price",
//           "currency": {
//               "__typename": "Currency",
//               "label": "USD",
//               "symbol": "$"
//           },
//           "amount": 1688.03
//       }
//   ],
//   "selectedAttributes": {
//       "Capacity": {
//           "__typename": "Attribute",
//           "displayValue": "512GB",
//           "value": "512GB",
//           "id": "512GB"
//       },
//       "With USB 3 ports": {
//           "__typename": "Attribute",
//           "displayValue": "Yes",
//           "value": "Yes",
//           "id": "Yes"
//       },
//       "Touch ID in keyboard": {
//           "__typename": "Attribute",
//           "displayValue": "No",
//           "value": "No",
//           "id": "No"
//       }
//   }
// }

const compareProductsSelectedAttributes = (firstProduct, secondProduct) => {
  const firstAttributes = firstProduct.selectedAttributes;
  const secondAttributes = secondProduct.selectedAttributes;

  for (const key in firstAttributes) {
    if (!equals(firstAttributes[key], secondAttributes[key])) {
      return false;
    }
  }

  return true;
};

const persistCart = (cart) => {
  if (typeof window !== "undefined") {
    localStorage.setItem("cart", JSON.stringify(cart));
  }
};

const getCart = () => {
  if (typeof window !== "undefined") {
    const cart = localStorage.getItem("cart");
    return cart ? JSON.parse(cart) : [];
  }
};

const CartContext = createContext();

export const useCart = () => {
  return useContext(CartContext);
};

// item = {product, quantity}

export const CartProvider = ({ children }) => {
  const [cart, setCart] = useState(getCart());
  const [cartIsOpen, setCartIsOpen] = useState(false);

  const toggleCart = useCallback(() => {
    setCartIsOpen((prev) => {
      if (prev) {
        document.body.style.overflow = "auto";
        return false;
      } else {
        document.body.style.overflow = "hidden";
        return true;
      }
    });
  }, []);

  useEffect(() => {
    persistCart(cart);
  }, [cart]);

  const addProductToCart = (product) => {
    let newCart = [...cart];

    if (product.selectedAttributes !== undefined) {
      const existProductIndex = newCart.findIndex(
        (p) => p.product.id === product.id
      );
      if (existProductIndex !== -1) {
        const existProduct = newCart[existProductIndex];
        if (compareProductsSelectedAttributes(existProduct.product, product)) {
          const updatedProduct = {
            ...existProduct,
            quantity: existProduct.quantity + 1,
          };
          newCart[existProductIndex] = updatedProduct;
        } else {
          newCart.push({ product, quantity: 1, id: generateID() });
        }
      } else {
        newCart.push({ product, quantity: 1, id: generateID() });
      }
    } else {
      newCart.push({ product, quantity: 1, id: generateID() });
    }

    setCart(newCart);
  };

  const removeProductFromCart = (cartProductId) => {
    const newProducts = cart.filter((cartProduct) => {
      return cartProduct.id !== cartProductId;
    });

    setCart(newProducts);
  };

  const clearCart = () => {
    setCart([]);
  };

  const getTotalItems = () => {
    return cart.reduce((total, cartProduct) => total + cartProduct.quantity, 0);
  };

  const getTotalPrice = () => {
    return cart.reduce((total, cartProduct) => {
      return (
        total + cartProduct.product.prices[0].amount * cartProduct.quantity
      );
    }, 0);
  };

  const incrementQuantity = (cartProductId) => {
    const newCart = cart.map((cartProduct) => {
      if (cartProduct.id === cartProductId) {
        return { ...cartProduct, quantity: cartProduct.quantity + 1 };
      } else {
        return cartProduct;
      }
    });
    setCart(newCart);
  };

  const decrementQuantity = (cartProductId) => {
    const newCart = cart
      .map((cartProduct) => {
        if (cartProduct.id === cartProductId) {
          return { ...cartProduct, quantity: cartProduct.quantity - 1 };
        } else {
          return cartProduct;
        }
      })
      .filter((cartProduct) => cartProduct.quantity > 0);
    setCart(newCart);
  };

  return (
    <CartContext.Provider
      value={{
        cart,
        addProductToCart,
        removeProductFromCart,
        clearCart,
        getTotalItems,
        getTotalPrice,
        incrementQuantity,
        decrementQuantity,
        cartIsOpen,
        toggleCart,
      }}
    >
      {children}
    </CartContext.Provider>
  );
};
