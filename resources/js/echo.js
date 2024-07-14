import Echo from "laravel-echo";
import { Howl, Howler } from "howler";

import Pusher from "pusher-js";
// import Reverb from "reverb-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
    enabledTransports: ["ws", "wss"],
    authEndpoint: "/broadcasting/auth",
    auth: {
        headers: {
            Authorization: "Bearer" + localStorage.getItem("token"),
        },
    },
});

document.addEventListener("DOMContentLoaded", () => {
    let alertBox = document.getElementById("notification");
    let alertMessage = document.getElementById("notification-message");
    let sender = document.getElementById("notificationSender");
    let message = document.getElementById("notificationMessage");
    let sendAt = document.getElementById("notificationSendAt");
    let closeNotification = document.getElementById("close-notification");

    // if (Notification.permission !== "granted") {
    //     Notification.requestPermission();
    // }

    Livewire.on("showAlert", (event) => {
        console.log(event);
        sender.textContent = event.detail.username;
        message.textContent = event.detail.content;
        sendAt.textContent = event.detail.created_at;
        alertBox.classList.remove("hidden");

        setTimeout(() => {
            alertBox.classList.add("hidden");
        }, 5000);

        new Notification("New Message", {
            body: event.message,
        });
    });

    Livewire.on("playNotificationSound", () => {
        const sound = new Howl({
            src: ["/storage/sound/Notifikasi_chat.mp3"],
            autoplay: true,
            volume: 1.0,
        });
        sound.play();
    });

    closeNotification.addEventListener("click", () => {
        alertBox.classList.add("hidden");
    });
});
