import "./Product.css";
import { useEffect, useRef, useState } from "react";

function Product({ product, onRegisterCheckBoxRef }) {
  const [isChecked, setIsChecked] = useState(false);
  const checkBoxRef = useRef(null);

  useEffect(() => {
    onRegisterCheckBoxRef(product.sku, checkBoxRef);
  }, []);

  const typeBasedInformation = (type) => {
    if (type === "BOOK") {
      return `Weight: ${product.weight}KG`;
    } else if (type === "DVD") {
      return `Size: ${product.size}MB`;
    }
    return `Dimension: ${product.height}*${product.width}*${product.length}`;
  };

  const getEmoji = (type) => {
    if (type === "BOOK") {
      return `📕`;
    } else if (type === "DVD") {
      return `💿`;
    }
    return `🚪`;
  };

  const cardClicked = () => {
    setIsChecked(!isChecked);
  };

  return (
    <>
      <div
        className="col-lg-3 col-md-6 col-sm-12 card p-3 border border-dark"
        onClick={cardClicked}
      >
        <input
          ref={checkBoxRef}
          className="delete-checkbox form-check-input mb-3"
          type="checkbox"
          onChange={cardClicked}
          checked={isChecked}
        />
        <div className="text-center">
          <p>
            {getEmoji(product.type)} {product.sku}
          </p>
          <p>{product.name}</p>
          <p>{product.price}$</p>
          <p>{typeBasedInformation(product.type)}</p>
        </div>
      </div>
    </>
  );
}

export default Product;
