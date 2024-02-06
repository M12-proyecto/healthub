import React from "react";
import { createRoot } from 'react-dom/client'

export default function Home() {
    return (
        <div>Proyecto Healhub Reacjs</div>
    );
}

if(document.getElementById('root')){
    createRoot(document.getElementById('root')).render(<Home/>)
}