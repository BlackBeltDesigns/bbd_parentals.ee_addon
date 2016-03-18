# bbd_parentals.ee_addon
An EE3 build of Yuri Salimovskiy's Category Parents pi

This plugin lets you fetch info about parents of given category (direct parent and root).
    Parameters:
    category - category id to fetch parent (mandatory)
    exclude_self="yes" - exclude the current category from output
    
    {exp:category_parents:parent category="{category_id}"}
    {cat_id}
    {cat_name}
    {cat_url_title}
    {cat_description}
    {cat_image}
    {cat_parent_id}
    {exp:category_parents:parent}
	
    {exp:category_parents:root category="{category_id}"}
    {cat_id}
    {cat_name}
    {cat_url_title}
    {cat_description}
    {cat_image}
    {cat_parent_id}
    {exp:category_parents:root}
    
    {exp:category_parents:all_parents category="{category_id}"}
    {cat_id}
    {cat_name}
    {cat_url_title}
    {cat_description}
    {cat_image}
    {cat_parent_id}
    {exp:category_parents:all_parents}
