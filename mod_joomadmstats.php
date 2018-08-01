<?php
/****************************************************************************************\
**   Module JoomAdminGalleryStatistic for JoomGallery                                            **
**   By: JoomGallery::ProjectTeam                                                       **
**   Released under GNU GPL Public License                                              **
**   License: http://www.gnu.org/copyleft/gpl.html or have a look                       **
**   at administrator/components/com_joomgallery/LICENSE.TXT                            **
\****************************************************************************************/

defined('_JEXEC') or die('Restricted access');

require_once dirname(__FILE__).'/helper.php';

$list = modJoomAdmStatsHelper::getList($params);

require JModuleHelper::getLayoutPath('mod_joomadmstats', $params->get('layout', 'default'));