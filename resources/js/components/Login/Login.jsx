import React, { useState } from "react";  
import { createRoot } from "react-dom/client";
import AuthUser from "../AuthUser";
import axios from "axios";


export default function Login() {
    const { setToken } = AuthUser();
    const [login, setLogin] = useState({
        dni: '',
        password: '',
      });

    const [error, setError] = useState('');

    const handleChange = (e) => {
      setLogin((prevLogin) => ({ ...prevLogin, [e.target.name]: e.target.value }));
    };

    const loginSubmitHandler = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post('/login', login );
            console.log(response.data);
              
              if(response.data && response.data.success){

                // Guardar token, usuario y rol
                setToken(response.data.user, response.data.token, response.data.role);
                window.location.href = 'http://127.0.0.1:8000/home';
               } else {
                setError('Credenciales incorrectas. Por favor, inténtalo de nuevo.');
               }

        } catch (error) {
            if (error.response) {
                setError(error.response.data.error);
            } else {
                setError(error.message);
            }
        }  
    }

    return (
            <div className="account-pages my-5 pt-sm-5">
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8 col-lg-6 col-xl-5">
                        <div className="card overflow-hidden">
                            <div className="bg-primary-subtle">
                                <div className="row">
                                    <div className="col-7">
                                        <div className="text-primary p-4">
                                            <h5 className="text-primary">Bienvenido!</h5>
                                            <p>Login</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="card-body pt-0"> 
                                <div className="p-2">
                                {error && <div className="alert alert-danger">{error}</div>}
                                    <form className="form-horizontal"  onSubmit={loginSubmitHandler}>
                                        <div className="mb-3">
                                         <label htmlFor="username" className="form-label">DNI</label>
                                          <input type="text" className="form-control" name="dni" id="username" placeholder="DNI" autoComplete="username" value={login.dni} onChange={handleChange} />
                                        </div>
                                        <div className="mb-3">
                                            <label className="form-label">Password</label>
                                            <div className="input-group auth-pass-inputgroup">
                                              <input type="password" name="password" className="form-control" autoComplete="current-password" placeholder="password" aria-label="Password" aria-describedby="password-addon" value={login.password} onChange={handleChange}/>
                                              <button className="btn btn-light h-50" type="button" id="password-addon"><i className="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>

                                        <div className="form-check">
                                            <input className="form-check-input" type="checkbox" id="remember-check"/>
                                            <label className="form-check-label" htmlFor="remember-check">
                                                Remember me
                                            </label>
                                        </div>
                                        
                                        <div className="mt-3 d-grid">
                                            <button className="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                        <div className="mt-4 text-center">
                                            <a href="" className="text-muted"><i className="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                        </div>
                                    </form>
                                </div>
                                <div className="mt-5 text-center">
                                  <div>
                                  <p>Aun no tienes una cuenta? <a href="/register" className="fw-medium text-primary">register</a></p>
                                  </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

const login = document.getElementById("login");
if (login) {
    const Index = createRoot(login);
    Index.render(
        <React.StrictMode>
            <Login />
        </React.StrictMode>
    );
}
