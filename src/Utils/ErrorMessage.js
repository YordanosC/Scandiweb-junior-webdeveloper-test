function UserError({ field, customError = null }) {
  const error =
    customError || `Please, provide the data of indicated type ${field}`;
  return <div className="form-text text-danger"> {error} </div>;
}

export default UserError;
