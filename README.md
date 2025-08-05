# Blind OS Command Injection with Output Redirection

Un laboratoire éducatif pour apprendre les techniques d'injection de commande OS aveugle avec redirection de sortie.

## 🎯 Description

Ce lab présente une application web vulnérable à l'injection de commande OS aveugle. Contrairement aux injections classiques, l'output des commandes n'est pas directement visible. L'attaquant doit utiliser des techniques de redirection de sortie pour extraire des informations sensibles.

## 🚀 Démarrage Rapide

### Prérequis
- Docker et Docker Compose installés
- Port 3206 disponible

### Lancement
```bash
# Naviguer vers le répertoire deploy
cd deploy

# Lancer le lab
docker compose up --build -d

# Accéder au lab
# URL: http://localhost:3206
```

## 🎯 Objectif du Lab

Votre mission est de :
1. **Identifier** la vulnérabilité d'injection de commande OS
2. **Exploiter** la redirection de sortie (`>`, `>>`)
3. **Extraire** le contenu de `/etc/passwd`
4. **Accéder** au fichier créé via l'URL

## 🛠️ Techniques Apprises

- **Injection de commande OS** : Exécution de commandes shell
- **Redirection de sortie** : Opérateurs `>`, `>>`
- **Accès aux fichiers** : Accès aux fichiers via le serveur web
- **Techniques aveugles** : Exploitation sans sortie directe

## 📁 Structure du Projet

```
Blind OS command injection with output redirection/
├── build/                 # Code source de l'application
│   ├── index.php         # Page d'accueil
│   ├── feedback.php      # Formulaire vulnérable
│   ├── admin.php         # Panneau d'administration
│   ├── Dockerfile        # Configuration Docker
│   └── images/          # Ressources graphiques
├── deploy/               # Configuration Docker
│   ├── docker-compose.yml # Configuration du lab
│   └── README.md        # Documentation du déploiement
├── docs/                # Documentation
│   └── WRITEUP.md      # Writeup complet
├── test/                # Tests automatisés
├── .github/             # Configuration CI/CD
└── README.md           # Ce fichier
```

## 🔧 Détails Techniques

- **Technologie** : PHP 8.1 + Apache
- **Vulnérabilité** : Input non validé dans `exec()`
- **Port** : 3206
- **Difficulté** : Débutant

## 📝 Utilisation

1. Lancez le lab avec Docker
2. Naviguez vers le formulaire de feedback
3. Testez l'injection de commande dans le champ email
4. Utilisez la redirection de sortie pour extraire des données
5. Accédez aux fichiers créés via l'interface web

## 🛡️ Avertissement de Sécurité

⚠️ **Ce lab est délibérément vulnérable et conçu uniquement à des fins éducatives. Ne déployez jamais cette application en production.**

## 📚 Documentation

- **Guide d'exploitation** : Voir `/docs/WRITEUP.md`
- **Writeup complet** : Inclus dans la documentation
- **Exemples de payloads** : Fournis dans le lab

## 🆘 Support

Pour des questions ou problèmes :
- Consultez la documentation dans `/docs/`
- Vérifiez les logs Docker : `docker logs <container_name>`
- Redémarrez le lab : `docker compose restart`

---

*Lab conçu pour l'apprentissage de la sécurité offensive dans un environnement contrôlé.* 