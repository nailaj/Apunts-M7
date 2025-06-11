<?php
include("includes/head.html");
include("includes/menu.php");
?>

<div class="container">
    <h3>GÈNERES</h3>
    <ul class="generes" id="llistaGeneres">
        <li>Carregant gèneres...</li>
    </ul>
</div>

<script>
fetch('api/generes.php')
    .then(response => response.json())
    .then(generes => {
        const llista = document.getElementById('llistaGeneres');
        llista.innerHTML = '';
        if (!generes.length) {
            llista.innerHTML = '<li>No hi ha gèneres disponibles.</li>';
            return;
        }
        generes.forEach(genere => {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = 'veurePellicules.php?gen_id=' + encodeURIComponent(genere.gen_id);
            a.textContent = genere.gen_nom;
            li.appendChild(a);
            llista.appendChild(li);
        });
    })
    .catch(error => {
        document.getElementById('llistaGeneres').innerHTML = '<li>Error en carregar els gèneres.</li>';
        console.error('Error:', error);
    });
</script>

<?php
include("includes/foot.html");
?>