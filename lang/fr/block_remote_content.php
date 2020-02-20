<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package   block_remote_content
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['remote_content:addinstance'] = 'Ajouter un nouveau bloc de contenu distant';
$string['remote_content:myaddinstance'] = 'Add a new HTML block to Dashboard';
$string['remote_content:configure'] = 'Configure the block source';
$string['remote_content:manageownsources'] = 'Manage own source definitions';

$string['allowadditionalcssclasses'] = 'Allow additional CSS classes';
$string['configallowadditionalcssclasses'] = 'Adds a configuration option to HTML block instances allowing additional CSS classes to be set.';
$string['configclasses'] = 'Additional CSS classes';
$string['configclasses_help'] = 'The purpose of this configuration is to aid with theming by helping distinguish HTML blocks from each other. Any CSS classes entered here (space delimited) will be appended to the block\'s default classes.';
$string['configtitle'] = 'Titre du bloc';
$string['configpreferedcrypto'] = 'Algorythme de cryptographie (contexte)';
$string['internal'] = 'Interne';
$string['rsa'] = 'RSA (par le réseau moodle)';
$string['aes'] = 'AES (par Mysql)';
$string['leaveblanktohide'] = 'leave blank to hide the title';
$string['pluginname'] = 'Contenu distant';
$string['blockname'] = 'Contenu distant';
$string['newremotecontentblock'] = 'Nouveau contenu distant';
$string['extracss'] = 'CSS additionnelle';
$string['configsendcontext'] = 'Joindre le contexte';
$string['configsendcontext_help'] = 'Si activé, le contexte courant (cours, utilisateur, groupe, etc.) est ajouté à la requête distante de contenu.';
$string['configcontextkey'] = 'Clef de cryptge du contexte';
$string['contextnosend'] = 'Ne pas envoyer le contexte';
$string['contextsendplain'] = 'Envoyer le contexte en clair';
$string['contextsendcrypted'] = 'Envoyer le contexte crypté';
$string['integration'] = 'Mode d\'intégration';
$string['ajax'] = 'Ajax';
$string['iframe'] = 'IFrame';
$string['iframeheight'] = 'Hauteur du cadre';
$string['errorunknowncrypto'] = 'Erreur : Cet algorithme de cryptage {$a} n\'existe pas.';

$string['soap'] = 'Soap';
$string['rest'] = 'Rest';
$string['moodlews'] = 'Web services Moodle';
$string['htmlcapture'] = 'Capture HTML';

$string['format'] = 'Format de la réponse';
$string['xml'] = 'XML';
$string['plain'] = 'HTML';
$string['json'] = 'JSON';

$string['method'] = 'Méthode';

$string['soapsettings'] = 'Configuration Soap';
$string['soapfunction'] = 'Fonction soap';
$string['soapparams'] = 'Paramètres Soap';
$string['wsdlurl'] = 'Url du WSDL';
$string['soaplogin'] = 'Identifiant du service';
$string['soappassword'] = 'Mot de passe du service';

$string['mustache'] = 'Template Mustache';

$string['restsettings'] = 'Configuration Rest';
$string['url'] = 'Url distante';

$string['moodlewssettings'] = 'Configuration du WS Moodle';
$string['wsbaseurl'] = 'Url de base du serveur moodle';
$string['wsprotocol'] = 'Protocole';
$string['wsfunction'] = 'Fonction';
$string['wstoken'] = 'Token';
$string['wsparams'] = 'Paramètres de l\'appel';

$string['htmlcapturesettings'] = 'Configuration de la capture HTML';
$string['frompattern'] = 'Motif de début de capture';
$string['topattern'] = 'Motif de fin de capture';

$string['erroremptyresturl'] = 'Le protocole est REST, maus l\'URL rest est vide.';
