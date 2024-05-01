import React, { useState } from 'react';
import { createRoot } from "react-dom/client";

export default function ChangePassword() {

  const [changePassword, setChangePassword] = useState({
    dni: '',
    password: '',
    confirm: '',
  });

  const [errors, setErrors] = useState({});
  const [error, setError] = useState("");
  const [showPassword, setShowPassword] = useState(false);
  const [showPasswordConfirm, setShowPasswordConfirm] = useState(false);

  const toggleShowPassword = () => {
    setShowPassword(!showPassword); 
  };

  const toggleShowPasswordConfirm = () => {
    setShowPasswordConfirm(!showPasswordConfirm); // Invertir el estado de mostrar contraseña
  };

  const validateForm = () => {
    const validationErrors = {};
      if (!changePassword.dni) validationErrors.dni = 'DNI es obligatorio';
      if (!changePassword.password) validationErrors.password = 'La nueva contraseña es obligatoria';
      if (!changePassword.confirm) validationErrors.confirm = 'La confirmación de la contraseña es obligatoria';
      if (changePassword.password != changePassword.confirm) validationErrors.confirm = 'las contraseñas no coinciden';
    setErrors(validationErrors);
    return Object.keys(validationErrors).length === 0;
  };

  const handleChange = (e) => {
    setChangePassword((prevLogin) => ({ ...prevLogin, [e.target.name]: e.target.value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');

    let isValid = validateForm();
    if (isValid) {
      try {
          const response = await axios.post('/changePassword', changePassword );
          console.log(response.data);
            
          if(response.data.success){
            window.location.href = 'http://127.0.0.1:8000/login';
          } else {
            console.log("Entra")
            setError("Ingrese las credenciales de nuevo.");
          }
      } catch (error) {
        if (error.response) {
          console.error('Error al cambiar la contraseña:', error.response);
          
        } 
      }  
    }
}


  return (
      <div className="container-fluid">
    <div className="row justify-content-center align-items-center" style={{ minHeight: "100vh" }}>
      <div className="col-xs-6 col-sm-6 col-md-4">
        <div className="panel panel-info">
          <h3 className="panel-title"><span className="fa-brands fa-squarespace"></span>Cambiar Contraseña</h3>
          {error && <div className="alert alert-danger">{error}</div>}
          <div className="row">
            <div className="col">
              <div className="form-group mb-2">
                <div className="input-group">
                  <div className="input-group-addon p-1"><span className="fa-solid fa-user"></span></div>
                  <input type="text" className="form-control" name="dni" id="username" placeholder="DNI" autoComplete="username" value={changePassword.dni} onChange={handleChange} />
                </div>
                {errors.dni && <p className="text-danger">{errors.dni}</p>}
              </div>
              <div className="form-group mb-2">
                <div className="input-group">
                  <div className="input-group-addon p-1"><span className="fas fa-lock"></span></div>
                  <input className="form-control" type={showPassword ? "text" : "password"} name='password' placeholder="Nueva contraseña" value={changePassword.password} onChange={handleChange} />
                  <button onClick={toggleShowPassword} className="btn btn-light h-50" type="button" id="password-addon"><i className={showPassword ? "fa fa-eye-slash" : "fa fa-eye"}></i></button>
                </div>
                  {errors.password && <p className="text-danger">{errors.password}</p>}
              </div>
              <div className="form-group mb-2">
                <div className="input-group">
                  <div className="input-group-addon p-1"><span className="fa-solid fa-right-from-bracket"></span></div>
                  <input className="form-control" type={showPasswordConfirm ? "text" : "password"} name='confirm' placeholder="Confirmar contraseña" value={changePassword.confirm} onChange={handleChange} />
                  <button onClick={toggleShowPasswordConfirm} className="btn btn-light h-50" type="button" id="password-addon"><i className={showPasswordConfirm ? "fa fa-eye-slash" : "fa fa-eye"}></i></button>
                </div>
                  {errors.confirm && <p className="text-danger">{errors.confirm}</p>}
              </div>
            </div>
          </div>
          <div className="row justify-content-center">
            <div className="col-xs-6 col-sm-6 col-md-6">
              <button onClick={handleSubmit} className="btn icon-btn-save btn-success" type="submit">
                <span className="btn-save-label p-1"><i className="fa fa-save"></i></span>Guardar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  );
}

const login = document.getElementById("changePassword");
if (login) {
    const Index = createRoot(login);
    Index.render(
        <React.StrictMode>
            <ChangePassword />
        </React.StrictMode>
    );
}
