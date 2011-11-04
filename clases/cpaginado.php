<?php

require_once(PATH_ROOT_CLASES . 'clocation.php');
require_once(PATH_ROOT_CLASES . 'cutils.php');
require_once(PATH_ROOT_CLASES . 'clanguage.php');

class Cpaginado
{
	private $m_max;
	private $m_pag;
	private $m_ultimaPag;
	private $m_params;
	private $m_amb_ajax;
	private $m_layout;
	private $m_url;
	private $m_posofpaginate;

	function Cpaginado($max,$pag,$numeroDeFiles,$params_get=array(),$layout='frontend', $posofpaginate=1)
	{
		$this->m_max = $max;
		$this->m_pag = $pag;
		$this->m_ultimaPag = ($max<1) ? 0 : ceil($numeroDeFiles/$max);
		$this->m_params = $params_get;
		$this->m_layout = $layout;
		$this->m_posofpaginate = $posofpaginate;
		
		if($this->m_pag>$this->m_ultimaPag || $this->m_pag<1) $this->m_pag=1;
	}
	
	public function RetornaPaginatLlistat($pagina='',$amb_ajax=false,$url='')
	{
		$this->m_amb_ajax = $amb_ajax;
		$this->m_url=$url;
		$result = "";
		
		$lng = Cutils::get_actual_lng();
		$lang = new Clanguage($lng);
		
		$num_pags = $this->m_ultimaPag;
		$pag = $this->m_pag;
		
		if($num_pags>1)
		{
			if($amb_ajax) $result .= "<script>var json_params=".json_encode($this->m_params).";</script>";
			
			$result .= "<div id='paginat'>";
			
			if($pag>1)
			{
				$this->m_params['pag']=($pag-1);
				if($amb_ajax) $result .= "<span class='paginat_item paginat_seleccionable' onClick=\"PasaPagina('".($pag-1)."')\">&lt; ".strtolower($lang->get_element_generic('anterior'))."</span>";
				else $result .= "<span><a class='paginat_item paginat_seleccionable' href='".$this->CreaUrlListado($pag-1)."'>&lt; ".strtolower($lang->get_element_generic('anterior'))."</a></span>";
			}
			
			if($num_pags<=6)
			{
				//Si només hi ha 6 pagines, es mostren totes
				for($i=1;$i<=$num_pags;$i++)
				{
					$result .= ($i==$pag) ? "<span class='paginat_item paginat_actual'>$i</span>" : $this->CreaLink($i,$pagina)." ";
				}
			}
			else
			{
				//si hi ha mes de 6 pagines.. es mostra el [...]
				if(($pag+3)<$num_pags && ($pag-3)>1)
				{
					// [...] dabant i radera
					$result .= $this->CreaLink(1,$pagina)."<span class='paginat_no_seleccionable_button'>...</span>";
					for($i=$pag-1;$i<=$pag+2;$i++)
					{
						$result .= ($i==$pag) ? "<span class='paginat_item paginat_actual'>$i</span>" : $this->CreaLink($i,$pagina);
					}
					$result .= "<span class='paginat_no_seleccionable_button'>...</span>".$this->CreaLink($num_pags,$pagina);
				}
				else if($pag-3>1)
				{
					// [...] nomes dabant
					$result .= $this->CreaLink(1,$pagina)."<span class='paginat_no_seleccionable_button'>...</span>";
					for($i=$num_pags-4;$i<=$num_pags;$i++)
					{
						$result .= ($i==$pag) ? "<span class='paginat_item paginat_actual'>$i</span>" : $this->CreaLink($i,$pagina);
					}
				}
				else if($pag+3<$num_pags)
				{
					// [...] nomes radera
					for($i=1;$i<=5;$i++)
					{
						$result .= ($i==$pag) ? "<span class='paginat_item paginat_actual'>$i</span>" : $this->CreaLink($i,$pagina);
					}
					$result .= "<span class='paginat_no_seleccionable_button'>...</span>".$this->CreaLink($num_pags,$pagina);
				}
			}
			
			if($pag<$num_pags)
			{
				$this->m_params['pag']=($pag+1);
				if($amb_ajax) $result .= "<span class='paginat_item paginat_seleccionable' onClick=\"PasaPagina('".($pag+1)."')\">".strtolower($lang->get_element_generic('siguiente'))." &gt;</span>";
				else $result .= "<span><a class='paginat_item paginat_seleccionable' href='".$this->CreaUrlListado($pag+1)."'>".strtolower($lang->get_element_generic('siguiente'))." &gt;</a></span>";
			}
			
			$result .= "</div>";
		}
		return $result;
	}
	private function CreaLink($num_pag,$pagina)
	{
		$retorn = "";
		$this->m_params['pag']=$num_pag;
		if($this->m_amb_ajax) $retorn .= "<span class='paginat_item paginat_seleccionable' onClick=\"PasaPagina('$num_pag')\">$num_pag</span>";
		else $retorn .= "<span><a class='paginat_item paginat_seleccionable' href='".$this->CreaUrlListado($num_pag)."'>$num_pag</a></span>";
		return $retorn;
	}
	private function CreaUrlListado($pag)
	{
		$resultat = "";
		
		if($this->m_url!='')
		{
			$url=$this->m_url;
		}
		else $url=htmlentities($_SERVER['REQUEST_URI'],ENT_QUOTES);
		
		
		//traiem parametres de la url
		$pos=strpos($url,'?');
		if($pos!==false)
		{
			$url=substr($url,0,$pos);
		}
		
		
		if ($this->m_posofpaginate == 1){
		  
		  if(eregi('/[0-9]+/$',$url)){
		    
  			$pos=strrpos($url,'/',-2);
  			$url=substr($url,0,$pos+1);
  			$url.=($pag>1)?"$pag/":"";		
  			  
  		}else{
  		  
  		  //si no hi ha pag, l'afegim
  			$url.=($pag>1)?"$pag/":"";
  			
  		}
  		
		} else if ($this->m_posofpaginate == 2){
		  
		  if(eregi('/[0-9]+/[0-9]+/$',$url)){
		    
  			$pos=strrpos($url,'/',-2);
  			$url=substr($url,0,$pos+1);
  			$url.=($pag>1)?"$pag/":"";  
  			
		  }else{
		    
		  //si no hi ha pag, l'afegim
			$url.=($pag>1)?"$pag/":"";
		  
		  }
		  
		}
	   
		/*
		//crea array de parametres per afegirlus a la url
		$params=array();
		foreach($_GET as $key=>$val)
		{
			if($key!='categoria_id' && $key!='pag')
			{
				$params[htmlentities($key,ENT_QUOTES)]=htmlentities($val,ENT_QUOTES);
			}
		}*/
		
		$params=array();
		//crea array de parametres per afegirlus a la url
		foreach($this->m_params as $key=>$val)
		{
			if($key!='pag')
			{
				$params[htmlentities($key,ENT_QUOTES)]=htmlentities($val,ENT_QUOTES);
			}
		}		
		
		$resultat = Clocation::go_to_location($url,$params,'frontend');
		
		return $resultat;
	}
	

