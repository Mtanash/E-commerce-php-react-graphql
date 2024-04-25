import { useQuery } from "@apollo/client";
import { useParams } from "react-router-dom";
import getProduct from "../queries/getProduct";

export default function ProductPage() {
  const { id: productId } = useParams();

  const {
    data: product,
    loading,
    error,
  } = useQuery(getProduct, { variables: { id: productId } });

  return <div>ProductPage</div>;
}
