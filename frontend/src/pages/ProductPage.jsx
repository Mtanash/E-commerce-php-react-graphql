import { useQuery } from "@apollo/client";
import parse from "html-react-parser";
import { useRef, useState } from "react";
import { useParams } from "react-router-dom";
import getProduct from "../queries/getProduct";
import classes from "./ProductPage.module.css";

export default function ProductPage() {
  const { id: productId } = useParams();

  const addToCartBtnHelper = useRef();
  const [selectedImage, setSelectedImage] = useState(0);
  const [selectedAttributes, setSelectedAttributes] = useState({});

  const {
    data: product,
    loading,
    error,
  } = useQuery(getProduct, {
    variables: { id: productId },
    onCompleted: () => {
      setSelectedImage(product?.product?.gallery[0]);
    },
  });

  const handleImageChange = (step) => {
    const currentImgIndex = product?.product?.gallery.indexOf(selectedImage);
    // step = 1 -> right arrow || -1 -> left arrow
    if (step === 1) {
      const nextImgIndex = currentImgIndex + 1;

      if (nextImgIndex < product?.product?.gallery.length) {
        setSelectedImage(product?.product?.gallery[nextImgIndex]);
      } else {
        // go to first image
        setSelectedImage(product?.product?.gallery[0]);
      }
    } else if (step === -1) {
      const prevImgIndex = currentImgIndex - 1;

      if (prevImgIndex >= 0) {
        setSelectedImage(product?.product?.gallery[prevImgIndex]);
      } else {
        // go to last image
        setSelectedImage(
          product?.product?.gallery[product?.product?.gallery.length - 1]
        );
      }
    }
  };

  const handleAttributeClick = (attribute, item) => {
    setSelectedAttributes((prev) => {
      return {
        ...prev,
        [attribute.id]: item,
      };
    });
  };

  const isItemSelected = (attribute, item) => {
    return Object.entries(selectedAttributes).some(([key, value]) => {
      return key === attribute.id && value.id === item.id;
    });
  };

  const isAllAttributesSelected = () => {
    return (
      Object.entries(selectedAttributes).length ===
      product?.product?.attributes.length
    );
  };

  return (
    <section className={classes.productPage}>
      <div className={classes.imagesGallery}>
        <div className={classes.imagesStack}>
          {product?.product?.gallery.map((image) => (
            <img
              key={image}
              src={image}
              alt={product?.name}
              width={80}
              height={80}
              onClick={() => setSelectedImage(image)}
              className={selectedImage === image ? classes.active : null}
            />
          ))}
        </div>

        <div className={classes.mainImage}>
          <img
            src={selectedImage}
            alt={product?.name}
            width={575}
            height={478}
          />
          <div className={classes.arrows}>
            <button
              className={classes.rightArrow}
              onClick={() => handleImageChange(1)}
            >
              <svg
                width="32"
                height="32"
                viewBox="0 0 32 32"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <rect
                  width="32"
                  height="32"
                  transform="matrix(-1 0 0 1 32 0)"
                  fill="black"
                  fillOpacity="0.73"
                />
                <path
                  d="M13 8.09158L20.5 15.5836L13 23.0757"
                  stroke="white"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
              </svg>
            </button>
            <button
              className={classes.leftArrow}
              onClick={() => handleImageChange(-1)}
            >
              <svg
                width="32"
                height="32"
                viewBox="0 0 32 32"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <rect
                  width="31.6978"
                  height="31.6978"
                  transform="matrix(0.999953 0.00966993 -0.00948818 0.999955 0.300781 0)"
                  fill="black"
                  fillOpacity="0.73"
                />
                <path
                  d="M18.9687 8.16618L11.5396 15.5875L18.9687 23.0088"
                  stroke="white"
                  strokeWidth="1.5"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <div className={classes.productInfo}>
        <h1 className={classes.productName}>{product?.product?.name}</h1>

        {/* attributes */}
        <div className={classes.attributes}>
          {product?.product?.attributes?.map((attribute) => (
            <div key={attribute.id} className={classes.attribute}>
              <p className={classes.title}>{attribute.name}:</p>
              <div className={classes.items}>
                {attribute.items.map((item) => (
                  <button
                    key={item.id}
                    className={`${classes.item} ${
                      isItemSelected(attribute, item) && classes.active
                    }`}
                    onClick={() => handleAttributeClick(attribute, item)}
                  >
                    {item.displayValue}
                  </button>
                ))}
              </div>
            </div>
          ))}
        </div>

        <p className={classes.productPrice}>
          <p className={classes.title}>price:</p>
          <div className={classes.price}>
            {product?.product?.prices[0].currency.symbol}
            {product?.product?.prices[0].amount?.toFixed(2)}
          </div>
        </p>
        <button
          className={classes.addToCardBtn}
          disabled={!isAllAttributesSelected()}
        >
          Add to cart
        </button>
        <p className={classes.productDescription}>
          {parse(product?.product?.description || "")}
        </p>
      </div>
    </section>
  );
}
