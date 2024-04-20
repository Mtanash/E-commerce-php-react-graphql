import { gql } from "@apollo/client";

const getProducts = gql`
  query GetProducts($category: String) {
    products(category: $category) {
      id
      gallery
      inStock
      prices {
        amount
        currency {
          label
          symbol
        }
      }
      name
    }
  }
`;

export default getProducts;
