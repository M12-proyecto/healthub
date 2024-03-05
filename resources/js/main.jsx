import ReactDOM from 'react-dom';
import App from './App.jsx'
import './index.css'

if (document.getElementById('welcome')) {
  const Index = ReactDOM.createRoot(document.getElementById('welcome'));
  Index.render(
      <React.StrictMode>
          <App/>
      </React.StrictMode>
  )
}