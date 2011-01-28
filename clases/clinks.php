<?php

require_once('cdatabase.php');
require_once('cinmueble.php');
require_once('error_logger.inc.php');


class Clinks
{
	private $m_idiomes = array(
		'es' => array(
			'registro' => 'registro',
			'soporte' => 'soporte',
			'calculadora' => 'calculadora-hipotecas',
			'mapa-web' => 'mapa-web',
			'olvido' => 'olvido-contrasena',
			'aviso' => 'aviso-error',
			'contacto-agencias' => 'contacto-agencias',
			'contacto-promotores' => 'contacto-promotores',
			'consulta' => 'consulta-online',
			'legal' => 'condiciones-legales',
			
			'listado' => 'listado',
			'mapa' => 'mapa',
			
			
			'venta' => 'venta',
			'compra' => 'venta',
			'alquiler' => 'alquiler',
			
			'promotores' => 'promotores',
			'agencias' => 'agencias',
			
			
			'viviendas' => 'viviendas',
			'promociones' => 'obra-nueva',
			'casas' => 'casas',
			'chalets' => 'chalets',
			'pisos' => 'pisos',
			'aticos' => 'aticos',
			'duplex' => 'duplex',
			'apartamentos' => 'apartamentos',
			'estudios' => 'estudios',
			'locales' => 'locales',
			'naves' => 'naves',
			'garajes' => 'garajes',
			'terrenos' => 'terrenos',
			'oficinas' => 'oficinas',
			
			'vivienda' => 'vivienda',
			'promocion' => 'obra-nueva',
			'obra_nueva' => 'obra-nueva',
			'casa' => 'casa',
			'chalet' => 'chalet',
			'piso' => 'piso',
			'atico' => 'atico',
			'duplex' => 'duplex',
			'apartamento' => 'apartamento',
			'estudio' => 'estudio',
			'local' => 'local',
			'nave' => 'nave',
			'garaje' => 'garaje',
			'terreno' => 'terreno',
			
			'zona' => 'zona',
			'multizonas' => 'multizonas',
			'lista-profesionales' =>'lista-profesionales'
		),
		'ca' => array(
			'registro' => 'registre',
			'soporte' => 'suport',
			'calculadora' => 'calculadora-hipoteques',
			'mapa-web' => 'mapa-web',
			'olvido' => 'oblid-contrassenya',
			'aviso' => 'avis-error',
			'contacto-agencias' => 'contacte-agencies',
			'contacto-promotores' => 'contacte-promotors',
			'consulta' => 'consulta-online',
			'legal' => 'condicions-legals',
			
			'listado' => 'llistat',
			'mapa' => 'mapa',
			
			
			'venta' => 'venda',
			'compra' => 'venda',
			'alquiler' => 'lloguer',
			
			'promotores' => 'promotors',
			'agencias' => 'agencies',
			
			
			'viviendas' => 'habitatges',
			'promociones' => 'obra-nova',
			'casas' => 'cases',
			'chalets' => 'xalets',
			'pisos' => 'pisos',
			'aticos' => 'atics',
			'duplex' => 'duplex',
			'apartamentos' => 'apartaments',
			'estudios' => 'estudis',
			'locales' => 'locals',
			'naves' => 'naus',
			'garajes' => 'garatges',
			'terrenos' => 'terrenys',
			'oficinas' => 'oficines',
			
			'vivienda' => 'habitatge',
			'promocion' => 'obra-nova',
			'obra_nueva' => 'obra-nova',
			'casa' => 'casa',
			'chalet' => 'xalet',
			'piso' => 'pis',
			'atico' => 'atic',
			'duplex' => 'duplex',
			'apartamento' => 'apartament',
			'estudio' => 'estudi',
			'local' => 'local',
			'nave' => 'nau',
			'garaje' => 'garatge',
			'terreno' => 'terreny',
			
			'zona' => 'zona',
			'multizonas' => 'multizones',
			'lista-profesionales' =>'llista-profesionals'
		),
		'en' => array(
			'registro' => 'register',
			'soporte' => 'support',
			'calculadora' => 'hipotec-calculator',
			'mapa-web' => 'web-map',
			'olvido' => 'forget-password',
			'aviso' => 'error-warning',
			'contacto-agencias' => 'agencys-contact',
			'contacto-promotores' => 'promotors-contact',
			'consulta' => 'online-conference',
			'legal' => 'legal-conditions',
			
			'listado' => 'list',
			'mapa' => 'map',
			
			
			'venta' => 'sale',
			'compra' => 'sale',
			'alquiler' => 'rental',
			
			'promotores' => 'promotors',
			'agencias' => 'agencies',
			
			
			'viviendas' => 'housings',
			'promociones' => 'new-building',
			'casas' => 'houses',
			'chalets' => 'chalets',
			'pisos' => 'flats',
			'aticos' => 'attics',
			'duplex' => 'duplex',
			'apartamentos' => 'apartaments',
			'estudios' => 'studies',
			'locales' => 'locals',
			'naves' => 'warehouses',
			'garajes' => 'parkings',
			'terrenos' => 'lands',
			'oficinas' => 'offices',
			
			'vivienda' => 'housing',
			'promocion' => 'new-building',
			'obra_nueva' => 'new-building',
			'casa' => 'house',
			'chalet' => 'chalet',
			'piso' => 'flat',
			'atico' => 'attic',
			'duplex' => 'duplex',
			'apartamento' => 'apartment',
			'estudio' => 'study',
			'local' => 'local',
			'nave' => 'warehouse',
			'garaje' => 'parking',
			'terreno' => 'land',
			
			'zona' => 'zone',
			'multizonas' => 'multizones',
			'lista-profesionales' =>'profesional-list'
		)
	);
	private $m_lng;
	
