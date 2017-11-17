<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

define( 'WP_AUTO_UPDATE_CORE', false );


// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', getenv('CLUBS_DB_NAME'));

/** Utilisateur de la base de données MySQL. */
define('DB_USER', getenv('CLUBS_DB_USER'));

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', getenv('CLUBS_DB_PASSWORD'));

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', getenv('CLUBS_DB_HOST'));

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données.
  * N'y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '#~|2nie-076>L|-JUdQ?NP-D]ED8te60W|6++xHWT02XfOeLYH> ZFx:,.jmVHZn');
define('SECURE_AUTH_KEY',  'S>P#PkM|/sEL6&iVp/5GQqgYwGfbO:QM[8eJY9`NfX+!ig<7=t:kq/e`+1h*g6!]');
define('LOGGED_IN_KEY',    '+p.$L3BVQN8EYQIuNMd-~m--`>*dPd&heIwEcS-t-&0/mZo]IlT|Aeb2b|)hV3w0');
define('NONCE_KEY',        '8sd6vE9lAcr:x-h_T;f9, n9;w*%BY!81$+aDRIkWT{tmj +$z|aEj=21qDyc.AU');
define('AUTH_SALT',        ':Mt;Oeq xJ~Vq TTpZ#BM[c_;j@<g1T8;F$Q{$fPiFx#z.i?_ewV2T<zO}DjaMtq');
define('SECURE_AUTH_SALT', '6q)*>DR- {m-!1epk[:NhG3{Ryr>J</M)L>cj/f2 _@),#Ky @v|jO([R/P`1%{S');
define('LOGGED_IN_SALT',   'jiJ&Uz+ZV-e@Gy.BQ;Wt l,#$gU#-};dpyVM_c@@CYLG&#gpA5b* z3`MSzy<IF3');
define('NONCE_SALT',       'Xh^MRHg)@wF+ydkTYtp&$O(E!p`JYUO8DT<urLO;>AM |5`tc+mVC@rra+Z2wFCi');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wpffckcl_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 */

 ini_set('log_errors','On');
 ini_set('display_errors','Off');
 ini_set('error_reporting', E_ALL );
 define('WP_DEBUG', false);
 define('WP_DEBUG_LOG', true);
 define('WP_DEBUG_DISPLAY', false);

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
