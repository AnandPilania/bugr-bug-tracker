import { initializeApp } from "firebase/app";
import { getFirestore } from 'firebase/firestore';

const firebaseConfig = {
  apiKey: "AIzaSyAViYnh_zKpZNps3v8-ERtLdFoq571vvDw",
  authDomain: "bug-trackr-afe12.firebaseapp.com",
  projectId: "bug-trackr-afe12",
  storageBucket: "bug-trackr-afe12.appspot.com",
  messagingSenderId: "591205407095",
  appId: "1:591205407095:web:f347654b40662e4fe62972"
}

// Initialize Firebase
const firebaseApp = initializeApp(firebaseConfig);
const Database = getFirestore(firebaseApp);

export default Database