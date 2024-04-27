import { useMutation } from "@apollo/client";
import { dissoc } from "ramda";
import Swal from "sweetalert2";
import { useCart } from "../context/CartContext";
import createOrder from "../mutations/createOrder";
import classes from "./PlaceOrderButton.module.css";

export default function PlaceOrderButton() {
  const { cart, clearCart, toggleCart, getTotalPrice } = useCart();

  const [mutate, { loading }] = useMutation(createOrder);

  const handlePlaceOrder = () => {
    // handle order placement

    const products = cart.map((cartProduct) => {
      return {
        id: cartProduct.product.id,
        quantity: cartProduct.quantity,
        selectedAttributes: Object.keys(
          cartProduct.product.selectedAttributes
        ).map((key) => ({
          id: key,
          value: cartProduct.product.selectedAttributes[key].id,
        })),
      };
    });

    const currency = cart[0].product.prices[0].currency;
    // delete __typename if exists in currency
    const sanitizedCurrency = dissoc("__typename", currency);

    mutate({
      variables: {
        products,
        total: getTotalPrice(),
        currency: sanitizedCurrency,
      },
      onCompleted: ({ createOrder }) => {
        const orderNumber = createOrder?.id;
        const orderTotal = createOrder?.total;
        clearCart();
        toggleCart();
        Swal.fire({
          icon: "success",
          title: "Order placed successfully",
          // text: `Order number: ${orderNumber} \nOrder total: ${orderTotal}`,
          html: `
            <p>Order Number : <strong>${orderNumber}</strong></p>
            <p>Order Total: <strong>${orderTotal?.toFixed(2)}</strong></p>
            <br>
            <p>Thank you for your order!</p>
          `,
          confirmButtonText: "OK",
          confirmButtonColor: "#5ECE7B",
        });
      },
      onError: (error) => {
        console.log(error);
      },
    });
  };

  return (
    <button
      className={classes.placeOrderBtn}
      onClick={handlePlaceOrder}
      disabled={cart.length === 0 || loading}
    >
      Place Order
    </button>
  );
}
