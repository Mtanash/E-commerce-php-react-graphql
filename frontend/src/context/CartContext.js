import React, { createContext, useContext, useEffect, useState } from "react";

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

  useEffect(() => {
    persistCart(cart);
  }, [cart]);

  const addProductToCart = (product) => {
    if (!cart.some((cartProduct) => cartProduct.product.id === product.id)) {
      setCart([...cart, { product, quantity: 1 }]);
    } else {
      const newCart = cart.map((cartProduct) => {
        if (cartProduct.product.id === product.id) {
          return { ...cartProduct, quantity: cartProduct.quantity + 1 };
        } else {
          return cartProduct;
        }
      });
      setCart(newCart);
    }
  };

  const removeProductFromCart = (productId) => {
    const newProducts = cart.filter((cartProduct) => {
      return cartProduct.product.id !== productId;
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
      return total + cartProduct.product.price * cartProduct.quantity;
    });
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
      }}
    >
      {children}
    </CartContext.Provider>
  );
};
