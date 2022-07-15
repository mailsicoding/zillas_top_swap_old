// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getDatabase } from "firebase/database";

// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyCQVuL32-AvGGs3wQtYwkLDg4n6DeES62c",
  authDomain: "zillarepo.firebaseapp.com",
  databaseURL: "https://zillarepo-default-rtdb.firebaseio.com",
  projectId: "zillarepo",
  storageBucket: "zillarepo.appspot.com",
  messagingSenderId: "981605448608",
  appId: "1:981605448608:web:b93ee0ef67105dbd5fc2c5",
  measurementId: "G-3H3N53G6S9"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const database = getDatabase();

export default app;