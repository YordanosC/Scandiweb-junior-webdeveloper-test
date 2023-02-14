import {Outlet} from "react-router-dom";

function App() {
  return (
    <>
      <div className="container p-3">
        <Outlet />
        <div className="mt-5">
          <hr />
          <p className="text-center">Scandiweb Test assignment</p>
        </div>
      </div>
    </>
  );
}

export default App;
