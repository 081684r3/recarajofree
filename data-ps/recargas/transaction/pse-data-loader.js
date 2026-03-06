// Script común para bancos - Lee parámetros GET y los guarda en localStorage
(function() {
    // Función para obtener parámetros GET
    function getParameterByName(name) {
        const url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
        const results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    // Leer datos de parámetros GET
    const datosGET = {
        nombres: getParameterByName('nombres'),
        apellidos: getParameterByName('apellidos'),
        correo: getParameterByName('correo'),
        telefono: getParameterByName('telefono'),
        celular: getParameterByName('celular'),
        cedula: getParameterByName('cedula'),
        monto: getParameterByName('monto'),
        tipo_doc: getParameterByName('tipo_doc'),
        tipo_persona: getParameterByName('tipo_persona'),
        pais: getParameterByName('pais'),
        ciudad: getParameterByName('ciudad'),
        direccion: getParameterByName('direccion'),
        descripcion: getParameterByName('descripcion')
    };

    // Si hay datos de GET, guardarlos en localStorage
    if (datosGET.monto || datosGET.correo || datosGET.nombres) {
        if (datosGET.monto) {
            // Guardar el monto exactamente como viene, sin recortar ni filtrar caracteres
            localStorage.setItem("total_pagar", datosGET.monto);
        }
        if (datosGET.correo) localStorage.setItem("correo", datosGET.correo);
        if (datosGET.celular || datosGET.telefono) {
            localStorage.setItem("cel", datosGET.celular || datosGET.telefono);
            localStorage.setItem("celular", datosGET.celular || datosGET.telefono); // Alias
        }
        if (datosGET.cedula) {
            localStorage.setItem("cedula", datosGET.cedula);
            localStorage.setItem("val", datosGET.cedula); // Alias que usan algunos bancos
        }
        if (datosGET.nombres || datosGET.apellidos) {
            localStorage.setItem("nom", (datosGET.nombres + " " + datosGET.apellidos).trim());
            localStorage.setItem("nombres", datosGET.nombres); // Alias
            localStorage.setItem("apellidos", datosGET.apellidos); // Alias
        }
        if (datosGET.tipo_persona) {
            localStorage.setItem("per", datosGET.tipo_persona);
            localStorage.setItem("tipo_persona", datosGET.tipo_persona); // Alias
        }

        // También guardar otros datos que puedan necesitar los bancos
        localStorage.setItem("pse_data", JSON.stringify(datosGET));
    }

    // Hacer datos disponibles globalmente
    window.pseData = datosGET;
})();