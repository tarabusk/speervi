<?php
// Classe d'objets de formulaires HTML


class Form {

  // INPUT PASSWORD
	static function passwd($name,  $value, $id='', $style='', $class='') {
    $attributs = '';
		$attributs .= $id? ' id="' . $id . '"' : '';
		$attributs .= $style? ' style="' . $style . '"' : '';
		$attributs .= $class? ' class="' . $class . '"' : '';
		return '<input type="password" name="' . $name . '" ' . $attributs . 'value="'.$value.'" />';
	}
	
	// INPUT TEXT
	static function text($name, $value, $txt='', $id='', $class='', $fonction="") {
	    if($id==''){$id=$name;}
		if(!strstr($class, 'largeur_petit'))$sauterLigne='<br/>';else$sauterLigne='';// Trop pourri à changer !! gaëlle
		
		return ' 
		<label for="'.$id.'"> '.$txt.' </label>'.$sauterLigne.'
		<input type="text" name="' . $name . '" id="'.$id.'" class="' . $class . '" value="' . htmlspecialchars($value) . '"'.$fonction.' />
		';
	}
	
	static function text_readonly($id, $value, $txt, $class='') {	    
		if($class !='largeur_petit')$sauterLigne='<br/>';else$sauterLigne='';// Trop pourri à changer !! gaëlle
		if($class !='largeur_petit')$sauterLigne='<br/>';else$sauterLigne='';// Trop pourri à changer !! gaëlle
		return ' 
		<label for="'.$id.'"> '.$txt.' </label>'.$sauterLigne.'
		<input type="text"  id="'.$id.'" class="' . $class . '" value="' . htmlspecialchars($value) . '" readonly="readonly" />
		';
	}
	
	static function textspam() { // Anti spam
	  return '<input type="text" name="champs_xxx" id="champs_xxx" value="" />';
	}
	
