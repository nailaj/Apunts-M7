<?php
include("includes/head.html");
include("includes/menu.php");
?>

<div class="container">
    <h3>LLISTA DE PEL·LÍCULES</h3>
    <ul class="pellicules" id="llistaPellicules">
        <li>Carregant pel·lícules...</li>
    </ul>
</div>

<script>
const params = new URLSearchParams(window.location.search);
const genId = params.get('gen_id');

let url = 'api/pellicules.php';
if (genId) {
    url += '?gen_id=' + encodeURIComponent(genId);
}

fetch(url)
    .then(response => response.json())
    .then(pellicules => {
        const llista = document.getElementById('llistaPellicules');
        llista.innerHTML = '';

        if (!pellicules.length) {
            llista.innerHTML = '<li>No hi ha pel·lícules per a aquest gènere.</li>';
            return;
        }

        pellicules.forEach(peli => {
            const li = document.createElement('li');
            li.innerHTML = `
                <strong>${peli.pel_titol}</strong> (${peli.pel_any}) - ${peli.gen_nom}
            `;
            llista.appendChild(li);
        });
    })
    .catch(error => {
        document.getElementById('llistaPellicules').innerHTML = '<li>Error en carregar les pel·lícules.</li>';
        console.error('Error:', error);
    });
</script>

<?php
include("includes/foot.html");
?>