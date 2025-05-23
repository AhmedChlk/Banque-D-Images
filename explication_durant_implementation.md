## logs de 23/05/2025

### Les Session en PHP
utiliser une Session qui represente un petit espace Memoire crée par Php pour chaque Visiteur pour memoriser les connexion

et donc on fait correspondre les données de connexion avec les données stockées dans la session 
exemple : 
```php
$_SESSION['user_id'] = $user['id'];
```
en d'autre terminal "Ce visiteur est maintenant connecté en tant qu'utilisateur avec cet id"

et ca nous facilite beaucoup de traitement par exemple on peut on une seule ligne savoir si un utilisateur est connecté ou pas
```php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
```

avec cela on implemente dans auth.php les fonctions de connexion et d'inscriptions 

### fonction registerUser()
avec cette fonction on crée les nouveaux utilisateurs dans la base de données tout en assurant des tests de securité pour garder une base de données cohérente 

on assure ces  choses : 
- un login et un email uniques
- Vérification que tous les champs sont remplis
-Vérification de l’email avec filter_var()
- Longueur minimale pour le login et le mot de passe

avec cela j'ai preferé utilisé des requêtes preparés avec  pdo et des ? et cela pour une raison principale se proteger des injections SQL 
pourquoi ? ca sépare  les données de la requête d'après la doc de php , ce qui évite toute modification malveillante du code SQL et parfois c'est potentielement plus performant 
https://www.php.net/manual/fr/mysqli.quickstart.prepared-statements.php#:~:text=%C3%89chappement%20et%20injection%20SQL

donc apres cela on hash notre mot de passe 

et on insert dans la base de données 

on stocke a la fin dans la session l'id de l'utilisateur 

### fonction LoginUser()
on Vérifie que le login et le mot de passe sont fournis

On récupère l'utilisateur depuis la base en fonction de son login

Ensuite on vérifie que l'utilisateur existe dans la base et que le  mot de passe fourni par l’utilisateur correspond au mot de passe stocké dans la base 

si tout est bon on demarre la session sinon on indique que la connexion n'as pas pu se faire 