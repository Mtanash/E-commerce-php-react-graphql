import { gql } from "@apollo/client";

const getProduct = gql`
  query Product($id: String!) {
    product(id: $id) {
      id
      name
      inStock
      gallery
      description
      category {
        name
      }
      attributes {
        id
        name
        type
        items {
          displayValue
          value
          id
        }
      }
      prices {
        currency {
          label
          symbol
        }
        amount
      }
    }
  }
`;

export default getProduct;
