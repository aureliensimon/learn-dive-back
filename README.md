# API

# GET toutes les tables

```GET /api/tables```

Récupérer la liste de toutes les tables de plongées présente dans la base de données

### Query Parameters

pas de paramètres


# GET les infos d'une table précise

```GET /api/table/id```

Récupérer les infos d'une table précise présente dans la base de données

### Query Parameters

| Paramètre | Type | Description |
|-----------|------|-------------|
|       id  | int  | id de la table      |


# GET les infos d'une table précise

```GET /api/table/id```

Récupérer les infos d'une table précise présente dans la base de données

### Query Parameters

| Paramètre | Type | Description |
|-----------|------|-------------|
|   volumeBouteille   |    int  |       volume de la bouteille (choix entre 9,12, 15 ou 18 l)      |
|   pressionRemplissage   |    int  |       pression de remplissage de la bouteille (par défaut 200 bars)      |
|   profondeur   |    int  | profondeur maxi de la plongée (PR)     |
|   dureePlongee   |    int  | durée de la plongée avant remontée (DP)     |
|   table   |    int  | id de la table     |



