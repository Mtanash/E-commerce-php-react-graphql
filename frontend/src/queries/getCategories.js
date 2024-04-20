import { gql } from "@apollo/client";

const getCategories = gql`
  query GetCategories {
    categories {
      name
    }
  }
`;

export default getCategories;
