import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import './login.css';

import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css'


const Login = () => {
  const [formData, setFormData] = useState({
    email: '',
    password: '',
  });

  // response login 
  const { token, setToken } = useState(null);
  const { user, setUser } = useState(null);

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
  
    try {
      const response = await axios.post('login', formData);
  
      if (response && response.data) {
        const { token, user } = response.data;
  
        setToken(token);
        setUser(user);
        console.log("Usuario logeado", response.data);
  
        // Redireccionar al usuario después del inicio de sesión
        window.location.href = '/';
      } else {
        console.error('La respuesta del servidor no contiene datos válidos.');
      }
    } catch (error) {
      if (error.response) {
        console.error('Error al iniciar sesión:', error.response.data);
      } else if (error.request) {
        console.error('Error de respuesta del servidor:', error.request);
      } else {
        console.error('Error al configurar la solicitud:', error.message);
      }
    }
  };
  return (
  //   <form onSubmit={handleSubmit}>
  //     <label>
  //       Email:
  //       <input type="email" autoComplete="email" name="email" value={formData.email} onChange={handleChange} />
  //     </label>
  //     <br />
  //     <label>
  //       Contraseña:
  //       <input type="password" name="password" autoComplete="current-password" value={formData.password} onChange={handleChange} />
  //     </label>
  //     <br />
  //     <button type="submit">Iniciar Sesión</button>
  //   </form>
  // );

  <div className="container">
  <div className="row d-flex justify-content-center mt-5">
    <div className="col-12 col-md-8 col-lg-6 col-xl-5">
      <div className="card py-3 px-2">
        <p className="text-center mb-3 mt-2">LOGIN</p>
        <div className="division">
          <div className="row">
            <div className="col-3">
              <div className="line l"></div>
            </div>
            <div className="col-6">
              <span>OU AVEC MON EMAIL</span>
            </div>
            <div className="col-3">
              <div className="line r"></div>
            </div>
          </div>
        </div>
        <form className="myform">
          <div className="form-group">
            <input type="email" className="form-control" placeholder="Email" />
          </div>
          <div className="form-group">
            <input type="password" className="form-control" placeholder="Password" />
          </div>
          <div className="row">
            <div className="col-md-6 col-12">
              <div className="form-group form-check">
                <input type="checkbox" className="form-check-input" id="exampleCheck1" />
                <label className="form-check-label" htmlFor="exampleCheck1">Remenber</label>
              </div>
            </div>
            <div className="col-md-6 col-12 bn">Register</div>
          </div>
          <div className="form-group mt-3">
            <button type="button" className="btn btn-block btn-primary btn-lg">
              <small><i className="far fa-user pr-2"></i>Login</small>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

)};
export default Login; 
if (document.getElementById('login')) {
  const Index = createRoot(document.getElementById('login'));
      Index.render(
        <React.StrictMode>
          <Login />
        </React.StrictMode>,
      );
}