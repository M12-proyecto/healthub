import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Login from './components/Login/Login';
import Register from './components/Register/Register';

const App = () => {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />
    </Routes>
  );
};

export default App;

if (document.getElementById('welcome')) {
    const Index = ReactDOM.createRoot(document.getElementById('welcome'));

    Index.render(
        <React.StrictMode>
            <App/>
        </React.StrictMode>
    )
}