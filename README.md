# Découpage Administratif

Base de données de découpage adminitratif comprenant toutes les régions, départements, et communes de France métropolitaine et départements d'outre-mer, ainsi que les fichiers d'entités correspondants pour leur utilisation dans le cadre d'un projet Symfony.

## Installation

### 1) Placer les fichiers correspondants dans les répertoires `/src/Entity` et `/src/Repository` :

- `/src/Entity/City.php`
- `/src/Entity/CityAlias.php`
- `/src/Entity/Department.php`
- `/src/Entity/Region.php`

- `/src/Repository/CityRepository.php`
- `/src/Repository/CityAliasRepository.php`
- `/src/Repository/DepartmentRepository.php`
- `/src/Repository/RegionRepository.php`

### 2) Mettre à jour le schéma de la base de données de l'application :

En mode console connecté via SSH :

`php bin/console d:s:u -f`

### 3) Import du contenu de la base de données

Importer le contenu du fichier de base de données `decoupage_administratif.sql` dans la base de données (par exemple via PhpMyAdmin).

## Informations complémentaires

### Alias de villes

La table `city_alias` (décrite par l'entité `CityAlias`) correspond aux codes postaux additonnels possibles pour une même commune. De ce fait, lors d'une recherche de commune par code postal (dans un champ d'auto-complétion par exemple), il convient de rechercher dans les codes postaux "alias" afin de remonter les communes correspondantes.

Par exemple, la ville de Marseille a le code postal 13000 par défaut, mais peut également être retournée sur les codes postaux 13001, 13002, 13003, etc. Un utilisateur qui taperait "13006" dans un champ code postal, doit obtenir "Marseille" comme résultat.

**Remarque :** la table `city_alias` **ne contient pas** le code postal par défaut d'une commune, mais uniquement les _codes postaux additonnels_ existants pour cette commune.

### Découpage des régions

Le découpage des régions comprend les 13 régions métropolitaines (découpage du 1er janvier 2016), ainsi qu'une "région non officielle" incluant les départements d'outre-mer. Si vous souhaitez un découpage exact des régions ultramarines (qui représentent officiellement 5 régions additionnelles ne comprenant chacune qu'un seul département), vous pouvez modifier la base de données pour y inclure les 5 régions correspondantes et y rattacher les départements d'outre-mer.

Chaque commune française est représentée par son nom, une URI (non-unique), sa population (au 31 août 2023) et les coordonnés GPS du point central de son agglomération.

### Tri par taille des communes

Le champ `population` de la table des communes permet, par exemple, d'ordonner les résultats par ordre décroissant des villes les plus importantes d'un département.
Par exemple, pour les 10 villes les plus importantes du département 80 :

```sql
SELECT city.id, city.name, city.uri, city.postal_code, city.population, city.latitude, city.longitude,
department.name AS department_name, department.code AS department_code,
region.name AS region_name
FROM `city` 
LEFT JOIN department ON department.id = city.department_id
LEFT JOIN region ON region.id = department.region_id
WHERE department.code = "80" 
ORDER BY `city`.`population`  DESC
LIMIT 10;
```

```
|31002|Amiens|amiens|80000|134167|49.8987|2.2847|Somme|80|Hauts-de-France
|30984|Abbeville|abbeville|80100|22895|50.1101|1.8319|Somme|80|Hauts-de-France
|30997|Albert|albert|80300|9814|50.0035|2.6515|Somme|80|Hauts-de-France
|31558|Péronne|peronne|80200|7444|49.9262|2.926|Somme|80|Hauts-de-France
|31186|Corbie|corbie|80800|6276|49.9216|2.4975|Somme|80|Hauts-de-France
|31506|Montdidier|montdidier|80500|6051|49.6475|2.5662|Somme|80|Hauts-de-France
|31227|Doullens|doullens|80600|5870|50.1515|2.3516|Somme|80|Hauts-de-France
|31441|Longueau|longueau|80330|5815|49.8727|2.3588|Somme|80|Hauts-de-France
|31619|Roye|roye|80700|5703|49.6907|2.7869|Somme|80|Hauts-de-France
|31722|Villers-Bretonneux|villers-bretonneux|80800|4637|49.8627|2.5183|Somme|80|Hauts-de-France
```