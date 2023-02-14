import AddProductHeader from "./Headers/AddProductHeader";
import { useState } from "react";
import UserError from "../Utils/ErrorMessage";
import { useNavigate } from "react-router-dom";
import { endpoint } from "../Config/Api";

function AddProduct() {
  const [product, setProduct] = useState({
    sku: "",
    name: "",
    price: 0,
    type: "DVD",
    size: 0,
    weight: 0,
    height: 0,
    width: 0,
    length: 0,
  });

  const [formSubmitted, setFormSubmitted] = useState(false);
  const [formInvalid, setFormInvalid] = useState(false);
  const [skuError, setSkuError] = useState(false);
  const navigate = useNavigate();

  const weightValidation = () => {
    const { type, weight } = product;
    return type === "BOOK" && weight <= 0;
  };

  const dvdValidation = () => {
    const { type, size } = product;
    return type === "DVD" && size <= 0;
  };

  const furnitureValidation = () => {
    const { type, length, width, height } = product;
    return type === "FURNITURE" && (length <= 0 || width <= 0 || height <= 0);
  };

  const validation = () => {
    const { sku, name, price, type } = product;
    if (!sku || !name || !price || price <= 0 || !type) {
      return false;
    }
    if (weightValidation()) {
      return false;
    }
    if (dvdValidation()) {
      return false;
    }

    return !furnitureValidation();
  };

  const addProduct = async (event) => {
    event.preventDefault();
    debugger;
    setFormSubmitted(true);
    const ValidData = validation();
    const isProductUnique = await productIsUnique(product.sku);
    console.log("validData:", ValidData);
    console.log("isProductUnique:", isProductUnique);
    if (ValidData && isProductUnique) {
      setFormInvalid(false);
      fetch(`${endpoint}/create.php`, {
        method: "POST",
        body: JSON.stringify(product), // We send data in JSON format
      }).then((value) => {
        navigate("/");
      });
    } else if (!isProductUnique) {
      setSkuError(true);
    } else {
      setFormInvalid(true);
    }
  };

  const setProductValue = (event) => {
    setProduct({
      ...product,
      [event.target.name]: event.target.value,
    });
  };

  const productIsUnique = async (sku) => {
    setSkuError(false);
    const response = await fetch(`${endpoint}/read.php?sku=${sku}`);
    const json_response = await response.json();
    return json_response.data.length === 0;
  };

  return (
    <>
      <AddProductHeader onSaveClicked={addProduct} />
      <hr />
      <div className="d-flex justify-content-center">
        <form className="col-6" onSubmit={addProduct} id="product_form">
          {formInvalid ? (
            <p className="mb-3 text-danger text-bold">
              Please, submit required data
            </p>
          ) : null}
          <div className="mb-3">
            <label className="form-label">SKU*</label>
            <input
              type="text"
              className="form-control"
              placeholder="SKU"
              id="sku"
              value={product.sku}
              name="sku"
              onChange={setProductValue}
              required
            />
            {skuError && (
              <UserError
                field={"sku"}
                customError={"This sku is already used"}
              />
            )}
            {!product.sku && formSubmitted && <UserError field={"sku"} />}
          </div>

          <div className="mb-3">
            <label className="form-label">Name*</label>
            <input
              type="text"
              className="form-control"
              placeholder="name"
              id="name"
              value={product.name}
              name="name"
              onChange={setProductValue}
              required
            />
            {!product.name && formSubmitted && <UserError field={"name"} />}
          </div>

          <div className="mb-3">
            <label className="form-label">Price($)*</label>
            <input
              type="number"
              className="form-control"
              placeholder="Price in dollar"
              id="price"
              value={product.price}
              name="price"
              onChange={setProductValue}
              required
            />
            {product.price <= 0 && formSubmitted && (
              <UserError field={"price"} />
            )}
          </div>

          <div className="mb-3">
            <label className="form-label">Type*</label>

            <select
              className="form-select"
              id="productType"
              value={product.type}
              name="type"
              onChange={setProductValue}
              required
            >
              <option value="DVD">DVD</option>
              <option value="BOOK">Book</option>
              <option value="FURNITURE">Furniture</option>
            </select>
            {!product.type && formSubmitted && <UserError field={"type"} />}
          </div>

          <div className="d-flex">
            {product.type === "DVD" ? (
              <div>
                <div className="form-text mb-3">
                  {" "}
                  Please, provide Size in <abbr title="Mega byte">MB</abbr>{" "}
                  format
                </div>
                <label className="form-label">Size(MB)*</label>
                <input
                  type="number"
                  className="form-control"
                  placeholder="Size in MB"
                  id="size"
                  value={product.size}
                  name="size"
                  onChange={setProductValue}
                />
                {product.size <= 0 && formSubmitted && (
                  <UserError field={"size"} />
                )}
              </div>
            ) : null}

            {product.type === "BOOK" ? (
              <div className="mb-3">
                <div className="form-text mb-3">
                  {" "}
                  Please, provide wight in <abbr title="Kilo gram">
                    KG
                  </abbr>{" "}
                  format
                </div>
                <label className="form-label">Weight(KG)*</label>
                <input
                  type="number"
                  className="form-control"
                  placeholder="Weight in KG"
                  id="weight"
                  value={product.weight}
                  name="weight"
                  onChange={setProductValue}
                />
                {product.weight <= 0 && formSubmitted && (
                  <UserError field={"weight"} />
                )}
              </div>
            ) : null}

            {product.type === "FURNITURE" ? (
              <div className="mb-3" id="for-furniture">
                <div className="form-text mb-3">
                  {" "}
                  Please, provide dimensions in{" "}
                  <abbr title="Height*Width*Length">H*W*L</abbr> format
                </div>
                <div className="mb-3">
                  <label className="form-label">Height(CM)*</label>
                  <input
                    type="number"
                    className="form-control"
                    placeholder="Height in CM"
                    id="height"
                    value={product.height}
                    name="height"
                    onChange={setProductValue}
                  />
                  {product.height <= 0 && formSubmitted && (
                    <UserError field={"height"} />
                  )}
                </div>

                <div className="mb-3">
                  <label className="form-label">Width(CM)*</label>
                  <input
                    type="number"
                    className="form-control"
                    placeholder="Width in CM"
                    id="width"
                    value={product.width}
                    name="width"
                    onChange={setProductValue}
                  />
                  {product.width <= 0 && formSubmitted && (
                    <UserError field={"width"} />
                  )}
                </div>

                <div className="mb-3">
                  <label className="form-label">Length(CM)*</label>
                  <input
                    type="number"
                    className="form-control"
                    placeholder="Length in CM"
                    id="length"
                    value={product.length}
                    name="length"
                    onChange={setProductValue}
                  />
                  {product.length <= 0 && formSubmitted && (
                    <UserError field={"length"} />
                  )}
                </div>
              </div>
            ) : null}
          </div>
        </form>
      </div>
    </>
  );
}

export default AddProduct;
