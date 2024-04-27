import { gql } from "@apollo/client";

const createOrder = gql`
  mutation CreateOrder(
    $products: [CartProduct]!
    $total: Float!
    $currency: CurrencyInput!
  ) {
    createOrder(products: $products, total: $total, currency: $currency) {
      id
      total
      createdAt
      updatedAt
    }
  }
`;

export default createOrder;
