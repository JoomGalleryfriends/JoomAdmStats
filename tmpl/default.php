<?php

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

?>

<div class="row-striped">
  <table class="table table-striped">
    <tbody>
<?php  foreach($list as $elem):
         if($elem->enabled): ?>
           <tr>
             <td class="center nowrap" width="50">
               <span class="badge badge-info hasTooltip" title="<?php echo JHtml::_('tooltipText', JText::_($elem->outputtext)); ?>"><?php echo $elem->outputresult; ?></span>
             </td>
             <td class="center" width="15">
               <span class="<?php echo JText::_($elem->icon)?>">
             </td>
             <td>
               <?php echo JText::_($elem->outputtext);?>
             </td>
           </tr>
<?php    endif;
      endforeach; ?>
    </tbody>
  </table>
</div>