	function Clinks()
	{
		$lng = $_SERVER['HTTP_HOST'];
		switch($lng)
		{
			case 'ca.dingdom.com':
				$this->m_lng='ca';break;
			case 'en.dingdom.com':
				$this->m_lng='en';break;
			default:
				$this->m_lng='es';
		}
	}
	
	function get_listado($id_accion=0,$id_tipo=0,$id_lugar=0,$cod_lng='',$es_lugar=true,$link_a_mapa=false,$nombre_accion='',$nombre_tipo='',$nombre_lugar='',$nombre_lugar_padre=-1,$pagina='1')
	{
		if($cod_lng!='') $this->m_lng=$cod_lng;
		
		if($nombre_accion)
		{
			$str_accion=$this->m_idiomes[$this->m_lng][$nombre_accion];
		}
		else 
		{
			if($id_accion==1)
			{
				$str_accion=$this->m_idiomes[$this->m_lng]['alquiler'];
			}
			if($id_accion==2)
			{
				$str_accion=$this->m_idiomes[$this->m_lng]['venta'];
			}
			else 
			{
				$str_accion=$this->m_idiomes[$this->m_lng][Cinmueble::get_nombre_accion_from_id($id_accion)];
			}
		}
		
		if($nombre_tipo)
		{
			$str_tipo=$this->m_idiomes[$this->m_lng][$nombre_tipo];
		}
		else 
		{
			$str_tipo=$this->m_idiomes[$this->m_lng][Cinmueble::get_inmueble_type_string($id_tipo)];
		}
		
		if($nombre_lugar)
		{
			$str_lugar=treureCaractersEspecials($nombre_lugar);
		}
		else 
		{
			$stripped_lugar=Cinmueble::get_stripped_from_id($id_lugar,!$es_lugar);
			$str_lugar=substr($stripped_lugar,(strpos($stripped_lugar,'-')+1));
		}
		
		if($nombre_lugar_padre!==-1)
		{
			$str_lugar_padre=$nombre_lugar_padre;
		}
		else
		{
			$nivel=Cinmueble::get_tipo_lugar_from_id($id_lugar);
			$str_lugar_padre='';
			if($nivel>=5 || !$es_lugar)
			{
				$stripped_lugar=$id_lugar.'-'.$str_lugar;
				$str_stripped=Cinmueble::get_stripped_padre_lugar_from_stripped($stripped_lugar,$es_lugar);
				$str_lugar_padre=substr($str_stripped,(strpos($str_stripped,'-')+1));
			}
		}
		
		if($link_a_mapa) $str=$this->m_idiomes[$this->m_lng]['mapa'];
		else $str=$this->m_idiomes[$this->m_lng]['listado'];
		
		if($str_lugar_padre!='')
		{
			$res="/".$str."/".$str_accion."/".$str_tipo."/".$str_lugar_padre."/".$str_lugar."/".$id_lugar."/";
		}
		else 
		{
			$res="/".$str."/".$str_accion."/".$str_tipo."/".$str_lugar."/".$id_lugar."/";
		}
		
		//si es llistat safageix pagina
		if(!$link_a_mapa && $pagina>1)
		{
			$res.="$pagina/";
		}
		
		return $res;
	}
	
	function get_ficha($cod,$cod_lng='',$sin_ref=false)
	{
		if($cod_lng!='') $this->m_lng=$cod_lng;
		
		$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER);
		