	public function RetornaPaginat($layout='frontend')
	{//Funció que retorna el navegador de paginat "< 1 2 3 ... >" per canviar de pàgina.
		$result = "";
		$max = $this->m_max;
		$ultimaPag = $this->m_ultimaPag;
		$pag=$this->m_pag;
		$this->m_layout=$layout;

		if($max>0 && $ultimaPag>1)
		{
			$result .= "<div id='paginat'>";
			
			if($ultimaPag<=6)
			{//si hi ha menys de 6 pagines..
				$result .= $this->Anterior();
				for($i=1;$i<=$ultimaPag;$i++)
				{
					$result .= $this->gotoloc($i);
				}
				$result .= $this->Seguent();
			}
			else
			{//si hi ha mes de 6 pagines..
				if($pag<5)
				{//si esta seleccionada la pag de 1-3..
					$result .= $this->Anterior();
					for($i=1;($i<=4 && $i<=$ultimaPag);$i++)
					{
						$result .= $this->gotoloc($i);
					}
					if($ultimaPag>5) $result .= "<span class='paginat_no_seleccionable_button'>...</span>".$this->GoTo($ultimaPag);
					$result .= $this->Seguent();
			
				}
				else if(($pag+3)>=$ultimaPag)
				{//si esta seleccionada una de les 4 ultimes pagines..
					
					$result .= $this->Anterior();
					$result .= $this->gotoloc(1)."<span class='paginat_no_seleccionable_button'>...</span>";
					
					for ($i=($ultimaPag-3);$i<=$ultimaPag;$i++)
					{
						$result .= $this->gotoloc($i);
					}
					$result .= $this->Seguent();
					
				}
				else
				{//si estan seleccionades les altres.. (les del mig)
					$primerNum = ($this->m_pag==$ultimaPag) ? ($this->m_pag - 3) : ($this->m_pag-2);
					
					//seleccionada pagina >= 4
					
					$result .= $this->Anterior();
					$result.=$this->gotoloc(1)."<span class='paginat_no_seleccionable_button'>...</span>";
					$primerNum = ($this->m_pag==$ultimaPag) ? ($this->m_pag-2) : ($this->m_pag-1);
					
					for ($i=$primerNum;$i<$primerNum+3;$i++)
					{
						$result .= $this->gotoloc($i);
					}
					$result .= "<span class='paginat_no_seleccionable_button'>...</span>".$this->gotoloc($ultimaPag);
					$result .= $this->Seguent();
					
				}
				
			}
			$result .= "</div>";
		}
		return $result;
	}


