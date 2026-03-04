# TimeGuessr

Clone du jeu TimeGuessr développé en PHP/HTML/CSS vanilla dans le cadre de l'examen final ESGI.

## Lancer le projet

### Prérequis
- PHP 8.1+
- MySQL 8.0+

### Installation

1. Cloner le dépôt
```bash
git clone <url>
cd TimeGuessr
```

2. Créer la base de données
```bash
mysql -u root -p < db/db.sql
```

3. Insérer les données de test
```bash
mysql -u root -p < db/values.sql
```

4. Si besoin, modifier les identifiants dans `db/db.php`

5. Lancer le serveur PHP
```bash
php -S localhost:8080 -t public/
```

Ouvrir http://localhost:8080

## État d'avancement

**Jalon A ✅**
- Dépôt public avec README et documentation
- Script SQL pour créer la base et les tables
- Script SQL avec données de test (10 images)
- Navigation entre toutes les pages fonctionnelle
- Code PHP commenté

**Jalon B ✅**
- Affichage d'une image différente par manche
- Input année avec validation côté serveur
- Proposition de rejouer en fin de partie
- Intégration CSS avec charte graphique cohérente
- Connexion PDO fonctionnelle

**Jalon C ✅**
- Tirage aléatoire de 5 images en BDD (`ORDER BY RAND() LIMIT 5`)
- Algorithme de score (année + géolocalisation)
- Carte interactive Leaflet avec marqueurs

**Bonus ✅**
- Table `Scores` qui garde l'historique de toutes les parties

## Documentation

### Structure du projet
```
TimeGuessr/
├── public/
│   ├── index.php       # point d'entrée
│   └── css/
│       ├── home.css
│       └── styles.css
├── src/
│   ├── home.php
│   ├── quiz.php
│   ├── answer.php
│   └── end.php
└── db/
    ├── db.php          # connexion PDO
    ├── db.sql          # schéma BDD
    └── values.sql      # données de test
```

### MCD

```
Images (1) ----< Scores (N)
```

**Table Images**
| Champ | Type | Description |
|-------|------|-------------|
| id | INT PK | identifiant |
| path | VARCHAR(300) | URL de l'image |
| position | POINT | coordonnées GPS |
| correct_year | SMALLINT | année réelle |
| info | TEXT | description |
| hint | TEXT | indice |

**Table Scores**
| Champ | Type | Description |
|-------|------|-------------|
| id | INT PK | identifiant |
| image_id | INT FK | référence image |
| session_id | VARCHAR(128) | session du joueur |
| guessed_year | SMALLINT | année soumise |
| guessed_lat | DECIMAL | latitude soumise |
| guessed_lng | DECIMAL | longitude soumise |
| year_score | INT | score année (0-5000) |
| geo_score | INT | score géo (0-5000) |
| total_score | INT | total (0-10000) |
| played_at | DATETIME | horodatage |

### Note sur les coordonnées

MySQL avec SRID 4326 utilise la convention `POINT(longitude latitude)` et non `POINT(latitude longitude)`. Les données dans `values.sql` respectent cet ordre. `ST_Y` retourne la latitude, `ST_X` la longitude.

### Algorithme de score

- **Année** : `5000 × max(0, 1 - écart_années / 50)` → 0 an d'écart = 5000 pts, 50 ans = 0 pt
- **Géo** : `5000 × max(0, 1 - distance_km / 5000)` → distance calculée avec Haversine
- **Total par manche** : max 10 000 pts, max 50 000 sur une partie

## Commentaires

Le plus difficile a été la gestion des types spatiaux MySQL (POINT, ST_Y, ST_X) et comprendre l'ordre lat/lng. La carte Leaflet est très facile à intégrer avec le CDN, c'est la partie que j'ai préférée faire.