		if(eregi('^R[0-9]+$',$cod))
		{
			$query="SELECT i.direccion,a.accion as accion,t.nombre as tipo,lp.nombre as nombre_padre,l.nombre as lugar,lp.id_tipo_lugar as tipo_lugar_padre,i.visibilidad FROM inmuebles i,tipos_inmueble t,acciones a,lugares_2 l,lugares_2 lp WHERE i.referencia_publica='".strtoupper($cod)."' AND i.id_tipo=t.id AND i.id_accion=a.id AND i.id_lugar=l.id AND l.id_padre=lp.id";
			$res=$con->fetch_one_result($query);
			if(count($res)>1)
			{
				if($res['visibilidad']=='1' || $res['visibilidad']=='2')
				{
					$street=treureCaractersEspecials(html_entity_decode($res['direccion'],ENT_QUOTES,"UTF-8")).'/';
				}
				else $street='';
				
				$first=$this->m_idiomes[$this->m_lng][$res['tipo']]."-".$this->m_idiomes[$this->m_lng][$res['accion']];
				$second=treureCaractersEspecials($res['nombre_padre'])."-".treureCaractersEspecials($res['lugar']);
				$third=$street;
				
				$str_res="/$first/$second/$third".(($sin_ref)?"":"$cod/");
			}
			else $str_res='';
		}
		else if(eregi('^P[0-9]+$',$cod))
		{
			$query="SELECT p.direccion,lp.nombre as nombre_padre,l.nombre as lugar,lp.id_tipo_lugar as tipo_lugar_padre FROM promociones p,lugares_2 l,lugares_2 lp WHERE p.referencia_publica='".strtoupper($cod)."' AND p.id_lugar=l.id AND lp.id=l.id_padre";
			$res=$con->fetch_one_result($query);
			if(count($res)>1)
			{
				$street=treureCaractersEspecials(html_entity_decode($res['direccion'],ENT_QUOTES,"UTF-8"));
				
				$first=$this->m_idiomes[$this->m_lng]['promocion'];
				$second=treureCaractersEspecials($res['nombre_padre'])."-".treureCaractersEspecials($res['lugar']);
				$third=$street;
				
				$str_res="/$first/$second/$third/".(($sin_ref)?"":"$cod/");
			}
			else $str_res='';
		}
		else $str_res='';
		
		return $str_res;
	}
	
	
	function get_profesional($cod_lng='',$id_profesional,$id_accion=2,$pagina=1)
	{
		if($cod_lng!='') $this->m_lng=$cod_lng;
		
		if($id_accion==1)
		{
			$str_accion='alquiler';
		}
		else if($id_accion==2)
		{
			$str_accion='venta';
		}
		else if($id_accion==3)
		{
			$str_accion='promociones';
		}
		else if($id_accion==0)
		{
			$str_accion='';
		}
		
		$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
		$query="SELECT t.nombre as tipo,u.nombre FROM usuarios u,tipos_usuarios t WHERE u.id=$id_profesional AND t.id=u.id_tipos_usuarios";
		$res=$con->fetch_one_result($query);
		
		if(count($res)>1) 
		{
			if($str_accion!='')
			{
				$str_res="/".$this->m_idiomes[$this->m_lng][$res['tipo']]."/".treureCaractersEspecials($res['nombre'])."/".$this->m_idiomes[$this->m_lng][$str_accion]."/$id_profesional/";
			}
			else 
			{
				$str_res="/".$this->m_idiomes[$this->m_lng][$res['tipo']]."/".treureCaractersEspecials($res['nombre'])."/$id_profesional/";
			}
			if($pagina>1)
			{
				$str_res.="$pagina/";
			}
		}
		else $str_res='';
		
		return $str_res;
	}
	
	
	
	function get($cod_lng='',$cod_link)
	{
		$res='/';
		if($cod_lng!='') $this->m_lng=$cod_lng;
		if($cod_link!='') $res.=$this->m_idiomes[$this->m_lng][$cod_link]."/";
		
		return $res;
	}
	
	function get_aviso($cod,$cod_lng='')
	{
		if($cod_lng!='') $this->m_lng=$cod_lng;
		return "/".$this->m_idiomes[$this->m_lng]['aviso']."/$cod/";
	}
	
	function get_mapaweb($cod_lng='',$accion,$tipo)
	{
		if($cod_lng!='') $this->m_lng=$cod_lng;
		return "/".$this->m_idiomes[$this->m_lng]['mapa-web']."/".$this->m_idiomes[$this->m_lng][$accion]."/".$this->m_idiomes[$this->m_lng][$tipo]."/";
	}
	
	function get_mapa_web_profesionales($cod_lng)
	{
		if($cod_lng!='') $this->m_lng=$cod_lng;
		return "/".$this->m_idiomes[$this->m_lng]['mapa-web']."/".$this->m_idiomes[$this->m_lng]['lista-profesionales']."/";
	}
	
	function get_mapaweb_profesionales_lugar($cod_lng='',$id_lugar,$nombre_lugar)
	{
		if($cod_lng!='') $this->m_lng=$cod_lng;
		return "/".$this->m_idiomes[$this->m_lng]['mapa-web']."/".$this->m_idiomes[$this->m_lng]['lista-profesionales']."/$nombre_lugar/$id_lugar/";
	}
	
	function idiomes($cod,$lng='')
	{
		if($lng!='') $this->m_lng=$lng;
		return $this->m_idiomes[$this->m_lng][$cod];
	}
}





?>
