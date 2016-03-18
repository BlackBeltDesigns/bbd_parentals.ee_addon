# bbd_parentals.ee_addon
An EE3 build of Yuri Salimovskiy's Category Parents pi

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
