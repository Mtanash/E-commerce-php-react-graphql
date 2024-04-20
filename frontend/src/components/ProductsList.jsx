import { useQuery } from "@apollo/client";
import { useSearchParams } from "react-router-dom";
import getProducts from "../queries/getProducts";
import ProductCard from "./ProductCard";
import classes from "./ProductsList.module.css";

export default function ProductsList() {
  const [searchParams] = useSearchParams();
  const currentCategory = searchParams.get("category") || "all";

  const { loading, error, data } = useQuery(getProducts, {
    variables: {
      category: currentCategory === "all" ? undefined : currentCategory,
    },
  });

  return (
    <>
      <h1 className={classes.title}>{currentCategory}</h1>
      <div className={classes.productsList}>
        {data?.products?.map((product) => (
          <ProductCard key={product.id} product={product} />
        ))}
      </div>
    </>
  );
}
