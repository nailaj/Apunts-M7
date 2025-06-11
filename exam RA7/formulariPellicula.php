<?php
include("includes/head.html");
include("includes/menu.php");
?>

<div class="container">
    <h3 id="titolForm">Nova pel·lícula</h3>
    <form id="formPeli">
        <input type="hidden" id="pel_id" name="pel_id" />
        <div>
            <label for="pel_titol">Títol:</label>
            <input type="text" id="pel_titol" name="pel_titol" required />
        </div>
        <div>
            <label for="pel_director">Director:</label>
            <input type="text" id="pel_director" name="pel_director" />
        </div>
        <div>
            <label for="pel_protagonista">Protagonista:</label>
            <input type="text" id="pel_protagonista" name="pel_protagonista" />
        </div>
        <div>
            <label for="pel_any">Any:</label>
            <input type="number" id="pel_any" name="pel_any" required min="1900" max="2100" />
        </div>
        <div>
            <label for="pel_puntuacio">Puntuació:</label>
            <input type="number" id="pel_puntuacio" name="pel_puntuacio" step="0.1" min="0" max="10" />
        </div>
        <div>
            <label for="pel_conceptes">Conceptes:</label>
            <input type="number" id="pel_conceptes" name="pel_conceptes" min="0" max="1" />
        </div>
        <div>
            <label for="gen_id">Gènere:</label>
            <select id="gen_id" name="gen_id" required>
                <option value="">Carregant...</option>
            </select>
        </div>
        <button type="submit" id="btnGuardar">Desar</button>
        <a href="gestionarPellicules.php">Cancel·lar</a>
    </form>
    <div id="missatge"></div>
</div>

<script>
const params = new URLSearchParams(window.location.search);
const id = params.get('id');

function carregaGeneres(genIdSeleccionat = '') {
    fetch('api/generes.php')
        .then(r => r.json())
        .then(generes => {
            const select = document.getElementById('gen_id');
            select.innerHTML = '<option value="">-- Escull un gènere --</option>';
            generes.forEach(g => {
                const opt = document.createElement('option');
                opt.value = g.gen_id;
                opt.textContent = g.gen_nom;
                if (genIdSeleccionat && g.gen_id == genIdSeleccionat) {
                    opt.selected = true;
                }
                select.appendChild(opt);
            });
        })
        .catch(() => {
            document.getElementById('missatge').textContent = 'Error en carregar els gèneres.';
        });
}

if (id) {
    document.getElementById('titolForm').textContent = "Modificar pel·lícula";
    fetch('api/pellicules.php?id=' + encodeURIComponent(id))
        .then(r => r.json())
        .then(peli => {
            if (peli && !peli.error) {
                document.getElementById('pel_id').value = peli.pel_id;
                document.getElementById('pel_titol').value = peli.pel_titol;
                document.getElementById('pel_director').value = peli.pel_director || '';
                document.getElementById('pel_protagonista').value = peli.pel_protagonista || '';
                document.getElementById('pel_any').value = peli.pel_any;
                document.getElementById('pel_puntuacio').value = peli.pel_puntuacio || '';
                document.getElementById('pel_conceptes').value = peli.pel_conceptes || '';
                carregaGeneres(peli.gen_id);
            } else {
                document.getElementById('missatge').textContent = "No s'ha trobat la pel·lícula.";
                document.getElementById('formPeli').style.display = 'none';
            }
        })
        .catch(() => {
            document.getElementById('missatge').textContent = 'Error en carregar la pel·lícula.';
        });
} else {
    carregaGeneres();
}

document.getElementById('formPeli').addEventListener('submit', function(e) {
    e.preventDefault();
    const dades = {
        pel_titol: document.getElementById('pel_titol').value,
        pel_director: document.getElementById('pel_director').value || null,
        pel_protagonista: document.getElementById('pel_protagonista').value || null,
        pel_any: parseInt(document.getElementById('pel_any').value),
        pel_puntuacio: parseFloat(document.getElementById('pel_puntuacio').value) || null,
        pel_conceptes: parseInt(document.getElementById('pel_conceptes').value) || null,
        gen_id: parseInt(document.getElementById('gen_id').value)
    };
    const pel_id = document.getElementById('pel_id').value;

    let url = 'api/pellicules.php';
    let method = 'POST';
    if (pel_id) {
        url += '?id=' + encodeURIComponent(pel_id);
        method = 'PUT';
    }

    fetch(url, {
        method: method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dades)
    })
    .then(r => r.json())
    .then(result => {
        if (result.success) {
            window.location.href = 'gestionarPellicules.php';
        } else {
            document.getElementById('missatge').textContent = result.error || 'Error en desar la pel·lícula.';
        }
    })
    .catch(() => {
        document.getElementById('missatge').textContent = 'Error en desar la pel·lícula.';
    });
});
</script>

<?php
include("includes/foot.html");
?>