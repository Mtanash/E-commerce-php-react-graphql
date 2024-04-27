const generateID = (length = 8) => {
  let id = "";
  const characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  let counter = 0;
  while (counter < length) {
    id += characters.charAt(Math.floor(Math.random() * characters.length));
    counter += 1;
  }
  return id;
};

export default generateID;
