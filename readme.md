Test réalisé pour la société AWAM

Je me suis concentré sur l'idée d'avoir un outil fonctionnel dans le temps imparti, donc en favorisant une approche/des méthodes que je connais voire que j'ai déjà employé. 

Au niveau du temps, je dirais que j'ai mis aux alentours de 2h30-40 (sans prendre en compte le temps de rédaction de ce readme), j'ai d'abord commencé par penser l'outil, ce dont j'aurai besoin, l'ordre des fonctionnalités que je voudrai ajouter s'il me restait du temps, 
et j'ai aussi eu besoin de regarder la documentation, notamment pour la partie sur le mail.

C'est ce mail qui m'a posé le plus de souci, j'avais déjà utilisé le composant Mailer, mais jamais la fonction mail() de PHP. J'ai fait un essai, pas concluant, je suis allé voir la doc à ce sujet et j'ai vu qu'avec Windows ça pouvait poser problème. 
Je n'ai pas voulu prendre trop de temps là-dessus donc je me suis rabattu sur ce que je connaissais. 

Ensuite en ce qui concerne l'automatisation de l'envoi, j'avais déjà essayé lors de ma formation de créer des tâches automatiques, mais la seule solution que j'avais trouvé à l'époque concernait les cron job sous linux. 
Je savais que je risquais de perdre beaucoup de temps sur cette fonctionnalité, n'était pas à l'aise du tout avec ubuntu (via WSL), donc j'ai préféré la mettre de côté immédiatement, 
et pour qu'il soit tout de même possible de faire cet envoi d'historique, j'ai créé la commande app:send-history avec les calculs stockés en base si on coche la case au moment de faire le calcul. Je stocke les calculs sous forme d'un simple texte pour que ce soit le plus léger possible.
Il ne resterait, je pense, qu'à créer un cron job capable de lancer cette commande.

Pour le convertisseur/calculateur,j'ai choisi de faire du convertisseur et du calculateur deux services, de façon à ce qu'ils soient réutilisables sur tout le projet à l'avenir.


Avec le génération des crud de symfony j'ai eu le temps de gérer la création/édition des devises et taux de change (le front n'est pas au point dans certains cas), 
j'ai retiré la suppression/affichage unique par souci de temps, l'ajout et l'édition me parraissant plus primordial pour que l'outil soit utilisable.

Avec plus de temps, la première chose à faire serait de boucler les CRUD, régler le problème de l'envoi de mail automatique. 

Ensuite, je pense que le deuxième aspect important serait de mettre en place la validation du formulaire via une requête ajax, pour éviter le rechargement de la page quand on clique sur 'calculer'. 
Je voulais le mettre en place, mais je n'étais pas sûr de moi quant à la gestion des erreurs dans le formulaire, 
j'ai donc préféré encore une fois me lancer sur quelque chose dont j'étais certain de pouvoir mener à bien (néanmoins j'ai trouvé des ressources à propos de la soumission de formulaire en ajax, je m'y pencherai dessus).

Il faudrait également faire en sorte d'avoir des taux de change mis à jour, j'ai plusieurs idées à ce sujet, la première serait qu'au lieu d'aller chercher en base le taux de change, 
on fasse une requête vers une api pour obtenir le taux selon les devises entrées dans le formulaire. Mais je me demande si c'est viable dans le cas où l'outil serait beaucoup utilisé, 
donc peut-être plutôt lancer de façon automatique une requête api pour récupérer les taux de change et les stocker dans notre base (là-dessus je ne sais pas exactement à quel rythme les taux changent, je suppose que c'est journalier, donc je ne suis pas convaincu par cette approche).
On pourrait également faire évoluer l'outil pour en faire lui-même une api, on pourrait alors l'utiliser sur plusieurs projets client. 










