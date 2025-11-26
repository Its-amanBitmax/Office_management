import { Server } from "socket.io";

const io = new Server(3000, {
  cors: {
    origin: "*",  // Allow all origins, adjust for production
    methods: ["GET", "POST"]
  }
});

io.on("connection", (socket) => {
  console.log("Client connected:", socket.id);

  socket.on("joinRoom", ({ room }) => {
    console.log(`Socket ${socket.id} joining room: ${room}`);
    socket.join(room);
  });

  socket.on("SignalingMessageBroadcast", (message) => {
    // Relay the signaling message to other clients in the same room
    const rooms = Array.from(socket.rooms).filter(r => r !== socket.id);
    rooms.forEach(room => {
      console.log(`Broadcasting signaling message to room ${room}:`, message);
      socket.to(room).emit("SignalingMessageBroadcast", message);
    });
  });

  socket.on("disconnect", () => {
    console.log("Client disconnected:", socket.id);
  });
});

console.log('Socket.io signaling server running on port 3000');
