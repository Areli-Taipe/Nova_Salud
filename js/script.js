document.addEventListener("DOMContentLoaded", () => {
    const formRegistro = document.getElementById("formRegistro");

    if (formRegistro) {
        formRegistro.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(formRegistro);

            fetch("php/crear.php", {
                method: "POST",
                body: formData,
            })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert("❌ " + data.mensaje);
                    } else {
                        alert("✅ " + data.mensaje);
                        formRegistro.reset();
                        // Solo recargar tabla si estamos en CRUD
                        if (window.location.pathname.includes("crud.html")) {
                            cargarUsuarios();
                        }
                    }
                })
                .catch(err => {
                    console.error("Error:", err);
                    alert("❌ Error en la conexión con el servidor.");
                });
        });
    }

    // Solo si estamos en crud.html, cargamos los usuarios
    if (window.location.pathname.includes("crud.html")) {
        cargarUsuarios();
    }
});

function cargarUsuarios() {
    fetch('php/leer.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert("❌ Error al cargar usuarios");
                return;
            }

            const tbody = document.getElementById('tbodyUsuarios');
            if (!tbody) {
                console.warn("⚠️ tbodyUsuarios no encontrado en el DOM.");
                return;
            }

            tbody.innerHTML = '';

            data.usuarios.forEach(usuario => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${usuario.id}</td>
                    <td>${usuario.correo}</td>
                    <td>${usuario.usuario}</td>
                    <td>${usuario.telefono}</td>
                    <td>${usuario.direccion}</td>
                    <td>${usuario.edad}</td>
                    <td class="space-x-2">
                        <button onclick="actualizarUsuario(${usuario.id})" title="Actualizar">✏️</button>
                        <button onclick="eliminarUsuario(${usuario.id})" title="Eliminar">🗑️</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        })
        .catch(err => {
            console.error("Error al cargar usuarios:", err);
        });
}

function eliminarUsuario(id) {
    if (confirm("¿Estás seguro de eliminar este usuario?")) {
        fetch('php/eliminar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}`
        })
            .then(res => res.json())
            .then(data => {
                if (!data.error) {
                    alert("✅ Usuario eliminado");
                    cargarUsuarios();
                } else {
                    alert("❌ " + data.mensaje);
                }
            });
    }
}

function actualizarUsuario(id) {
    // Buscar los datos actuales del usuario por su ID
    fetch(`php/leer.php`)
        .then(res => res.json())
        .then(data => {
            const usuario = data.usuarios.find(u => u.id == id);
            if (!usuario) {
                alert("Usuario no encontrado");
                return;
            }

            document.getElementById('actualizar_id').value = usuario.id;
            document.getElementById('actualizar_correo').value = usuario.correo;
            document.getElementById('actualizar_usuario').value = usuario.usuario;
            document.getElementById('actualizar_telefono').value = usuario.telefono;
            document.getElementById('actualizar_direccion').value = usuario.direccion;
            document.getElementById('actualizar_edad').value = usuario.edad;

            document.getElementById('modalActualizar').classList.remove('hidden');
        });
}

// Cerrar modal
function cerrarModal() {
    document.getElementById('modalActualizar').classList.add('hidden');
}

const formActualizar = document.getElementById('formActualizar');
if (formActualizar) {
    formActualizar.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new URLSearchParams();
        formData.append('id', document.getElementById('actualizar_id').value);
        formData.append('correo', document.getElementById('actualizar_correo').value);
        formData.append('usuario', document.getElementById('actualizar_usuario').value);
        formData.append('telefono', document.getElementById('actualizar_telefono').value);
        formData.append('direccion', document.getElementById('actualizar_direccion').value);
        formData.append('edad', document.getElementById('actualizar_edad').value);

        fetch('php/actualizar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formData.toString()
        })
            .then(res => res.json())
            .then(data => {
                if (!data.error) {
                    alert("✅ " + data.mensaje);
                    cerrarModal();
                    cargarUsuarios(); // Recargar tabla
                } else {
                    alert("❌ " + data.mensaje);
                }
            })
            .catch(async err => {
                const responseText = await err.text?.();
                console.error("Respuesta no válida:", responseText || err);
                alert("❌ La respuesta no fue JSON válido.");
            });            
    });
}