import { Outlet } from "react-router-dom";
import Header from "./Header";
import classes from "./MainLayout.module.css";

export default function MainLayout() {
  return (
    <>
      <Header />
      <main className={classes.content}>
        <Outlet />
      </main>
    </>
  );
}
