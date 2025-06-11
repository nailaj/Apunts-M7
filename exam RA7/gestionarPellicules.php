<?php
include("includes/head.html");
include("includes/menu.php");
?>

<div class="container">
    <h3>GESTIONAR PEL·LÍCULES</h3>
    <a href="formulariPellicula.php" style="color:green;">Nova pel·lícula</a>
    <ul class="pellicules" id="llistaPellicules" style="margin-top:20px;">
        <li>Carregant pel·lícules...</li>
    </ul>
</div>

<script>
function carregaPellicules() {
    fetch('api/pellicules.php')
        .then(response => response.json())
        .then(pellicules => {
            const llista = document.getElementById('llistaPellicules');
            llista.innerHTML = '';

            if (!pellicules.length) {
                llista.innerHTML = '<li>No hi ha pel·lícules.</li>';
                return;
            }

            pellicules.forEach(peli => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <strong>${peli.pel_titol}</strong> (${peli.pel_any}) - ${peli.gen_nom}
                    <a href="formulariPellicula.php?id=${peli.pel_id}">Modificar</a>
                    <a href="#" onclick="eliminarPeli(${peli.pel_id});return false;" style="color:red;">Eliminar</a>
                `;
                llista.appendChild(li);
            });
        })
        .catch(error => {
            document.getElementById('llistaPellicules').innerHTML = '<li>Error en carregar les pel·lícules.</li>';
            console.error('Error:', error);
        });
}

function eliminarPeli(id) {
    if (confirm('Segur que vols eliminar aquesta pel·lícula?')) {
        fetch('api/pellicules.php?id=' + encodeURIComponent(id), {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                carregaPellicules();
            } else {
                alert('Error en eliminar la pel·lícula.');
            }
        })
        .catch(error => {
            alert('Error en eliminar la pel·lícula.');
            console.error('Error:', error);
        });
    }
}

carregaPellicules(); // Carrega les pel·lícules inicialment
</script>

<?php
include("includes/foot.html");
?>