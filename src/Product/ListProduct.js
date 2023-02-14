import ListProductHeader from "./Headers/ListProductHeader";
import { endpoint } from "../Config/Api";
import { useEffect, useState } from "react";
import Product from "./Product";

function ListProduct() {
  const [loading, setLoading] = useState(true);
  const [products, setProducts] = useState([]);
  const [checkBoxRefs, setCheckBoxRefs] = useState([]);

  useEffect(() => {
    fetch(`${endpoint}/read.php`)
      .then((res) => res.json())
      .then((value) => {
        setLoading(false);
        value.data && setProducts(value.data);
      })
      .catch((reason) => {
        setLoading(false);
      });
  }, []);

  const prepareProductToDelete = () => {
    const productToDelete = [];
    for (const key in checkBoxRefs) {
      const val = checkBoxRefs[key];
      if (val.current.checked) {
        productToDelete.push(key);
      }
    }
    return productToDelete;
  };

  const deleteProducts = () => {
    const productToDelete = prepareProductToDelete();
    console.log(productToDelete);
    if (productToDelete.length > 0) {
      fetch(`${endpoint}/delete.php`, {
        method: "DELETE",
        body: JSON.stringify({
          skus: productToDelete,
        }),
      })
        .then(() => {
          const newProducts = products.filter(
            (product) => productToDelete.indexOf(product.sku) === -1
          );
          setProducts(newProducts);
        })
        .catch((error) => console.log(error));
    }
  };

  const registerCheckBoxRefs = (sku, newCheckBoxRef) => {
    const prev = checkBoxRefs;
    prev[sku] = newCheckBoxRef;
    setCheckBoxRefs(prev);
  };

  return (
    <>
      <ListProductHeader onBatchDeleteClicked={deleteProducts} />

      <div className="row gap-3 justify-content-center">
        {products.map((product) => {
          return (
            <Product
              key={product.sku}
              product={product}
              onRegisterCheckBoxRef={registerCheckBoxRefs}
            />
          );
        })}
      </div>
    </>
  );
}

export default ListProduct;
