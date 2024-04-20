import { Link } from "react-router-dom";
import cartIcon from "../assets/icons/cart.svg";
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
      <div className={classes.cart}>
        <img src={cartIcon} alt="cart" width={20} height={20} />
      </div>
    </header>
  );
}
