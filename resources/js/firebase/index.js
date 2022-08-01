// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getDatabase } from "firebase/database";

// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyD9WeWLE4db7royRyBMB_dO0FejZZhrFYE",
    authDomain: "christophergame.firebaseapp.com",
    databaseURL: "https://christophergame-default-rtdb.firebaseio.com",
    projectId: "christophergame",
    storageBucket: "christophergame.appspot.com",
    messagingSenderId: "1026538262278",
    appId: "1:1026538262278:web:7c987548a975bc23f41887",
    measurementId: "G-LGCKH41MYM"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const database = getDatabase();

export default app;
