import { Link } from "react-router-dom";
import HeaderCartButton from "../components/HeaderCartButton";
import HeaderCategories from "../components/HeaderCategories";
import classes from "./Header.module.css";

export default function Header() {
  return (
    <header className={classes.header}>
      {/* categories */}
      <HeaderCategories />

      {/* logo */}
      <Link to="/" className={classes.logo}>
        <img src="/logo.svg" alt="logo" width={40} height={40} />
      </Link>

      {/* cart */}
      <HeaderCartButton />
    </header>
  );
}
