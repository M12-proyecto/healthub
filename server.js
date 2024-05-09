const express = require('express');
const http = require('http');
const app = express();
const servidor = http.createServer(app);
const socketIo = require('socket.io');
const io = socketIo(servidor, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

app.get('/', function(req, res) {
    res.send('Servidor express corriendo');
});

io.on('connection', socket => {
    // Lógica del chat en tiempo real
    socket.on('conectado', (dataName) => {
        // Notificar a todos los clientes que un usuario se ha conectado
        io.emit('mensajes', {
            nombre: dataName,
            mensaje: `${dataName} ha entrado a la sala del chat`
        });
    });

    socket.on('mensaje', (nombre, mensaje) => {
        // Emitir el mensaje a todos los clientes conectados
        io.emit('mensajes', { nombre, mensaje });
    });

    socket.on('disconnect', () => {
        // Lógica para manejar la desconexión del cliente
    });
});

servidor.listen(4000, () => console.log('Servidor funcionando en el puerto 4000'));
