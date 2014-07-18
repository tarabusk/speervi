<?php require_once('../../classes/form.class.php'); ?>


<?php if($GLOBALS['id-connec']<2){ ?>
	<a class="ajouter_liste" href="<?php echo htmlspecialchars($this->url . '&action=add') ?>"><?php echo 'Ajouter ' .$this->nom_sing; ?></a>
 <?php } ?>
 
<form name="formulaire_liste" method="post" action="<?php echo htmlspecialchars($this->url . '&action=list_apply') ?>">
	<table class="liste_articles">
		<thead>
			<tr>				
				<th width="400"><?php echo 'Liste des '. $this->nom_plur.' du menu principal'; ?></th>				
			</tr>
		</thead>
		<tbody>
			<?php foreach ($this->articles as $article){
			  if ($article->menu_principal){?>
			<?php $urlPage = $this->url . '&page=' . $article->id ; ?>
			<tr <?php echo ($this->page == $article->id)? ' class="active"' : (!$article->online? ' class="offline"' : '') ?>>
				<?php if ($article->id_page_mere >0){$lEspace='&nbsp;&nbsp;&nbsp;&nbsp;&rarr;&nbsp;';$LeStyle='font-size:11px;';}else{$lEspace='&bull;&nbsp;';$LeStyle='';}?>
				<td class="titre_article"><a style="<?php echo $LeStyle; ?>" href="<?php echo htmlspecialchars($urlPage) ?>"><?php echo $lEspace.$article->titre_menu.' ' ?></a></td>
				
			</tr>
			<?php }} ?>
		</tbody>
	</table>
	<br/>
	<table class="liste_articles">
		<thead>
			<tr>				
				<th width="400"><?php echo 'Liste des '. $this->nom_plur.' annexes'; ?></th>				
			</tr>
		</thead>
		<tbody>
			<?php foreach ($this->articles as $article){ 
			   if (!$article->menu_principal){?>
			<?php $urlPage = $this->url . '&page=' . $article->id ; ?>
			<tr <?php echo ($this->page == $article->id)? ' class="active"' : (!$article->online? ' class="offline"' : '') ?>>
				<?php if ($article->id_page_mere >0){$lEspace='&nbsp;&nbsp;&nbsp;&nbsp;&rarr;&nbsp;';$LeStyle='font-size:11px;';}else{$lEspace='&bull;&nbsp;';$LeStyle='';}?>
				<td class="titre_article"><a style="<?php echo $LeStyle; ?>" href="<?php echo htmlspecialchars($urlPage) ?>"><?php echo $lEspace.$article->titre_menu.' ' ?></a></td>
				
			</tr>
			<?php } } ?>
		</tbody>
	</table>
   
</form>
