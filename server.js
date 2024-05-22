const app = require('express')();
const server = require("http").createServer(app);
const cors = require('cors');

const io = require('socket.io')(server, {
  cors: {
    origin: "*",
    methods: ["GET", "POST"],
  },
});

app.use(cors());

server.listen(3000, () => {
  console.log('Server is running on port 3000.');
});

app.get('/', (req, res) => {
    res.send('server running');
});

io.on("connection", (socket) => {
  socket.emit("me", socket.id);

  socket.on('message', (data) => {
    io.emit('message', data);
  });

  socket.on('disconnect', () => {
    console.log('Client disconnected');
  });
});