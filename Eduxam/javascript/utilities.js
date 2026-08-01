console.log('==== UTILITIES.JS ====');


//// --------------------------------------------
////  nombreAleatoire
//// --------------------------------------------

// Renvoie un nombre aléatoire
function nombreAleatoire(min, max)
{
    return Math.floor(Math.random() * (max - min + 1)) + min;
}


//// --------------------------------------------
////  saisieNombre
//// --------------------------------------------

// Saisie de nombre entier ou a virgule obligatoire
function saisieNombre(message = "Saisissez un nombre", valeurDefaut)
{
   var saisie;

   do {
      saisie = window.prompt(message, valeurDefaut);
      if (saisie != null)
      {
          // Sinon nombre est transformé en NaN par parseFloat, et on reste coincé dans la boucle
         saisie = parseFloat(saisie);
      }
   }
   while ( (isNaN(saisie)) && (saisie != null) );

   return saisie;
}


//// --------------------------------------------
////  interpolation
//// --------------------------------------------

// Retourne une valeur interpolée entre début et fin, pour t dans [0..1]
function interpolation(debut, fin, t)
{
    return debut + ((fin - debut) * t);
}