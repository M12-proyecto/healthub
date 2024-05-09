import React, { useEffect, useState } from "react";  
import { createRoot } from "react-dom/client";
import AuthUser from "../AuthUser";
import axios from "axios";

export default function Login() {
    const { setToken } = AuthUser();
    const [login, setLogin] = useState({
        dni: '',
        password: '',
      });
    
    const [rememberMe, setRememberMe] = useState(false); 
    const [showPassword, setShowPassword] = useState(false);
    const [error, setError] = useState('');

    const handleChange = (e) => {
      setLogin((prevLogin) => ({ ...prevLogin, [e.target.name]: e.target.value }));
    };

    const toggleShowPassword = () => {
        setShowPassword(!showPassword);
    };

    const handleRememberMeChange = (e) => {
        setRememberMe(e.target.checked);
    };

    const loginSubmitHandler = async (e) => {
        e.preventDefault();
        setError('');
        try {
            const response = await axios.post('/login', login );
            console.log(response.data);
            
            const responseData = response.data;

            if(responseData.token && responseData.user && responseData.role){
                // Guardar token, usuario y rol
                setToken(response.data.user, response.data.token, response.data.role);
                if (rememberMe) {
                    // Si el usuario marcó "Remember me", guardar la cookie
                    const rememberMeData = JSON.stringify(login);
                    document.cookie = `rememberMe=${encodeURIComponent(rememberMeData)}; path=/; max-age=2592000`; // 30 días de duración de la cookie
                }
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

    useEffect(() => {
        // Comprobar si hay una cookie de rememberMe cada vez que se muestra la página
        const checkRememberMeCookie = () => {
            const rememberMeCookie = document.cookie.split('; ').find(row => row.startsWith('rememberMe='));
            if (rememberMeCookie) {
                const rememberMeValue = rememberMeCookie.split('=')[1];
                const rememberMeData = JSON.parse(decodeURIComponent(rememberMeValue));
                // Rellenar los campos de inicio de sesión con los datos de la cookie
                setLogin(rememberMeData);
                setRememberMe(true);
            }
        };

        window.addEventListener('pageshow', checkRememberMeCookie);

        return () => {
            window.removeEventListener('pageshow', checkRememberMeCookie);
        };
    }, []);


    return (
        <div className="account-pages align-center">
            <div className="container-fluid d-flex justify-content-center align-items-center">
                <div className="card card-autenticacion overflow-hidden">
                    <div className="bg-primary-subtle">
                        <div className="row">
                            <div className="col-12 text-center">
                                <div className="text-primary p-4">
                                    <h5 className="text-primary">Healthub - Login</h5>
                                    <p>Acceder a la aplicación</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="card-body pt-0"> 
                        <div className="formulario-autenticacion p-2">
                            {error && <div className="alert alert-danger">{error}</div>}
                            <form className="form-horizontal"  onSubmit={loginSubmitHandler}>
                                <div className="mb-3">
                                    <label htmlFor="username" className="form-label">DNI <span className="campo-obligatorio">*</span></label>
                                    <input type="text" className="form-control" name="dni" id="username" placeholder="DNI" autoComplete="username" value={login.dni} onChange={handleChange} />
                                </div>
                                <div className="mb-3">
                                    <label className="form-label">Contraseña <span className="campo-obligatorio">*</span></label>
                                    <div className="input-group auth-pass-inputgroup">
                                        <input type={showPassword ? "text" : "password"} name="password" className="form-control width80" autoComplete="current-password" placeholder="Contraseña" aria-label="Password" aria-describedby="password-addon" value={login.password} onChange={handleChange}/>
                                        <button onClick={toggleShowPassword} className="btn btn-light" type="button" id="password-addon"><i className={showPassword ? "fa fa-eye-slash" : "fa fa-eye"}></i></button>
                                    </div>
                                </div>
                                <div className="form-check">
                                    <input
                                        className="form-check-input"
                                        type="checkbox"
                                        id="remember-check"
                                        checked={rememberMe} // Asigna el estado de recordar
                                        onChange={handleRememberMeChange} // Maneja el cambio del estado de recordar
                                    />
                                    <label className="form-check-label" htmlFor="remember-check">
                                        Recuérdame
                                    </label>
                                </div>
                                <div className="mt-3 d-grid">
                                    <button className="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                </div>
                                <div className="mt-4 text-center">
                                    <a href="/changePassword" className="text-muted text-decoration-none"><i className="fas fa-lock me-1"></i>¿Has olvidado la contraseña?</a>
                                </div>
                            </form>
                        </div>
                        <div className="mt-5 text-center">
                            <div>
                            <p>Aún no tienes una cuenta? <a href="/register" className="fw-medium text-primary">Registrarse</a></p>
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
