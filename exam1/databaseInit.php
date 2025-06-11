<?php
$db = new SQLite3('database/Volta2026.db');

$db->exec("CREATE TABLE IF NOT EXISTS corredors (
    cor_id INTEGER PRIMARY KEY AUTOINCREMENT,
    cor_nom TEXT NOT NULL,
    cor_cognoms TEXT NOT NULL,
    cor_equip TEXT NOT NULL,
    cor_nacionalitat TEXT NOT NULL,
    cor_edat INTEGER NOT NULL,
    cor_foto TEXT
)");

$db->exec("INSERT INTO corredors (cor_nom, cor_cognoms, cor_equip, cor_nacionalitat, cor_edat, cor_foto) VALUES
    ('Primož', 'Roglič', 'Red Bull - BORA - hansgrohe', 'Eslovènia', 36, 'https://www.procyclingstats.com/images/riders/bp/cc/primoz-roglic-2025.jpg'),
    ('Jonas', 'Vingegaard', 'Team Visma | Lease a Bike', 'Dinamarca', 28, 'https://www.procyclingstats.com/images/riders/bp/ea/jonas-vingegaard-2025.png'),
    ('Geraint', 'Thomas', 'INEOS Grenadiers', 'Regne Unit', 39, 'https://www.procyclingstats.com/images/riders/bp/dd/geraint-thomas-2025.jpg'),
    ('Mikel', 'Landa', 'Soudal Quick-Step', 'Espanya', 35, 'https://www.procyclingstats.com/images/riders/bp/bf/mikel-landa-2025.jpeg'),
    ('Mathieu', 'van der Poel', 'Alpecin - Deceuninck', 'Països Baixos', 30, 'https://www.procyclingstats.com/images/riders/bp/dc/mathieu-van-der-poel-2024.jpeg'),
    ('Wout', 'Van Aert', 'Team Visma | Lease a Bike', 'Bèlgica', 31, 'https://www.procyclingstats.com/images/riders/bp/ea/wout-van-aert-2025.png'),
    ('Tadej', 'Pogačar', 'UAE Team Emirates - XRG', 'Eslovènia', 27, 'https://www.procyclingstats.com/images/riders/bp/dc/tadej-pogacar-2025.jpg'),
    ('Mads', 'Pedersen', 'Lidl-Trek', 'Dinamarca', 29, 'https://www.procyclingstats.com/images/riders/bp/ca/mads-pedersen-2025.jpeg'),
    ('Guillaume', 'Martin', 'Groupama - FDJ', 'França', 32, 'https://www.procyclingstats.com/images/riders/bp/ae/guillaume-martin-2025.jpeg'),
    ('Felix', 'Gall', 'Decathlon AG2R La Mondiale Team', 'Àustria', 27, 'https://www.procyclingstats.com/images/riders/bp/fa/felix-gall-2025.jpg')
");

$db->close();
?>