	private function Primer()
	{
		return ($this->m_pag>1) ? "<span class='paginat_seleccionable_button paginat_seleccionable' onClick=\"location.href='".$this->CreaURL(1)."'\"><img src='".PATH_ADMIN_IMG."generic/icon_first.jpg' border='0'> </span>" : "<span class=' paginat_no_seleccionable_button'><img src='".PATH_ADMIN_IMG."generic/icon_first.jpg' border='0'></span>";
	}
	private function Ultim()
	{
		return ($this->m_pag<$this->m_ultimaPag) ? "<span class='paginat_seleccionable_button paginat_seleccionable' onClick=\"location.href='".$this->CreaURL($this->m_ultimaPag)."'\"> <img src='".PATH_ADMIN_IMG."generic/icon_last.jpg' border='0'></span>" : "<span class='paginat_no_seleccionable_button'> <img src='".PATH_ADMIN_IMG."generic/icon_last.jpg' border='0'></span>";
	}
	private function Anterior()
	{
		return ($this->m_pag>1) ? "<span class='paginat_seleccionable_button paginat_seleccionable' onClick=\"location.href='".$this->CreaURL($this->m_pag-1)."'\"> <img src='".PATH_ADMIN_IMG."generic/icon_previous.jpg' border='0'> </span>" : "<span class='paginat_no_seleccionable_button'> <img src='".PATH_ADMIN_IMG."generic/icon_previous.jpg' border='0'> </span>";
	}
	private function Seguent()
	{
		return ($this->m_pag<$this->m_ultimaPag) ? "<span class='paginat_seleccionable_button paginat_seleccionable' onClick=\"location.href='".$this->CreaURL($this->m_pag+1)."'\"> <img src='".PATH_ADMIN_IMG."generic/icon_next.jpg' border='0'>  </span>" : "<span class='paginat_no_seleccionable_button'> <img src='".PATH_ADMIN_IMG."generic/icon_next.jpg' border='0'> </span>";
	}
	private function gotoloc($num_pag)
	{
		return ($this->m_pag==$num_pag) ? "<span class='paginat_item paginat_actual'>$num_pag</span>" : "<span class='paginat_item paginat_seleccionable' onClick=\"location.href='".$this->CreaURL($num_pag)."'\">$num_pag</span>";
	}


	private function CreaURL($pag='',$max='')
	{
		$resultat = "";
		$parametres = $this->parametres_to_array(Clocation::get_parameters_string());
		if(count($this->m_params)>0) $parametres=array_merge($this->m_params,$parametres);
		
		if($this->m_layout=='frontend')
		{
			unset($parametres['accion']);
			unset($parametres['cod']);
			
			if($pag!='') $parametres['pag'] = $pag;
			if($max!='') $parametres['max'] = $max;
			
			$aux=explode('?',$_SERVER['REQUEST_URI']);
			$direRetorn=$aux[0];
		}
		else
		{
			if($pag!='') $parametres['pag'] = $pag;
			if($max!='') $parametres['max'] = $max;
			$direRetorn='';
		}
		
		$resultat = Clocation::go_to_location($direRetorn,$parametres,$this->m_layout);
		
		return $resultat;
	}
	
	private function parametres_to_array($urlParametres)
	{
		if($urlParametres!='')
		{
			$auxArray = explode('&',$urlParametres);
			$result = array();
			
			foreach ($auxArray as $val)
			{
				$aux2 = explode('=',$val);
				if($aux2[0]!='hk') $result[$aux2[0]] = $aux2[1];
			}
		}
		else $result = array();
		
		return $result;
	}
}
?>
