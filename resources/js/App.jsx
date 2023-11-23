import React from 'react'
import ReactDOM from 'react-dom/client';
import 'bootstrap/dist/css/bootstrap.min.css'

const App = () => {
  return (
    <div>
        <span>App base healthub!</span>
    </div>
  )
}

export default App

if (document.getElementById('example')) {
    const Index = ReactDOM.createRoot(document.getElementById("example"));

    Index.render(
        <React.StrictMode>
            <App/>
        </React.StrictMode>
    )
}
