<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
  'pi_name' => 'BBD Parentals',
  'pi_version' =>'1.0.0',
  'pi_author' =>'BBDOKC',
  'pi_author_url' => 'http://bbdokc.com',
  'pi_description' => 'BBD Parentals provides you the ability to fetch and use categorical hierarchy without the mess of loops.',
  'pi_usage' => Category_parents::usage()
  );

class Parentals {
    
        function __construct()
    {        
    	$this->EE =& get_instance(); 

    }
    
  function parent()
  {
    $TMPL = ee()->TMPL;
    $DB = ee()->db;
    $PREFS = ee()->config;
    $FNS = ee()->functions;
	
	$category = is_numeric($TMPL->fetch_param('category')) ? $TMPL->fetch_param('category') : '0';
    $exclude_self = ($TMPL->fetch_param('exclude_self')=='yes') ? $TMPL->fetch_param('exclude_self') : 'no';
	if ($category<=0) return;
  
    $tagdata = $TMPL->tagdata;
    $cond = array();
    
    $data = $this->_traverse($category, true);
    if ($exclude_self=='yes' && $data[0]['cat_id']==$category)
    {
        return $TMPL->no_results();
    }
    foreach ($data[0] as $key=>$val)
    {
        $tagdata = $TMPL->swap_var_single($key, $val, $tagdata);
    }
 
    $tagdata = $FNS->prep_conditionals($tagdata, $cond);
		
    $this->return_data = $tagdata;
    return $this->return_data;
  }
  
  
  function all_parents()
  {
    $TMPL = ee()->TMPL;
    $DB = ee()->db;
    $PREFS = ee()->config;
    $FNS = ee()->functions;

	$category = is_numeric($TMPL->fetch_param('category')) ? $TMPL->fetch_param('category') : '0';
    $exclude_self = ($TMPL->fetch_param('exclude_self')=='yes') ? $TMPL->fetch_param('exclude_self') : 'no';
	if ($category<=0) return;
  
    $tagdata = $TMPL->tagdata;
    $out = '';
    $cond = array();
    
    $data = $this->_traverse($category, true);
    if ($exclude_self=='yes' && $data[0]['cat_id']==$category)
    {
        return $TMPL->no_results();
    }

    foreach ($data[0] as $key=>$val)
    {
        $tagdata = $TMPL->swap_var_single($key, $val, $tagdata);
    }
    $tagdata = $TMPL->swap_var_single('cat_parent_id', $data[0]['parent_id'], $tagdata);
    $out .= $tagdata;
    while ($data[0]['parent_id']!=0)
    {
    	$tagdata = $TMPL->tagdata;
		$data = $this->_traverse($data[0]['parent_id'], true);
	
	    foreach ($data[0] as $key=>$val)
	    {
	        $tagdata = $TMPL->swap_var_single($key, $val, $tagdata);
	    }
	    $tagdata = $TMPL->swap_var_single('cat_parent_id', $data[0]['parent_id'], $tagdata);
	    $out .= $tagdata;
    }

 
    $out = $FNS->prep_conditionals($out, $cond);
		
    $this->return_data = $out;
    return $this->return_data;
  }
  
  
  function root()
  {
       
    $TMPL = $this->EE->TMPL;
    $DB = $this->EE->db;
    $PREFS = $this->EE->config;
    $FNS = $this->EE->functions;
	
	$category = is_numeric($TMPL->fetch_param('category')) ? $TMPL->fetch_param('category') : '0';
    $exclude_self = ($TMPL->fetch_param('exclude_self')=='yes') ? $TMPL->fetch_param('exclude_self') : 'no';
	if ($category<=0) return;
  
    $tagdata = $TMPL->tagdata;
    
    $data = $this->_traverse($category);
    if ($exclude_self=='yes' && $data[0]['cat_id']==$category)
    {
        return $TMPL->no_results();
    }

    foreach ($data[0] as $key=>$val)
    {
        $tagdata = $TMPL->swap_var_single($key, $val, $tagdata);
    }
		
    $this->return_data = $tagdata;
    return $this->return_data;
  }
  
  function _traverse($cat_id, $singlecall = false)
  {
    $DB = ee()->db;
    $q = $DB->query("SELECT * FROM exp_categories WHERE cat_id='$cat_id'");
    $parent_id = $q->row('parent_id');
    if ($parent_id==0 || $singlecall == true)
    {
        return $q->result_array();
    }
    return $this->_traverse($parent_id);

  }

  
  // ----------------------------------------
  //  Plugin Usage
  // ----------------------------------------

  // This function describes how the plugin is used.
  //  Make sure and use output buffering

  function usage()
  {
	  ob_start(); 
	  ?>
	This plugin lets you fetch info about parents of given category (direct parent and root).
    Parameters:
    category - category id to fetch parent (mandatory)
    exclude_self="yes" - exclude the current category from output
    
    {exp:parentals:parent category="{category_id}"}
      {cat_id}
      {cat_name}
      {cat_url_title}
      {cat_description}
      {cat_image}
      {cat_parent_id}
    {/exp:parentals:parent}
	
    {exp:parentals:root category="{category_id}"}
      {cat_id}
      {cat_name}
      {cat_url_title}
      {cat_description}
      {cat_image}
      {cat_parent_id}
    {/exp:parentals:root}
    
    {exp:parentals:all_parents category="{category_id}"}
      {cat_id}
      {cat_name}
      {cat_url_title}
      {cat_description}
      {cat_image}
      {cat_parent_id}
    {/exp:parentals:all_parents}
    
	  <?php
	  $buffer = ob_get_contents();
		
	  ob_end_clean(); 
	
	  return $buffer;
  }
  // END

}
?>

/* End of file pi.parentals.php */
/* Location: ./system/user/addons/parentals/pi.parentals.php */