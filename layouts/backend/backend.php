<div  id='bcontainer'>

<div id='btop'>
	<?php echo $this->include_views('top', $this->m_top)."\n" ; ?>
</div><!-- end ftop -->

<div id='bmenu'>
	<?php echo $this->include_views('menu', $this->m_menu) ."\n" ; ?>
</div><!-- end fmenu -->

<div id='bmain'>
	<?php echo $this->include_views('main', $this->m_main)."\n" ; ?>
</div> <!-- end fmain -->

<div id='bfooter'>
	<?php echo $this->include_views('footer', $this->m_footer)."\n" ; ?>
</div>	<!-- end ffoter -->
	
</div><!-- end fcontainer -->

<?php 
	if ( DEVELOPER_CONSOLE ) {
		Cdeveloper_console::show_developer_console();
	}
?>

