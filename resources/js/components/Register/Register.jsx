import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';

export default function Register() {
  const [step, setStep] = useState(1);
  const [register, setRegister] = useState({
    cip: '',
    nombre: '',
    primerApellido: '',
    secondApellido: '',
    fechaNacimiento: '',
    role: 'Paciente',
    gender: 'Hombre',
    perfil: '',
    perfilName: '',
    codigoPostal: '',
    ciudad: '',
    calle: '',
    piso: '',
    numero: '',
    numeroDocumento: '',
    password: '',
    confirmPassword: '',
    telefonos: [{ telefono: ''}],
    correos: [{ correo: ''}],
    personaContacto: [{ nombreContacte: '', telefono: '', email: '' }],
  });
  const [errors, setErrors] = useState({});
  const [registrationError, setRegistrationError] = useState('');

  const handleChange = (e) => {
    setRegister({ ...register, [e.target.name]: e.target.value });
  };

  const handleRoleChange = (e) => {
    setRegister({ ...register, role: e.target.value });
  };

  useEffect(() => {
    if (!register.role) {
      setRegister({ ...register, role: '' });
    }
  }, []);

  const handlePerfilChange = (e) => {
    e.preventDefault();

    let reader = new FileReader();

    setRegister(prevState => ({
      ...prevState,
      perfilName: e.target.files[0].name
    }));

    reader.onloadend = () => {
      setRegister(prevState => ({
        ...prevState,
        perfil: reader.result
      }));
    };

    reader.readAsDataURL(e.target.files[0]);
  };

  const validateForm = () => {
    const validationErrors = {};
    if (step === 1) {
      if (!register.numeroDocumento) validationErrors.numeroDocumento = 'Número de documento es obligatorio';
      if (!register.cip) validationErrors.cip = 'CIP es obligatorio';
      if (!register.nombre) validationErrors.nombre = 'Nombre es obligatorio';
      if (!register.primerApellido) validationErrors.primerApellido = 'Primer apellido es obligatorio';
      if (!register.secondApellido) validationErrors.secondApellido = 'Segundo apellido es obligatorio';
      if (!register.password) validationErrors.password = 'Contraseña es obligatoria';
      if (!register.confirmPassword) validationErrors.confirmPassword = 'Contraseña es obligatoria';
      if (register.password !== register.confirmPassword) validationErrors.confirmPassword = 'las contraseñas no coinciden';
    } else if (step === 2) {
      if (!register.fechaNacimiento) validationErrors.fechaNacimiento = 'Fecha de nacimiento es obligatoria';
      if (register.telefonos[0].telefono.length === 0) validationErrors.telefonos = 'Telefono es obligatorio';
      if (register.correos[0].correo.length === 0) validationErrors.correos = 'Correo es obligatorio';
    }
    
    setErrors(validationErrors);
    return Object.keys(validationErrors).length === 0;
  };
  

  const handleSubmit = async (e) => {
    e.preventDefault();
    let isValid = validateForm();
    if (isValid) {
      try {
        const response = await axios.post('/register', register);
        console.log(register)
        if (response && response.data && response.data.success) {

            window.location.href = '/login';
        } else {
          console.log('La solicitud de registro no fue exitosa');
          console.log(response.data)
        }
      } catch (error) {
        console.error('Error al registrar usuario:', error.response.data);
        setRegistrationError(error.response.data.message);
      }
    }
  };
  
  const handleTelefonoChange = (index, value) => {
    const newTelefonos = [...register.telefonos];
    newTelefonos[index] = { telefono: value };
    setRegister(prevState => ({
      ...prevState,
      telefonos: newTelefonos
    }));
  };
  
  const addTelefono = () => {
    setRegister(prevState => ({
      ...prevState,
      telefonos: [...prevState.telefonos, { telefono: '' }]
    }));
  };
  
  const removeTelefono = (index) => {
    const newTelefonos = [...register.telefonos];
    newTelefonos.splice(index, 1);
    setRegister(prevState => ({
      ...prevState,
      telefonos: newTelefonos
    }));
  };
  
  const handleCorreoChange = (index, value) => {
    const newCorreos = [...register.correos];
    newCorreos[index] = { correo: value };
    setRegister(prevState => ({
      ...prevState,
      correos: newCorreos
    }));
  };
  
  const addCorreo = () => {
    setRegister(prevState => ({
      ...prevState,
      correos: [...prevState.correos, { correo: '' }]
    }));
  };
  
  const removeCorreo = (index) => {
    const newCorreos = [...register.correos];
    newCorreos.splice(index, 1);
    setRegister(prevState => ({
      ...prevState,
      correos: newCorreos
    }));
  };
  
  const handlePersonaContactoChange = (index, e) => {
    const { name, value } = e.target;
    const updatedPersonaContacto = [...register.personaContacto];
    updatedPersonaContacto[index] = { ...updatedPersonaContacto[index], [name]: value };
    setRegister({ ...register, personaContacto: updatedPersonaContacto });
  };

  const addPersonaContacto = () => {
    setRegister({
      ...register,
      personaContacto: [...register.personaContacto, { nombreContacte: '', telefono: '', email: '' }],
    });
  };

  const removePersonaContacto = (index) => {
    const updatedPersonaContacto = [...register.personaContacto];
    updatedPersonaContacto.splice(index, 1);
    setRegister({ ...register, personaContacto: updatedPersonaContacto });
  };


  const nextStep = () => {
    const isValid = validateForm();
    if (isValid) {
      setStep(step + 1);
    }
  };

  const prevStep = () => {
    setStep(step - 1);
  };

  const renderStep = () => {
    switch (step) {
      case 1:
        return (
          <>
            <div className="account-pages align-center">
              <div className="container-fluid d-flex justify-content-center align-items-center">
                <div className="card card-autenticacion overflow-hidden">
                  <div className="bg-primary-subtle">
                      <div className="row">
                          <div className="col-12 text-center">
                              <div className="text-primary p-4">
                                  <h5 className="text-primary">Healthub - Registro</h5>
                                  <p>Registrarse en la aplicación</p>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div className="card-body pt-0"> 
                    <div className="formulario-autenticacion p-2">
                      <div className="row">
                        <div className="text-primary p-2">
                          <h3 className="text-primary text-center">Datos personales</h3>
                        </div>
                      </div>
                      <div className="row p-2">
                        <div className="col-md-6 p-2">
                          <div>
                            <p>DNI, NIE o Pasaporte <span className="campo-obligatorio">*</span></p>
                          </div>
                          <div>
                            <input type="text" className="form-control" name="numeroDocumento" value={register.numeroDocumento} placeholder="B00000000" onChange={handleChange} required/>
                            {errors.numeroDocumento && <p className="text-danger">{errors.numeroDocumento}</p>}
                          </div>
                        </div>
                        <div className='col-md-6 p-2'>
                          <div>
                            <p>CIP <span className="campo-obligatorio">*</span></p>
                          </div>
                          <div>
                            <input type="text" className="form-control" name="cip" placeholder="NAEA1733114055" value={register.cip} onChange={handleChange}/>
                            {errors.cip && <p className="text-danger">{errors.cip}</p>}
                          </div>
                        </div>
                      </div>
                      <div className="row p-2">
                        <div className="col-md-4 p-2">
                          <div>
                            <p>Nombre <span className="campo-obligatorio">*</span></p>
                          </div>
                          <div>
                            <input type="text" className="form-control" autoComplete="username" value={register.nombre} name="nombre" placeholder="Nombre ..." onChange={handleChange}/>
                            {errors.nombre && <p className="text-danger">{errors.nombre}</p>}
                          </div>
                        </div>
                        <div className="col-md-4 p-2">
                          <div>
                            <p>Primer apellido <span className="campo-obligatorio">*</span></p>
                          </div>
                          <div>
                            <input type="text" className="form-control" autoComplete="username" value={register.primerApellido} name="primerApellido" placeholder="Primer apellido ..." onChange={handleChange}/>
                            {errors.primerApellido && <p className="text-danger">{errors.primerApellido}</p>}
                          </div>
                        </div>
                        <div className="col-md-4 p-2">
                          <div>
                            <p>Segundo apellido <span className="campo-obligatorio">*</span></p>
                          </div>
                          <div>
                            <input type="text" className="form-control" autoComplete="username" value={register.secondApellido} name="secondApellido" placeholder="Segundo apellido ..." onChange={handleChange}/>
                            {errors.secondApellido && <p className="text-danger">{errors.secondApellido}</p>}
                          </div>
                        </div>
                      </div>
                      <div className="row p-2">
                        <div className="col-md-6 p-2">
                          <div>
                            <p>Contraseña <span className="campo-obligatorio">*</span></p>
                          </div>
                          <div>
                            <input type="password" className="form-control" name="password" autoComplete="current-password" value={register.password} placeholder="Escribe tu contraseña" onChange={handleChange} required/>
                            {errors.password && <p className="text-danger">{errors.password}</p>}
                          </div>
                        </div>
                        <div className="col-md-6 p-2">
                          <div>
                            <p>Repite la contrañeña <span className="campo-obligatorio">*</span></p>
                          </div>
                          <div>
                            <input type="password" className="form-control" name="confirmPassword" autoComplete="current-password" value={register.confirmPassword} placeholder="Repite tu contraseña" onChange={handleChange} required/>
                            {errors.confirmPassword && <p className="text-danger">{errors.confirmPassword}</p>}
                          </div>
                        </div>
                      </div>
                      <div className="row p-2">
                        <div className="d-flex justify-content-center">
                          <a className="btn btn-primary btn-dark-blue link-button" href='/login'>
                            <span className="fa-solid fa-right-from-bracket me-2" aria-hidden="true" style={{transform: 'rotate(180deg)'}}></span>
                            Volver a login
                          </a>
                          <button type="button" className="btn btn-primary ms-2" onClick={nextStep}>
                            Siguiente
                            <span className="fa-solid fa-right-from-bracket ms-2" aria-hidden="true"></span>
                          </button>
                        </div>
                        <div className="mt-4 text-center">
                          <div>
                            <p className='m-0'>Ya tienes una cuenta? <a href="/login" className="fw-medium text-primary">Log In</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </>
        );
      case 2:
        return (
          <>
            <div className="account-pages align-center">
              <div className="container-fluid d-flex justify-content-center align-items-center">
                <div className="card card-autenticacion overflow-hidden">
                  <div className="bg-primary-subtle">
                    <div className="row">
                        <div className="col-12 text-center">
                            <div className="text-primary p-4">
                                <h5 className="text-primary">Healthub - Registro</h5>
                                <p>Registrarse en la aplicación</p>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div className="card-body pt-0"> 
                    <div className="formulario-autenticacion p-2">
                      <div className="row">
                        <div className="text-primary p-2">
                          <h3 className="text-primary text-center">Datos personales adicionales</h3>
                        </div>
                      </div>
                      <div className="row p-2">
                        <div className="col-md-12">
                          <div>
                            <p>Fecha de nacimiento <span className="campo-obligatorio">*</span></p>
                          </div>
                          <div>
                            <input type="date" className="form-control" value={register.fechaNacimiento} name="fechaNacimiento" placeholder="Escribe tu fecha de nacimiento" onChange={handleChange}/>
                            {errors.fechaNacimiento && <p className="text-danger">{errors.fechaNacimiento}</p>}
                          </div>
                        </div>
                      </div>
                      <div className="row p-2 align-items-center">
                        <div className="col-md-6">
                          <div>
                            <p>Rol <span className="campo-obligatorio">*</span></p>
                          </div>
                          <div>
                            <select className="form-control" id="asignRol" name="role" value={register.role} onChange={handleRoleChange}>
                              <option value="Paciente">Paciente</option>
                              <option value="Medico">Medico</option>
                            </select>
                            {errors.role && <p className="text-danger">{errors.role}</p>}
                          </div>
                        </div>
                        <div className="col-md-6">
                          <div>
                            <p>Genero <span className="campo-obligatorio">*</span></p>
                          </div>
                          <div className="col-lg-5 d-flex">
                            <div className="form-check">
                            <input className="form-check-input" type="radio" name="gender" id="female" value="Mujer" onChange={handleChange} checked={register.gender == "Mujer"}/>
                              <label className="form-check-label" htmlFor="female">Mujer</label>
                            </div>
                            <div className="form-check mx-3">
                            <input className="form-check-input" type="radio" name="gender" id="male" value="Hombre" onChange={handleChange} checked={register.gender == "Hombre"}/>
                              <label className="form-check-label" htmlFor="male">Hombre</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div className="row p-2">
                        <div className="col-md-12 p-2">
                          <div>
                            <p>Foto de perfil</p>
                          </div>
                          <div>
                              <input type="file" className="form-control" name="perfil" value="" onChange={(e) => handlePerfilChange(e)}/>
                              <span className='d-block mt-3'>Imagen seleccionada: {register.perfilName}</span>
                          </div>
                        </div>
                      </div>
                      <div className="row p-2">
                        <div className="col-md-12 p-2">
                          <div>
                            <p>Telefonos <span className="campo-obligatorio">*</span></p>
                          </div>
                          <div>
                            {register.telefonos.map((telefono, index) => (
                              <div className='d-inline-flex' key={index}>
                                <input
                                  type="text" className="form-control" name="telefono" placeholder="Teléfono" value={telefono.telefono} onChange={(e) => handleTelefonoChange(index, e.target.value)}/>
                                  <i onClick={() => removeTelefono(index)} className="btn btn-danger mb-2 ms-2 fa-solid fa-trash"></i>
                              </div>
                            ))}
                            {errors.telefonos && <p className="text-danger">{errors.telefonos}</p>}
                            <i onClick={addTelefono} className="btn btn-success mb-2 ms-2 fa-solid fa-upload"></i>
                          </div>
                        </div>
                      </div>
                      <div className="row p-2">
                        <div className="col-md-12 p-2">
                          <div>
                            <p>Correos Electrónicos <span className="campo-obligatorio">*</span></p>
                          </div>
                          <div>
                            {register.correos.map((correo, index) => (
                              <div className='d-inline-flex' key={index}>
                                <input type="text" className="form-control" name="correo" placeholder="Correo Electrónico" value={correo.correo} onChange={(e) => handleCorreoChange(index, e.target.value)}/>
                                <i onClick={() => removeCorreo(index)} className="btn btn-danger mb-2 ms-2 fa-solid fa-trash"></i>
                              </div>
                            ))}
                            <i onClick={addCorreo} className="btn btn-success mb-2 ms-2 fa-solid fa-upload"></i>
                            {errors.correos && <p className="text-danger">{errors.correos}</p>}
                          </div>
                        </div>
                      </div>
                      <div className="row p-2">
                        <div className="d-flex justify-content-center gap-3">
                          <a className="btn btn-primary link-button btn-dark-blue" href='/login'>
                            <span className="fa-solid fa-right-from-bracket me-2" aria-hidden="true" style={{transform: 'rotate(180deg)'}}></span>
                            Volver a login
                          </a>
                          <button type="button" className="btn btn-secondary" onClick={prevStep}>
                            <span className="fa-solid fa-right-from-bracket me-2" aria-hidden="true" style={{transform: 'rotate(180deg)'}}></span>
                            Atrás
                          </button>
                          <button type="button" className="btn btn-primary" onClick={nextStep}>
                            Siguiente
                            <span className="fa-solid fa-right-from-bracket ms-2" aria-hidden="true"></span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </>
        );
      case 3:
        return (
          <>
            <div className="account-pages align-center">
              <div className="container-fluid d-flex justify-content-center align-items-center">
                <div className="card card-autenticacion overflow-hidden">
                  <div className="bg-primary-subtle">
                    <div className="row">
                        <div className="col-12 text-center">
                            <div className="text-primary p-4">
                                <h5 className="text-primary">Healthub - Registro</h5>
                                <p>Registrarse en la aplicación</p>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div className="card-body pt-0">
                    <div className="formulario-autenticacion p-2">
                      <div className="row p-2">
                        <div className="col-md-6">
                          <div>
                            <p>Ciudad</p>
                          </div>
                          <div>
                            <input type="text" className="form-control" name="ciudad" value={register.ciudad} placeholder="Mataró" onChange={handleChange} />
                            {errors.ciudad && <p className="text-danger">{errors.ciudad}</p>}
                          </div>
                        </div>
                        <div className="col-md-6">
                          <div>
                            <p>Código postal</p>
                          </div>
                          <div>
                            <input type="text" className="form-control" name="codigoPostal" value={register.codigoPostal} placeholder="08304" onChange={handleChange} />
                            {errors.codigoPostal && <p className="text-danger">{errors.codigoPostal}</p>}
                          </div>
                        </div>
                      </div>
                      <div className="row p-2">
                        <div className='col-md-12'>
                          <p>Dirección</p>
                        </div>
                        <div className="col-md-4">
                          <div>
                            <input type="text" className="form-control" placeholder="Calle" value={register.calle} name="calle" onChange={handleChange} />
                            {errors.calle && <p className="text-danger">{errors.calle}</p>}
                          </div>
                        </div>
                        <div className="col-md-4">
                          <div>
                            <input type="text" className="form-control" placeholder="Piso" value={register.piso} name="piso" onChange={handleChange} />
                            {errors.piso && <p className="text-danger">{errors.piso}</p>}
                          </div>
                        </div>
                        <div className="col-md-4">
                          <div>
                            <input type="text" className="form-control" placeholder="Número" value={register.numero} name="numero" onChange={handleChange} />
                            {errors.numero && <p className="text-danger">{errors.numero}</p>}
                          </div>
                        </div>
                      </div>
                      <div className="row p-2">
                        <div>
                          <p>Personas de contacto</p>
                        </div>
                        {register.personaContacto.map((persona, index) => (
                          <div className="col-lg-7" key={index}>
                            <input type="text" className="form-control mb-2" placeholder="Nombre" name="nombreContacte" value={persona.nombreContacte} onChange={(e) => handlePersonaContactoChange(index, e)}/>
                            <input type="text" className="form-control mb-2" placeholder="Teléfono" name="telefono" value={persona.telefono} onChange={(e) => handlePersonaContactoChange(index, e)}/>
                            <input type="text" className="form-control mb-2" placeholder="Email" name="email" value={persona.email} onChange={(e) => handlePersonaContactoChange(index, e)}/>
                            <i onClick={() => removePersonaContacto(index)} className="btn btn-danger mb-2 fa-solid fa-trash"></i>
                          </div>
                        ))}
                        <div className="col-lg-7 mb-2">
                          <i onClick={addPersonaContacto} className="btn btn-success fa-solid fa-upload"></i>
                        </div>
                      </div>
                      <div className="row p-2">
                        <div className="d-flex justify-content-center gap-3">
                          <a className="btn btn-primary link-button btn-dark-blue" href='/login'>
                            <span className="fa-solid fa-right-from-bracket me-2" aria-hidden="true" style={{transform: 'rotate(180deg)'}}></span>
                            Volver a login
                          </a>
                          <button type="button" className="btn btn-secondary" onClick={prevStep}>
                            <span className="fa-solid fa-right-from-bracket me-2" aria-hidden="true" style={{transform: 'rotate(180deg)'}}></span>
                            Atrás
                          </button>
                          <button type="button" className="btn btn-primary" onClick={handleSubmit}>Registrarme</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </>
        );
      default:
        return null;
    }
  };

  return (
    <div className="account-pages align-center">
      <div className="container-fluid d-flex justify-content-center align-items-center">
        <form className="p-4 m-auto">
          {renderStep()}
        </form>
        </div>
    </div>
  );
}

const register = document.getElementById("register");
if (register) {
  const Index = createRoot(register);

  Index.render(
    <React.StrictMode>
      <Register />
    </React.StrictMode>
  );
}