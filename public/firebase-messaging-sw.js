importScripts("https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js");

firebase.initializeApp({
  apiKey: "AIzaSyA-QBqdIO6R93OTvYfo5P0_lkegBQFByNg",
  authDomain: "lieferfood-38eaf.firebaseapp.com",
  projectId: "lieferfood-38eaf",
  storageBucket: "lieferfood-38eaf.firebasestorage.app",
  messagingSenderId: "64404788496",
  appId: "1:64404788496:web:0e25cca1dd530f02e40195"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
  self.registration.showNotification(
    payload.notification.title,
    {
      body: payload.notification.body,
      icon: "/app.png",
    }
  );
});
