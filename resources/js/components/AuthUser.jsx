import React, { useState } from "react";  
import axios from 'axios';

export default function AuthUser() {
    // Declara las funciones getToken, getUser y getRol antes de usarlas
    const getToken = () =>{
        const tokenString = sessionStorage.getItem('token');
        const userToken = JSON.parse(tokenString);
        return userToken;
    }

    const getUser = () =>{
        const userString = sessionStorage.getItem('user');
        const user_detail = JSON.parse(userString);
        return user_detail;
    }

    const getRol = () =>{
        const rolString = sessionStorage.getItem('rol');
        const rol = JSON.parse(rolString);
        return rol;
    }

    // Inicializa el estado después de declarar las funciones
    const [token,setToken] = useState(getToken());
    const [user,setUser] = useState(getUser());
    const [rol,setRol] = useState(getRol());

    const saveToken = (user, token, rol) =>{
        sessionStorage.setItem('token',JSON.stringify(token));
        sessionStorage.setItem('user',JSON.stringify(user));
        sessionStorage.setItem('rol',JSON.stringify(rol));

        setToken(token);
        setUser(user);
        setRol(rol);

        if(rol === 'admin'){
            // Hacer algo para el rol de admin
        } else if(rol === 'paciente') {
            // Hacer algo para el rol de paciente
        } else if(rol === 'medico') {
            // Hacer algo para el rol de médico
        }

        // Redirigir a la ruta '/home'
        window.location.href = 'http://localhost:8000/home';
    }

    const getLogout = () => {
        sessionStorage.clear();
    }

    const http = axios.create({
        baseURL:"http://localhost:8000/api",
        headers:{
            "Content-type" : "application/json",
            "Authorization" : `Bearer ${token}`
        }
    });
    
    return {
        setToken:saveToken,
        token,
        user,
        getToken,
        getRol,
        getUser,
        getLogout,
    }
}