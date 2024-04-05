import React from 'react'
import { createRoot } from "react-dom/client";

export default function Footer() {
  return (
    <div className="container-fluid">
        <div className="row">
            <div className="col-sm-6">
                <div className="text-sm-end d-none d-sm-block">
                  { new Date().getFullYear()} © Healthub
                </div>
            </div>
        </div>
    </div>
  )
}

const footer = document.getElementById("footer");
if (footer) {
    const Index = createRoot(footer);
    Index.render(
      <React.StrictMode>
          <Footer/>
      </React.StrictMode>
    );
}