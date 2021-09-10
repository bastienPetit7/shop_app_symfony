# Creer une administration pour une boutique en ligne d'habit pour femme.

# Entité : Category
# propriété : name (varchar 255 NOT NULL)
# propriété : imagePathUrl (varchar 255 NOT NULL)

# Entité : Product 
# propriété : name (varchar 255 NOT NULL)
# propriété : price (integer NOT NULL)
# propriété : category (relation ManyToOne -> Category)
# propriété : imagePathUrl (varchar 255 NOT NULL)

# Entité : User
# propriété : email (varchar 255 NOT NULL)
# propriété : password (varchar 255 NOT NULL)

# 1 ere etape : On cree le systeme de connexion
# 2 eme etape : On cree l'accueil de l admin
# 3 eme etape : On cree le crud
# 4 eme etape : On cree un service pour sauvegarder les images
# 5 eme etape : On envoie un email de bienvenue lors de la creation d un compte utilisateur
# 6 eme etape : On cree un formulaire de contact


# Le but de ce projet est de se preparer pour la semaine prochaine 
- base de données
- login + register
- crud, espace admin
- envoi de mails (page de contact)
- envoi sur github