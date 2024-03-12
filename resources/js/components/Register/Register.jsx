import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';

export default function Register() {
  const [register, setRegister] = useState({
    cip: '',
    nombre: '',
    primerApellido: '',
    secondApellido: '',
    fechaCumpleanos: '',
    email: '',
    gender: '',
    direccion: '',
    codigoPostal: '',
    ciudad: '',
    provincia: '',
    tipoDocumento: '',
    numeroDocumento: '',
    password: '',
    confirmPassword: '',
  });
  const [errors, setErrors] = useState({});
  const [registrationError, setRegistrationError] = useState('');

    const handleChange = (e) => {
      setRegister({...register, [e.target.name]: e.target.value });
      console.log(register)
    };
  
    const handleSubmit = async (e) => {
      e.preventDefault();
      const validationErrors = {};
      if (!register.cip) validationErrors.cip = 'CIP es obligatorio';
      if (!register.nombre) validationErrors.nombre = 'Nombre es obligatorio';
      if (!register.primerApellido) validationErrors.primerApellido = 'Primer apellido es obligatorio';
      if (!register.fechaCumpleanos) validationErrors.fechaCumpleanos = 'Fecha de cumpleaños es obligatoria';
      if (!register.email) validationErrors.email = 'Email es incorrecto';
      //if (!register.gender) validationErrors.gender = 'Género es obligatorio';
      if (!register.direccion) validationErrors.direccion = 'Dirección es obligatoria';
      if (!register.codigoPostal) validationErrors.codigoPostal = 'Código postal es obligatorio';
      if (!register.ciudad) validationErrors.ciudad = 'Ciudad es obligatoria';
      if (!register.provincia) validationErrors.provincia = 'Provincia es obligatoria';
      //if (!register.tipoDocumento) validationErrors.tipoDocumento = 'Tipo de documento es obligatorio';
      if (!register.numeroDocumento) validationErrors.numeroDocumento = 'Número de documento es obligatorio';
      if (!register.password) validationErrors.password = 'Contraseña es obligatoria';
      //if (register.password != validationErrors.confirmPassword) {validationErrors.confirmPassword = 'Las contraseñas no coinciden';}

      setErrors(validationErrors);
      
      if(Object.keys(validationErrors).length == 0){
        try {
          const response = await axios.post('/register', register);
      
          if (response && response.data && response.data.success) {
            console.log('entra');
            window.location.href = '/login';
          } else {
            console.log('La solicitud de registro no fue exitosa');
          }
        } catch (error) {
          console.error('Error al registrar usuario:', error.response.data);
          setRegistrationError(error.response.data.message);
        }
      }
    }

  return (
    <>
      <div className="container  mt-5 mb-5">
      {registrationError && <div className="alert alert-danger">{registrationError}</div>}
      <form className="bg-light p-4 m-auto" onSubmit={handleSubmit}>
      <div className="row mb-3">
          <div className="col-lg-2">
            <p>CIP</p>
          </div>
          <div className="col-lg-5">
            <input type="text" className="form-control" name='cip' placeholder="" onChange={handleChange}/>
            {errors.cip && <p className="text-danger">{errors.cip}</p>}
          </div>
        </div> 
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>Nombre</p>
          </div>
          <div className="col-lg-5">
            <input type="text" className="form-control" autoComplete="username" name='nombre' placeholder="" onChange={handleChange}/>
            {errors.nombre && <p className="text-danger">{errors.nombre}</p>}
          </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>Primer apellido</p>
          </div>
          <div className="col-lg-5">
            <input type="text" className="form-control" autoComplete="username" name='primerApellido' placeholder="" onChange={handleChange}/>
            {errors.primerApellido && <p className="text-danger">{errors.primerApellido}</p>}
          </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>Segundo apellido</p>
          </div>
          <div className="col-lg-5">
            <input type="text" className="form-control" autoComplete="username" name='secondApellido' placeholder="" onChange={handleChange}/>
          </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>Fecha de cumpleaños</p>
          </div>
          <div className="col-lg-5">
            <input type="date" className="form-control" name='fechaCumpleanos' placeholder="" onChange={handleChange}/>
            {errors.fechaCumpleanos && <p className="text-danger">{errors.fechaCumpleanos}</p>}
          </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>Correo</p>
          </div>
          <div className="col-lg-5">
            <input type="text" className="form-control" name='email' placeholder="Escribe tu correo" onChange={handleChange}/>
            {errors.email && <p className="text-danger">{errors.email}</p>}
          </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>Genero</p>
          </div>
          <div className="col-lg-5 d-flex">
            <div className="form-check">
            <input className="form-check-input" type="radio" name="gender" id="male" value="Mujer" onChange={handleChange}/>
              <label className="form-check-label" htmlFor="male">
              Mujer
              </label>
            </div>
            <div className="form-check mx-3">
            <input className="form-check-input" type="radio" name="gender" id="female" value="Hombre" onChange={handleChange}/>
              <label className="form-check-label" htmlFor="female">
              Hombre
              </label>
            </div>
          </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>Dirección</p>
          </div>
          <div className="col-lg-5">
            <input type="text" className="form-control" placeholder="" name='direccion' onChange={handleChange} />
            {errors.direccion && <p className="text-danger">{errors.direccion}</p>}
          </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>código postal</p>
          </div>
          <div className="col-lg-5">
            <input type="text" className="form-control" name='codigoPostal' placeholder="Código postal" onChange={handleChange} />
            {errors.codigoPostal && <p className="text-danger">{errors.codigoPostal}</p>}
          </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>Ciudad</p>
          </div>
          <div className="col-lg-5">
            <input type="text" className="form-control" name='ciudad' placeholder="ciudad" onChange={handleChange} />
            {errors.ciudad && <p className="text-danger">{errors.ciudad}</p>}
          </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>provincia </p>
          </div>
          <div className="col-lg-5">
            <input type="text" className="form-control" name='provincia' placeholder="provincia" onChange={handleChange} />
            {errors.provincia && <p className="text-danger">{errors.provincia}</p>}
          </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>Tipos de documento </p>
          </div>
          <div className="col-lg-5 d-flex">
          <div className="form-check me-3 lh-2">
            <input className="form-check-input" type="radio" name="tipoDocumento" value="DNI" id="dni" onChange={handleChange}/>
            <label className="form-check-label-ide" htmlFor="dni">DNI</label>
          </div>
          <div className="form-check me-3 lh-2">
            <input className="form-check-input" type="radio" name="tipoDocumento" value="NIE" id="nie" onChange={handleChange}/>
            <label className="form-check-label-ide" htmlFor="nie">NIE</label>
          </div>
          <div className="form-check me-3 lh-2">
            <input className="form-check-input" type="radio" name="tipoDocumento" value="Pasaporte" id="pasaporte" onChange={handleChange}/>
            <label className="form-check-label-ide" htmlFor="pasaporte">Pasaporte</label>
          </div>
        </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>Número de documento</p>
          </div>
          <div className="col-lg-5">
            <input type="text" className="form-control" name='numeroDocumento' placeholder="" onChange={handleChange} required/>
            {errors.numeroDocumento && <p className="text-danger">{errors.numeroDocumento}</p>}
          </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>Contraseña</p>
          </div>
          <div className="col-lg-5">
            <input type="password" className="form-control" name='password' autoComplete="current-password" placeholder="Escribe la contraseña" onChange={handleChange} required/>
            {errors.password && <p className="text-danger">{errors.password}</p>}
          </div>
        </div>
        <div className="row mb-3">
          <div className="col-lg-2">
            <p>Repite la contrañeña</p>
          </div>
          <div className="col-lg-5">
            <input type="password" className="form-control" name='confirmPassword' autoComplete="current-password" placeholder="Repite la contraseña" onChange={handleChange} required/>
            {errors.confirmPassword && <p className="text-danger">{errors.confirmPassword}</p>}
          </div>
        </div>
        <div className="mt-5 text-center">
          <div>
            <p>Tienes una cuenta? <a href="/login" className="fw-medium text-primary">login</a></p>
          </div>
        </div>
        <div className='d-flex align-items-center justify-content-center'>
        <button type="submit" className="btn btn-success btn-md mx-auto">Registrarme</button>
        </div>
      </form>
    </div>
  </>
)}

const register = document.getElementById("register");
if (register) {
  const Index = createRoot(register);

  Index.render(
    <React.StrictMode>
      <Register />
    </React.StrictMode>
  );
}