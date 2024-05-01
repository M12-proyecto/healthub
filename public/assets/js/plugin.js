(function() {
    "use strict";

    // Verifica si el navegador admite sessionStorage y localStorage
    if (window.sessionStorage && window.localStorage) {
        var mode = sessionStorage.getItem("is_visited");
        if (mode) {
            switch (mode) {
                case "light-mode-switch":
                    updateStyles("light", false);
                    break;
                case "dark-mode-switch":
                    updateStyles("dark", false);
                    break;
                case "rtl-mode-switch":
                    updateStyles("light", true);
                    break;
                case "dark-rtl-mode-switch":
                    updateStyles("dark", true);
                    break;
                default:
                    console.log("Algo está mal con el modo de diseño.");
            }
        }
    }

    // Función para actualizar los estilos y guardar la opción en localStorage
    function updateStyles(theme, isRTL) {
        document.documentElement.removeAttribute("dir");
        document.documentElement.setAttribute("data-bs-theme", theme);
        if (isRTL) {
            document.documentElement.setAttribute("dir", "rtl");
        }
        localStorage.setItem("layout_mode", mode);
    }
})();