	// INPUT TEXT
	static function texteditor($name, $value, $txt='', $id='', $class='',$nomtoolbar='') {
	    if($id==''){$id=$name;} 
		if($nomtoolbar==''){$nomtoolbar='MyToolbar';} 
		return ' 
		  <p>
	    <label for="'.$id.'"> '.$txt.' </label>
		<textarea name="'.$name.'" id="'.$id.'" cols="105" rows="20" "
							onchange="storeCaret(this)">
			' . htmlspecialchars($value) . '
		</textarea>
		<script type="text/javascript">
			editeur=CKEDITOR.replace(\''.$name.'\',{                            
				  height  : \'100px\',
				  toolbar : \''.$nomtoolbar.'\'
				});
		</script>	
	</p>		
		';
		// Pas sur que dans le replace il faille pas mettre mle $id au lieu du $name
	}

	// TEXTAREA
	static function textarea($name, $value, $txt, $id="", $class='', $cols=105, $rows=6) {
	    if($id==''){$id=$name;}
		$attributs_class = $class? ' class="'. $class .'"' : '';
		return '<label for="'.$id.'"> '.$txt.' </label><br/>
		<textarea name="' . $name . '" id="'.$id.'" cols="' . $cols . '" rows="' . $rows . '" '.$attributs_class.'">' . htmlspecialchars($value) . '</textarea>';
	}
	
	// TEXTAREA
	static function textareabis($name, $id, $value, $style='', $class='') {
	     $attributs = '';
		$attributs .= $id? ' id="' . $id . '"' : '';
		$attributs .= $style? ' style="' . $style . '"' : '';
		$attributs .= $class? ' class="' . $class . '"' : '';
		return '<textarea name="' . $name . '"' . $attributs . '">' . htmlspecialchars($value) . '</textarea>';
	}
  
  static function textareasanssaisie($name, $value, $hauteur = 20) {
		return '<textarea name="' . $name . '" style = "border:0px; background-color:#FFFFFF;height:'.$hauteur.';">' . htmlspecialchars($value) . '</textarea>';
	}

	// HIDDEN FIELD
	static function hidden($name, $value, $id='') {
		$idStr = $id? ' id="' . $id . '"' : 'id="'.$name.'"';
		return '<input type="hidden" name="' . $name . '"' . $idStr . ' value="' . htmlspecialchars($value) . '" />';
	}

	// CHECKBOX
	static function checkbox($name, $checked, $txt='', $id='') {
		if($id==''){$id=$name;}
		$checked_param = $checked? ' checked="checked"' : '';
		$result= '<label for="'.$id.'"> '.$txt.' </label>';
		$result .= '<input type="checkbox" name="' . $name . '" id="'.$id.'" value="1"' . $checked_param . ' />';
		return $result;
	}

	// RADIO BUTTONS
	static function radio($name, $options, $selectedOption=null, $class='') {
		$result = '';
		foreach ($options as $value => $text) {
			$checked = ($value == $selectedOption)? ' checked="checked"' : '';
			$label = $name . '_' . $value;
			$result .= '<input type="radio" name="'.$name.'" class= "'.$class.'" id="' . $label . '" value="' . $value . '"' . $checked . ' />
			<label for="' . $label . '">' . $text . '</label> ';
	        
	}
		return $result;
	}

	// SELECT
	static function select($name, $options, $selectedOption=null, $txt='', $id='',$class='') {
	    if($id==''){$id=$name;}
		if(!strstr($class, 'largeur_petit'))$sauterLigne='<br/>';else$sauterLigne='';// Trop pourri à changer !! gaëlle
		$result =  '<label for="'.$id.'"> '.$txt.' </label>'.$sauterLigne;
		$result .= '<select name="' . $name . '" id="'.$id.'" class="'.$class.'">';
		foreach ($options as $value => $text) {
		  if (is_object($text)) { // Cas où la valeur doit être différente de l'indice
			$value = $text->value;
			$text = $text->text;
		  }
		 
			$selected = ($value == $selectedOption)? ' selected="selected"' : '';
			$result .= '<option value="' . $value . '"' . $selected . '>' . $text . '</option>';
		}
		$result .= '</select>';
		return $result;
	}

	// UPLOAD FILE
	static function file($name, $size=null) {
		$sizestr = ($size)? 'size="' . $size . '"' : '';
		return '<input type="file" name="' . $name . '" id="' . $name . '"' . $sizestr . ' />';
	}

	// DUP BUTTON
	static function dup_button($url) {
		return '<a href="' . htmlspecialchars($url) . '"><img src="../img/add.gif" alt="dupliquer" title="Dupliquer l\'article" /></a>';
	}

	// DEL BUTTON
	static function del_button($url) {
	
		return '<a href="' . htmlspecialchars($url) . '" onclick="return confirmerSuppression()">x</a>';
	}
	
	static function btn_valider($str='Valider'){
	  return '<input type="submit" value="'.$str.'" class="submit_button" />';
	}
	static function btn_validation($intitule, $class){
	  return '<input type="submit" value="'.$intitule.'" class="'.$class.'" />';
	}
	
	static function btn_supprimer(){
	 return '<input type="submit" 
	                value="Supprimer" 					
					class="submit_button supr_button" 
					onclick="if (confirm(\'confirmez vous la suppression ??\')){document.getElementById(\'action\').value=\'del\';this.form.submit();}"  					
			/> ';
	}
	
	static function ValiderEtSupprimer($AvecSupprimer, $editable=true){
	  if ($GLOBALS['id-connec']==10) {$strdisabled='disabled="disabled"';}else {$strdisabled='';}
	  $str ='<div id="barre_boutons">
	   <input type="submit" value="Valider" '.$strdisabled.'  class="submit_button" "/>';
	  if ($AvecSupprimer) { 
	   $str .='<input type="button" 
	                value="Supprimer" 	'.$strdisabled.' 				
					class="submit_button supr_button" 
					onclick="if (confirm(\'confirmez vous la suppression ??\')){document.getElementById(\'action\').value=\'del\';this.form.submit();}"  					
			/>';
	  }			
		$str.='</div> <div style="clear:both"></div>';
	   ;
	   return $str;
	}
  
 // DEL IMPOSSIBLE BUTTON
	static function del_impossible_button($message) { 
		return '<img src="../img/delimp.gif" alt="suppression impossible" onclick="return MessageSuppressionImpossible(\''.htmlspecialchars($message).'\'); " title="Suppression impossible" />';
	}
	//<input type="hidden" name="$name" id="$name" value="$date" />
	// CALENDAR
	static function calendar($name, $date, $class='', $txt='') {
	  
		$dateStr = preg_replace("/(\d+)-(\d+)-(\d+)/", "$3/$2/$1", $date);
		print <<<END
<label for="datepicker"> $txt </label>		
<input id="datepicker" type="datepicker"  name="$name"  class="$class" value="$dateStr"/><br/>


END;
	}
	
	// CALENDAR
	static function calendar2($id, $name, $date, $class='') {
	   
		$dateStr = $date;//preg_replace("/(\d+)-(\d+)-(\d+)/", "$3/$2/$1", $date);
		print <<<END
		
          <input id="$id" type="datepicker"  name="$name" class="$class" value="$dateStr"/>

END;
	}
}
?>
