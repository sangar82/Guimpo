<?php 
$users 							=	 		$this->get_var('users');
$paginate 					= 			$this->get_var('paginate'); 
$items_total 			= 			$this->get_var('items_total');
$sort_dir 						= 			$this->get_var('sort_dir');
$newsort_dir 			= 			$this->get_var('newsort_dir');
$sort_by 						= 			$this->get_var('sort_by');
$redirect_url				= 			$this->get_var('redirect_url');
$search_text			= 			$this->get_var('search_text');
$search_field			= 			$this->get_var('search_field');
$url_search 				= 			($search_text)  ?  "&search_text=$search_text&search_field=$search_field" : "";

echo $this->get_web_information(); 




echo "<h1>". $this->translate('list_of', array($this->translate('users')))."</h1>";

if ( ($items_total == 0 and $search_text != '') or ( $items_total ) ){

	echo "<div class='searchtable'>";
		echo "<input type='text' value='$search_text' id='search_text' size='60'>&nbsp;&nbsp;";
		echo "<select id='search_field' class='paddingselect'>";
			$selected = ('email' == $search_field)  ?   'selected' : ''; 
			echo "<option value='email' $selected>".$this->translate('email')."</option>";
			$selected = ('name' == $search_field)  ?   'selected' : ''; 
			echo "<option value='name' $selected>".$this->translate('name')."</option>";
			$selected = ('lastname' == $search_field)  ?   'selected' : ''; 
			echo "<option value='lastname' $selected>".$this->translate('lastname')."</option>";
			$selected = ('type' == $search_field)  ?   'selected' : ''; 
			echo "<option value='type' $selected>".$this->translate('type')."</option>";
			$selected = ('created' == $search_field)  ?   'selected' : ''; 
			echo "<option value='created' $selected>".$this->translate('created')."</option>";
		echo "</select>";
		echo "<a href='/admin/users/list/' class='search' id='search'>".$this->translate('search')."</a>";
	echo "</div>";

	if ($search_text){
		echo "<a href='".$_SERVER['REDIRECT_URL']."' class='searchbacklink'>← Volver al listado</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$items_total = ($items_total)			?    $items_total			:		'0';
		echo "<span class='searchbacklink'>$items_total elementos encontrados.</span>";
		echo "<br/><br/>";
	}

}

if ($users){

  echo "<table class='formattable'>";
  
    echo "<thead>";
      echo "<th>".( ($sort_by == 'email' ) ? (($sort_by == 'email' and $sort_dir == 'asc') ? '↓ '  : '↑ ') : '' ) ."<a href='$redirect_url?sort_by=email&sort_dir=$newsort_dir$url_search'>". $this->translate('email')."</a></th> ";
      echo "<th>".( ($sort_by == 'name' ) ? (($sort_by == 'name' and $sort_dir == 'asc') ? '↓ '  : '↑ ') : '' ) ."<a href='$redirect_url?sort_by=name&sort_dir=$newsort_dir$url_search'>". $this->translate('name')."</a></th> ";
      echo "<th>".( ($sort_by == 'lastname' ) ? (($sort_by == 'lastname' and $sort_dir == 'asc') ? '↓ '  : '↑ ') : '' ) ."<a href='$redirect_url?sort_by=lastname&sort_dir=$newsort_dir$url_search'>". $this->translate('lastname')."</a></th> ";
      echo "<th>".( ($sort_by == 'type' ) ? (($sort_by == 'type' and $sort_dir == 'asc') ? '↓ '  : '↑ ') : '' ) ."<a href='$redirect_url?sort_by=type&sort_dir=$newsort_dir$url_search'>". $this->translate('type')."</a></th> ";
      echo "<th>".( ($sort_by == 'created' ) ? (($sort_by == 'created' and $sort_dir == 'asc') ? '↓ '  : '↑ ') : '' ) ."<a href='$redirect_url?sort_by=created&sort_dir=$newsort_dir$url_search'>". $this->translate('created')."</a></th> ";
      echo "<th colspan='3'>". $this->translate('options')."</th>";
      
    echo "</thead>";
    echo "<tbody>";
    
    foreach ($users as $user) { 
      
      echo "<tr>";
  
        echo "<td>".$user['username']."</td>";
        echo "<td>".$user['name']."</td>";
        echo "<td>".$user['lastname']."</td>";
        echo "<td>".$user['type']."</td>";
        echo "<td>".Cutils::convert_timestamp_to_spanish_date($user['created'])."</td>";
        echo "<td><a href='/admin/users/".$user['id']."/'>".$this->translate('view')."</a></td>";
        echo "<td><a href='/admin/users/edit/".$user['id']."/'>".$this->translate('modify')."</a></td>";
        echo "<td><a href='/admin/users/delete/".$user['id']."/' onclick=\"return confirm('".$this->translate('confirm_delete')."');\">".$this->translate('delete')."</a></td>";
        
      echo "</tr>";
      
    }
    echo "</tbody>";
    
  echo "</table>";
  
  echo $paginate; 
  
  echo "<br /><br />";

  echo "<a href='/admin/users/create/' class='create'>". $this->translate('create_new_user')."</a>";

}else 
  echo "". $this->translate('no_items')." <a href='/admin/users/create/' class='create'>". $this->translate('create_new_user')."</a>";
  
?>