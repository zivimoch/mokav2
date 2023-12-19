const express = require("express");

const app = express();
const server = require("http").createServer(app);
const io = require("socket.io")(server, {
    cors: { origin: "*" },
});

io.on("connection", (socket) => {
    socket.on("join_room", function (data) {
        socket.join(data.room + data.id_room);
        console.log("join room " + data.room + data.id_room);
    });

    //send notif
    socket.on("notif_count", (data) => {
        // io.sockets.to('user_' + data.receiver_id).emit('notif_count', data);
        [data.receiver_id].forEach(function (room) {
            io.sockets.in(room).emit("notif_count", data);
        });
    });

    socket.on("disconnect", (socket) => {
        console.log("disconnect");
    });
});

server.listen(3000, () => {
    console.log("Server is running");
});
