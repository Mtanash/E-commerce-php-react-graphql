import { Link } from "react-router-dom";

export default function NoMatch() {
  return (
    <div>
      <h1>Oops! looks like you got lost</h1>

      <Link to="/">Go Home</Link>
    </div>
  );
}
