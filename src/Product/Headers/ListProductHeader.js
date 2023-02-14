import { useNavigate } from "react-router-dom";

function ListProductHeader({ onBatchDeleteClicked }) {
  const navigate = useNavigate();

  return (
    <>
      <div className="d-flex justify-content-between">
        <h2>Product List</h2>
        <div>
          <button
            className="btn btn-outline-primary"
            onClick={(event) => navigate("/add-product")}
          >
            ADD
          </button>
          <button
            id="delete-product-btn"
            className="ms-3 btn btn-outline-danger position-relative"
            onClick={onBatchDeleteClicked}
          >
            MASS DELETE
          </button>
        </div>
      </div>
      <hr />
    </>
  );
}

export default ListProductHeader;
