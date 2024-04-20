import { useQuery } from "@apollo/client";
import { Link, useSearchParams } from "react-router-dom";
import getCategories from "../queries/getCategories";
import classes from "./HeaderCategories.module.css";

export default function HeaderCategories() {
  const [searchParams] = useSearchParams();
  const currentCategory = searchParams.get("category");

  const { data } = useQuery(getCategories);

  return (
    <ul className={classes.categories}>
      {data?.categories?.map((category) => (
        <li key={category.name}>
          <Link
            to={`/?category=${category.name}`}
            className={`${classes.link} ${
              currentCategory === category.name && classes.active
            }`}
          >
            {category.name}
          </Link>
        </li>
      ))}
    </ul>
  );
}
