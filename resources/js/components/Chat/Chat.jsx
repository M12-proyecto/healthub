import React, { useEffect, useRef, useState } from 'react';
import { createRoot } from 'react-dom/client';
import io from 'socket.io-client';
import axios from 'axios';
import './chat.module.css';

function Chat() {
  const [usuario, setUsuario] = useState('');
  const socket = useRef(null);
  const [mensaje, setMensaje] = useState('');
  const [chatHistory, setChatHistory] = useState([]);
  const [usuariosConectados, setUsuariosConectados] = useState([]);
  const [activeChat, setActiveChat] = useState(null);
  const [usuarioSelected, setUsuarioSelected] = useState([]);
  const [searchQuery, setSearchQuery] = useState('');

  // Obtener usuario del localStorage al cargar el componente
  useEffect(() => {
    const usuario = JSON.parse(document.getElementById('chat').getAttribute('data-usuario'));
    setUsuario(usuario);
  }, []);

  useEffect(() => {
    const usuariosData = JSON.parse(document.getElementById('chat').getAttribute('data-usuarios'));
    setUsuariosConectados(Object.values(usuariosData));
  }, []);

  useEffect(() => {
    socket.current = io('http://localhost:3000');

    // Evento para recibir mensajes desde el servidor
    socket.current.on('message', (data) => {
      setChatHistory(prevChats => [...prevChats, data]);
    });

    // Cada 5 segundos, actualizar los mensajes del chat
    const interval = setInterval(() => {
      if (activeChat) {
        fetchMessages(activeChat.id);
      }
    }, 1000);

    return () => {
      clearInterval(interval);
      socket.current.disconnect();
    };
  }, [activeChat]);

  const handleChange = (event) => {
    setMensaje(event.target.value);
  };

  const handleSearchChange = (event) => {
    setSearchQuery(event.target.value); // Update search query state
  };

  const filteredUsers = usuariosConectados.filter((user) =>
    user.nombre.toLowerCase().includes(searchQuery.toLowerCase())
  );

  const handleClickSendMessage = async () => {
    const now = new Date();
    const messageData = {
      chat_id: activeChat.id,
      usuario1: usuario.id,
      usuario2: activeChat.medico_id,
      mensaje: mensaje,
      fecha: now.toLocaleDateString('es-ES'),
      hora: now.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' })
    };
    
    // Emitir mensaje a través del socket
    socket.current.emit('message', messageData);
    
    // Guardar el mensaje en la base de datos
    try {
      const response = await axios.post('/chat/saveMessage', messageData);
      console.log(response.data.message); // Mensaje de éxito
    } catch (error) {
      console.error('Error al guardar el mensaje:', error);
    }

    setMensaje(''); // Limpiar el campo de mensaje después de enviar
  };

  const handleUserClick = async (usuarioSeleccionado) => {
    try {
      const response = await axios.post('/chat/startChat',{
        paciente_id: usuario.id,
        medico_id: usuarioSeleccionado.id
       });
      
      setActiveChat({ id: response.data.chat_id, medico_id: usuarioSeleccionado.id });
      fetchMessages(response.data.chat_id);
      setUsuarioSelected(usuarioSeleccionado);
    } catch (error) {
      console.error('Error al iniciar el chat:', error);
    }
  };

  const fetchMessages = async (chatId) => {
    try {
      const response = await axios.get(`/chat/getMessages/${chatId}`);
      setChatHistory(response.data);
    } catch (error) {
      console.error('Error al obtener los mensajes:', error);
    }
  };

  return (
    <div className="d-lg-flex d-sm-flex">
      <div className="chat-leftsidebar me-lg-4">
        <div className="">
          <div className="py-4 border-bottom">
            <div className="d-flex">
              <div className="flex-shrink-0 align-self-center me-3">
                <img src={usuario.foto ? usuario.foto : 'http://localhost:8000/assets/images/users/default.webp'} className="avatar-xs rounded-circle" alt="" />
              </div>
              <div className="flex-grow-1">
                <h5 className="font-size-15 mb-1">{ usuario.nombre } {usuario.apellido1} </h5>
                <p className="text-muted mb-0"><i className="mdi mdi-circle text-success align-middle me-1"></i> Active</p>
              </div>
            </div>
          </div>

          <div className="search-box chat-search-box py-4">
            <div className="position-relative">
              <input type="text" onChange={handleSearchChange} className="form-control" placeholder="Search..." />
              <i className="bx bx-search-alt search-icon"></i>
            </div>
          </div>

          <div className="chat-leftsidebar-nav">
            <ul className="nav nav-pills nav-justified">
              <li className="nav-item">
                <a href="#chat" data-bs-toggle="tab" aria-expanded="true" className="nav-link active">
                  <i className="bx bx-chat font-size-20 d-sm-none"></i>
                  <span className="d-none d-sm-block">Chat</span>
                </a>
              </li>
            </ul>
            <div className="tab-content py-4">

            {/* AQUI MOSTRAR LOS USUARIOS CONECTADOS  */}

              <div className="tab-pane show active" id="chat">
                <div>
                  <h5 className="font-size-14 mb-3">Recent</h5>
                
                  <ul className="list-unstyled chat-list" style={{ maxHeight: '410px' }}>
                  {filteredUsers.map((usuario) => (
                      <li key={usuario.id} className="active" onClick={() => handleUserClick(usuario)}>
                        <a href="#">
                          <div className="d-flex">
                            <div className="flex-shrink-0 align-self-center me-3">
                              <i className="mdi mdi-circle font-size-10"></i>
                            </div>
                            <div className="flex-shrink-0 align-self-center me-3">
                              <img src={usuario.foto ? usuario.foto : 'http://localhost:8000/assets/images/users/default.webp'} className="rounded-circle avatar-xs" alt="" />
                            </div>
                            <div className="flex-grow-1 overflow-hidden">
                              <h5 className="text-truncate font-size-14 mb-1">{usuario.nombre} {usuario.apellido1}</h5>
                              <p className="text-truncate mb-0"></p>
                            </div>
                            <div className="font-size-11">05 min</div>
                          </div>
                        </a>
                      </li>
                    ))}
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      { activeChat && (
      <div className="w-100 user-chat">
        <div className="card">
          <div className="p-4 border-bottom ">
            <div className="row">
              <div className="col-md-4 col-9">
                <h5 className="font-size-15 mb-1">{usuarioSelected.nombre} {usuarioSelected.apellido1}</h5>
                <p className="text-muted mb-0"><i className="mdi mdi-circle text-success align-middle me-1"></i> Active now</p>
              </div>
              <div className="col-md-8 col-3">
                <ul className="list-inline user-chat-nav text-end mb-0">
                  <li className="list-inline-item d-none d-sm-inline-block">
                  </li>
                  <li className="list-inline-item  d-none d-sm-inline-block">
                    <div className="dropdown">
                      <button className="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i className="bx bx-cog"></i>
                      </button>
                      <div className="dropdown-menu dropdown-menu-end">
                        <a className="dropdown-item" href="#">View Profile</a>
                        <a className="dropdown-item" href="#">Clear chat</a>
                        <a className="dropdown-item" href="#">Muted</a>
                        <a className="dropdown-item" href="#">Delete</a>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        
          <div>
             <div className="chat-conversation p-3" style={{ overflowY: 'auto', maxHeight: '486px' }}>
              <ul className="list-unstyled mb-0" data-simplebar style={{ maxHeight: '486px' }}>
                <li>
                  <div className="chat-day-title">
                    <span className="title">Today</span>
                  </div>
                </li>
                {chatHistory.map((chat, index) => (
                  <li key={index} className={chat.usuario1 === usuario.id ? 'right' : 'left'}>
                    <div className="conversation-list">
                      <div className="dropdown">
                        <a className="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i className="bx bx-dots-vertical-rounded"></i>
                        </a>
                        <div className="dropdown-menu">
                          <a className="dropdown-item" href="#">Copy</a>
                          <a className="dropdown-item" href="#">Save</a>
                          <a className="dropdown-item" href="#">Forward</a>
                          <a className="dropdown-item" href="#">Delete</a>
                        </div>
                      </div>
                      <div className="ctext-wrap">
                        <div className="conversation-name">
                          {chat.usuario1 === usuario.id ? `${usuario.nombre} ${usuario.apellido1}` : `${usuarioSelected.nombre} ${usuarioSelected.apellido1}`}
                        </div>
                        <p>{chat.mensaje}</p>
                        <p className="chat-time mb-0"><i className="bx bx-time-five align-middle me-1"></i>{chat.hora}</p>
                      </div>
                    </div>
                  </li>
                ))}

              </ul>
            </div>
            <div className="p-3 chat-input-section">
              <div className="row">
                <div className="col">
                  <input type="text" value={mensaje} onChange={handleChange} className="form-control form-control-lg bg-light border-light" placeholder="Enter Message..." />
                </div>
                <div className="col-auto">
                  <button type="button" onClick={handleClickSendMessage} className="btn btn-primary btn-lg">
                    <i className="bx bx-send"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      )}
    </div>
  );
}

export default Chat;

if (document.getElementById('chat')) {
  const root = createRoot(document.getElementById('chat'));
  root.render(<Chat />);
}
