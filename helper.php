<?php
/****************************************************************************************\
**   Module JoomGalleryAdminStatistic for JoomGallery                                            **
**   By: JoomGallery::ProjectTeam                                                       **
**   Released under GNU GPL Public License                                              **
**   License: http://www.gnu.org/copyleft/gpl.html or have a look                       **
**   at administrator/components/com_joomgallery/LICENSE.TXT                            **
\****************************************************************************************/
defined('_JEXEC') or die('Restricted access');

/**
 *
 * Helper class for module JoomGalleryAdminStatistic
 *
 */
class modJoomAdmStatsHelper
{
  /**
   *
   * Get parameters from backend, prepare and execute the database queries,
   * and fill an array for later output in template
   * @param $params
   */
  public static function getList(&$params)
  {
    $user  = JFactory::getUser();

    // Array for storing the e.g. results and db query clauses
    $elems = array();

    // Load access view levels
    $authorised_viewlevels = implode(',', $user->getAuthorisedViewLevels());

    // Get instance of database object ans set debug mode if enabled
    $db = JFactory::getDBo();

    // Get an instance of JDatabaseQuery object and clear them initially
    $query = $db->getQuery(true);

    // Retreive parameters and fill the array
    // Get parameters for published images and fill array element
    $elems['picspublished']          = new stdClass();
    $elems['picspublished']->enabled = intval($params->get('pics_published', false));
    if($elems['picspublished']->enabled)
    {
      $elems['picspublished']->outputtext  = JText::_('MOD_JOOMADMSTATS_PICSPUBLISHED_OUTPUTTEXT');
      $query = $db->getQuery(true)
          ->select('COUNT(a.id)')
          ->from('#__joomgallery'.' AS a')
          ->InnerJoin('#__joomgallery_catg'.' AS c ON c.cid = a.catid')
          ->where('a.published = 1')
          ->where('a.approved  = 1')
          ->where('c.published = 1')
          ->where('a.access IN ('.$authorised_viewlevels.')')
          ->where('c.access IN ('.$authorised_viewlevels.')');
      $db->setQuery($query);
      $elems['picspublished']->outputresult = $db->loadResult();
      $elems['picspublished']->icon = 'icon-image text-success';
    }

    // Get parameters for unpublished images and fill array element
    $elems['picunspublished']          = new stdClass();
    $elems['picunspublished']->enabled = intval($params->get('pics_unpublished', false));
    if($elems['picunspublished']->enabled)
    {
      $elems['picunspublished']->outputtext  = JText::_('MOD_JOOMADMSTATS_PICSUNPUBLISHED_OUTPUTTEXT');
      $query = $db->getQuery(true)
          ->select('COUNT(a.id)')
          ->from('#__joomgallery'.' AS a')
          ->InnerJoin('#__joomgallery_catg'.' AS c ON c.cid = a.catid')
          ->where('a.published = 0 or a.approved != 1')
          ->where('c.published = 1')
          ->where('a.access IN ('.$authorised_viewlevels.')')
          ->where('c.access IN ('.$authorised_viewlevels.')');
      $db->setQuery($query);
      $elems['picunspublished']->outputresult = $db->loadResult();
      $elems['picunspublished']->icon = 'icon-image text-error';
    }

    // Get parameters for published categories and fill array element
    $elems['catspublished']          = new stdClass();
    $elems['catspublished']->enabled = intval($params->get('cats_published', false));
    if($elems['catspublished']->enabled)
    {
      $elems['catspublished']->outputtext  = JText::_('MOD_JOOMADMSTATS_CATSPUBLISHED_OUTPUTTEXT');
      $query = $db->getQuery(true)
          ->select('COUNT(c.cid)')
          ->from('#__joomgallery_catg'.' AS c')
          ->where('c.published = 1 and c.cid != 1')
          ->where('c.access IN ('.$authorised_viewlevels.')');
      $db->setQuery($query);
      $elems['catspublished']->outputresult = $db->loadResult();
      $elems['catspublished']->icon = 'icon-folder-3 text-success';
    }

    // Get parameters for unpublished categories and fill array element
    $elems['catunspublished']          = new stdClass();
    $elems['catunspublished']->enabled = intval($params->get('cats_unpublished', false));
    if($elems['catunspublished']->enabled)
    {
      $elems['catunspublished']->outputtext  = JText::_('MOD_JOOMADMSTATS_CATSUNPUBLISHED_OUTPUTTEXT');
      $query = $db->getQuery(true)
          ->select('COUNT(c.cid)')
          ->from('#__joomgallery_catg'.' AS c')
          ->where('c.published = 0 and c.cid != 1')
          ->where('c.access IN ('.$authorised_viewlevels.')');
      $db->setQuery($query);
      $elems['catunspublished']->outputresult = $db->loadResult();
      $elems['catunspublished']->icon = 'icon-folder-3 text-error';
    }

    // Get parameters for published comments and fill array element
    $elems['commentspublished']          = new stdClass();
    $elems['commentspublished']->enabled = intval($params->get('comments_published', false));
    if($elems['commentspublished']->enabled)
    {
      $elems['commentspublished']->outputtext  = JText::_('MOD_JOOMADMSTATS_COMMENTSPUBLISHED_OUTPUTTEXT');
      $query = $db->getQuery(true)
          ->select('COUNT(com.cmtid)')
          ->from('#__joomgallery_comments'.' AS com')
          ->InnerJoin('#__joomgallery'.' AS a ON com.cmtpic = a.id')
          ->InnerJoin('#__joomgallery_catg'.' AS c ON c.cid = a.catid')
          ->where('a.published   = 1')
          ->where('c.published   = 1')
          ->where('com.published = 1')
          ->where('com.approved  = 1')
          ->where('a.access IN ('.$authorised_viewlevels.')')
          ->where('c.access IN ('.$authorised_viewlevels.')');
      $db->setQuery($query);
      $elems['commentspublished']->outputresult = $db->loadResult();
      $elems['commentspublished']->icon = 'icon-comments-2 text-success';
    }

    // Get parameters for unpublished comments and fill array element
    $elems['commentsunpublished']          = new stdClass();
    $elems['commentsunpublished']->enabled = intval($params->get('comments_unpublished', false));
    if($elems['commentsunpublished']->enabled)
    {
      $elems['commentsunpublished']->outputtext  = JText::_('MOD_JOOMADMSTATS_COMMENTSUNPUBLISHED_OUTPUTTEXT');
      $query = $db->getQuery(true)
          ->select('COUNT(com.cmtid)')
          ->from('#__joomgallery_comments'.' AS com')
          ->InnerJoin('#__joomgallery'.' AS a ON com.cmtpic = a.id')
          ->InnerJoin('#__joomgallery_catg'.' AS c ON c.cid = a.catid')
          ->where('a.published = 1')
          ->where('c.published = 1')
          ->where('com.published = 0 or com.approved != 1')
          ->where('a.access IN ('.$authorised_viewlevels.')')
          ->where('c.access IN ('.$authorised_viewlevels.')');
      $db->setQuery($query);
      $elems['commentsunpublished']->outputresult = $db->loadResult();
      $elems['commentsunpublished']->icon = 'icon-comments-2 text-error';
    }

    // Get parameters for hits and fill array element
    $elems['allhits'] = new stdClass();
    $elems['allhits']->enabled = intval($params->get('all_hits', false));
    if($elems['allhits']->enabled)
    {
      $elems['allhits']->outputtext  = JText::_('MOD_JOOMADMSTATS_HITS_OUTPUTTEXT');
      $query = $db->getQuery(true)
          ->select('SUM(a.hits)')
          ->from('#__joomgallery'.' AS a')
          ->InnerJoin('#__joomgallery_catg'.' AS c ON c.cid = a.catid')
          ->where('a.published = 1')
          ->where('a.approved  = 1')
          ->where('c.published = 1')
          ->where('a.access IN ('.$authorised_viewlevels.')')
          ->where('c.access IN ('.$authorised_viewlevels.')');
      $db->setQuery($query);
      $elems['allhits']->outputresult = $db->loadResult();
      $elems['allhits']->icon = 'icon-eye';
    }

    // Get parameters for votes and fill array element
    $elems['allvotes'] = new stdClass();
    $elems['allvotes']->enabled = intval($params->get('all_votes', false));
    if($elems['allvotes']->enabled)
    {
      $elems['allvotes']->outputtext  = JText::_('MOD_JOOMADMSTATS_VOTES_OUTPUTTEXT');
      $query = $db->getQuery(true)
          ->select('COUNT(v.voteid)')
          ->from('#__joomgallery_votes'.' AS v')
          ->InnerJoin('#__joomgallery'.' AS a ON v.picid = a.id')
          ->InnerJoin('#__joomgallery_catg'.' AS c ON c.cid = a.catid')
          ->where('a.published = 1')
          ->where('a.approved  = 1')
          ->where('c.published = 1')
          ->where('a.access IN ('.$authorised_viewlevels.')')
          ->where('c.access IN ('.$authorised_viewlevels.')');
      $db->setQuery($query);
      $elems['allvotes']->outputresult = $db->loadResult();
      $elems['allvotes']->icon = 'icon-star-2';
    }

    // Get parameters for nametags and fill array element
    $elems['allnametags'] = new stdClass();
    $elems['allnametags']->enabled = intval($params->get('all_nametags', false));
    if($elems['allnametags']->enabled)
    {
      $elems['allnametags']->outputtext  = JText::_('MOD_JOOMADMSTATS_NAMETAGS_OUTPUTTEXT');
      $query = $db->getQuery(true)
          ->select('COUNT(n.nid)')
          ->from('#__joomgallery_nameshields'.' AS n')
          ->InnerJoin('#__joomgallery'.' AS a ON n.npicid = a.id')
          ->InnerJoin('#__joomgallery_catg'.' AS c ON c.cid = a.catid')
          ->where('a.published = 1')
          ->where('a.approved  = 1')
          ->where('c.published = 1')
          ->where('a.access IN ('.$authorised_viewlevels.')')
          ->where('c.access IN ('.$authorised_viewlevels.')');
      $db->setQuery($query);
      $elems['allnametags']->outputresult = $db->loadResult();
      $elems['allnametags']->icon = 'icon-vcard';
    }

    return $elems;
  }
}