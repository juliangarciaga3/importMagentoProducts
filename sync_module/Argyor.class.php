<?php

class Argyor{

	#ATTRS
	private $csv='';
	private $categories=array(
		2,            #Default Category

	        42,				#Iluminacion interior
	        
	        	48,				#Apliques
	        	49,				#Plafones
				50,				#Lampara Mesa
				51,				#Lampara Pie
				52,				#Apliques Cuadrados
				75,				#Apliques Lectura
				76,				#Apliques Pared
				77,				#Sobremesa
				78,				#Colgantes
				79,				#Focos Pared y Techo
				80,				#Carril
				81,				#Ilumina Cuadros
				82,				#Empotrables
				83,				#Flexo
				
			43,					#Iluminacion exterior
			
				53,				#Balizas
				54,				#Apliques Pared
				55,				#Colgantes
				68,				#Plafones
				69,				#Empotrables Suelo
				70,				#Empotrables Pared
				71,				#Proyectores
				72,				#Picas Jardin
				73,				#Sobremuros
				74,				#Farolas
				
			44,					#Iluminacnion Tecnica
			
				56,				#Empotrable
				57,				#Suspension
				58,				#Superficie
				59,				#Carril
			
			45,					#Linea profesional
			
				60,				#Carril
				61,				#Empotrar
				62,				#Superficie
				63,				#Colgante
			
			46,					#Ventiladores de techo
			
				64,				#Ventiladores con luz
				65,				#Ventiladores sin luz
				66,				#Ventiladores exterior
				67,				#Ventiladores Motor DC
			
			47,					#Bombillas
			41,					#Diseñadores
			
				00,				#Alegre Design
				00,				#Alex & Manuel Llusca
				00,				#Conillas
				00,				#Estudi Ribaudi
				00,				#Faro Team
				00,				#Jordi Blasi
				00,				#Jordi
				00,				#Jordi Busquets
				00,				#Marina Mila
				00,				#Nahtrang
				00,				#Pepe Llaudet
				00,				#zJer Studio

				

				
				
	);

    	public function __construct(){}
    
	
	#METHODS
	private function categorizeObj($obj){
		$obj->categorias=array($this->categories[0]);
		$name=strtolower($obj->Family);
		$pro=strpos($name, 'PRO')!==false;
		$out=strpos($name, 'OUT')!==false;
		$web=strpos($name, 'WEB')!==false;
		$dress=strpos($name, 'DRESS')!==false;
		    
		
		if($pro) $obj->categorias[]=$this->categories[32]; 				// Linea Profesional
		if($out) $obj->categorias[]=$this->categories[16];
		//if($medal) $obj->categorias[]=$this->categories[4];
		
		return $obj;
	}
	

	public function descargar($rutaLocal, $rutaImagen){
		$remote_file_url = $rutaImagen;
		$downloadedFileName = $rutaLocal;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $remote_file_url);
		$downloadedFile = fopen($downloadedFileName, 'w+');
		curl_setopt($ch, CURLOPT_FILE, $downloadedFile);
		curl_exec ($ch);
		
		curl_close ($ch);
		fclose($downloadedFile);
		
	}
	
	public function parseCSV($nombre_archivo_csv){
	

		// Descargo el fichero y lo guardo como argyor.csv //////////////////
		//$remote_file_url = 'http://clientes.argyor.com/descargas/d0886a2a6736937911e3d0b068d951ce';
		$remote_file_url = $nombre_archivo_csv;
		$downloadedFileName = "argyor.csv";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $remote_file_url);
		$downloadedFile = fopen($downloadedFileName, 'w+');
		curl_setopt($ch, CURLOPT_FILE, $downloadedFile);
		curl_exec ($ch);
		
		curl_close ($ch);
		fclose($downloadedFile);
		
		$csv = file_get_contents('./argyor.csv', FILE_USE_INCLUDE_PATH);
		
		///////////////////////////////////////////////////////////////////
		
		$res=array();
		$rows=explode("\n", $csv);
		$labels=explode(';', $rows[0]);
		$priceComul;
		
		for($u=0; $u<count($labels); $u++){
			if($labels[$u]==='PVP') $priceColum=$u;
		}
		//echo $priceColum;
		for($i=1; $i<count($rows); $i++){			//Coge la fila de la tabla y separa los segmentos por ; obteniendo el campo
			var_dump($data);
			$data=explode(';', $rows[$i]); 
			if($data[0]=='') continue;				//Si el SKU esta vacio salta al siguiente (Quitar ; Error)
			
			
			//create base object skipping 'disponibilidad' and 'precio_minimo' attributes
			$obj=new stdClass();					//Crea un objeto anonimo para establecer propiedades 
			
			for($j=0; $j<count($data); $j++){
				/////////////////////////////////// Cojo la imagen que es la posicion 8
				if($j===20)	$obj->imagen=$data[$j];
				/////////////////////////////////// Cojo el precio que es la posicion 9
				if($j===17)	$obj->PVP=$data[$j];
                /////////////////////////////////// Cojo disponibilidad que es la posicion 7
                if($j===16) $obj->Quantity=$data[$j];
				
			
				$label=trim($labels[$j]);
				if(in_array($label, array('imagen','PVP','Quantity'))) continue;
				$obj->{$label}=trim(($data[$j]));
			}
			//print_r($data);die; //Lo que contiene el array datos
			//$obj=$this->categorizeObj($obj);
			//var_dump($obj);
			//add to res array
			
			$model=$obj->Reference;
			if(isset($res[$obj->Reference])){
				$res[$obj->Reference]->subReferences[$obj->subReference]=floatval($obj->PVP);
			}
			else{
				$obj->subReferences=array($obj->subReference=>floatval($obj->PVP));
				unset($obj->subReference);
				//unset($obj->PVP);
				unset($obj->Reference);
				$res[$model]=$obj;
			}
		}
		
		//calculate base price and pluses
		foreach($res as $model => $info){
			$prices=array();
			foreach($info->subReferences as $price) $prices[]=$price;
			
			$min=min($prices);
			
			$res[$model]->PVP=$min;
			foreach($info->subReferences as $m => &$p) $p=$p-$min;
		}
		return $res;
	}

    public function test(){
        #$catalog=$this->parseCSV();
        #Kint::dump($catalog['(18)74R0057']);
    }
	public function attributeValueExists($arg_attribute, $arg_value)
	{
	    $attribute_model        = Mage::getModel('eav/entity_attribute');
	    $attribute_options_model= Mage::getModel('eav/entity_attribute_source_table') ;
	
	    $attribute_code         = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
	    $attribute              = $attribute_model->load($attribute_code);
	
	    $attribute_table        = $attribute_options_model->setAttribute($attribute);
	    $options                = $attribute_options_model->getAllOptions(false);
	
	    foreach($options as $option)
	    {
	        if ($option['label'] == $arg_value)
	        {
	            return $option['value'];
	        }
	    }
	
	    return false;
	}
    /*
    *
    * En esta funcion introducimos el codigo del atributo y las palabras que se asignaran
    * a ese atributo. Las palabras tiene que existir 
    * Devuelven los IDs de las palabras y se insertan en los prductos con ->setData(codeAttribute,$id)
    */
    public function setAttributeSelectMultiple($attrCode,$palabras){
		$sourceModel = Mage::getModel('catalog/product')->getResource()->getAttribute($attrCode)->getSource();
		$valuesText = explode(' ',$palabras);
		$valuesIds = array_map(array($sourceModel, 'getOptionId'), $valuesText);
		return $valuesIds;
    }	
	public function buscarPalabraEnString($find,$string){
		$texto=strtoupper($string);
		foreach($find as $v){
		    if(strpos($texto, $v) !== false){
		        $palabra.=$v.' ';
		    }
		}
		return trim($palabra);
	}
    public function deleteArgyorProducts(){
        Mage::register('isSecureArea', true);
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->joinField('category_id','catalog/category_product','category_id','product_id=entity_id',null,'left')
            ->addAttributeToFilter('category_id', array('in' => 470))
            ->addAttributeToSelect('*')
            ->load();

        foreach($collection as $product) { sleep(1); $product->delete(); }
        Mage::unregister('isSecureArea');
    }

    private function check404($url){
        $file_headers = @get_headers($url);
        if($file_headers[0]=='HTTP/1.1 404 Not Found') $exists=false;
        else $exists=true;
        return $exists;
    }

    private function msg($msg, $error=false, $success=false){
        $err=$error?"style='color: red;'":'';
        $suc=$success?"style='color: green;'":'';
        echo utf8_decode("<div {$err} {$suc} >{$msg}</div>");
    }

    public function sync($valore, $opciones){

        $rows=explode("/", $valore);
        $labels=explode('.', $rows[count($rows)-1]);//labels 0 contiene el nombre del archivo sin .csv
        
        $nombre_archivo_csv=$valore;
    	
        $catalog=array();

        try{
        
            $catalog=$this->parseCSV($nombre_archivo_csv);
            //var_dump($catalog);
            echo "<h1>Se ha descargado el fichero de ".$labels[0]." con &eacute;xito.</h1>";
        }
        catch(Exception $e){
            $this->msg("Hubo un problema al obtener el fichero de Argyor. (<small>{$e->getMessage()}</small>)", true);
        }

        foreach($catalog as $sku => $info){
	
            $this->msg("<h3>{$info->Descripition} ({$sku})</h3>");

            $disponible=0;
            $rows=explode(" ", $info->Quantity);
            if($rows[1]==="stock") $disponible=1;
            echo utf8_encode($info->Descripition).'  ---->  '.$disponible;
            
            if($id=Mage::getModel('catalog/product')->getIdBySku($sku/*.$info->submodelou*/)){
                $this->msg("El producto ya existe");

                $_product=Mage::getModel('catalog/product')->load($id);
                
                echo utf8_encode($info->Quantity);
                $palabras=$this->buscarPalabraEnString(array('ACERO','ACRILICO','ALUMINIO','ALUMINIO INYECTADO','CERAMICA','COBRE','CRISTAL','CRISTAL OPAL','CRISTAL PYREX','FIBRA DE VIDRIO','GOMA','HIERO','HORMIGON','MADERA','METAL','MYLON','PLASTICO','PMMA OPAL','POLICARBONATO','PVC','SILICONA','TELA','TERCIOPELO','TEXTIL','ZINC'),$info->Material);    
				$info->coleccion = $this->attributeValueExists('coleccion', 'Art');
				$info->Materiales = $this->setAttributeSelectMultiple('materiales',$palabras);
                $_product
                    #->setName(utf8_encode($info->Descripition))
                    #->setWeight($info->peso)
                    ->setData('coleccion',$info->coleccion)  
                    ->setData('materiales',$info->Materiales)	
                    ->setPrice($info->PVP);     
                    //->setCategoryIds("2");		//Id de las catgorias separadas por comas
                    #->setMetaTitle(utf8_encode($info->nombre))
                    #->setMetaDescription(utf8_encode($info->descripcion))
                    #->setDescription(utf8_encode($info->descripcion))
                    #->setShortDescription(utf8_encode($info->descripcion))
                    /*
					//Elimina las imagenes existentes
					$mediaApi = Mage::getModel("catalog/product_attribute_media_api");
					$mediaApiItems = $mediaApi->items($_product->getId());
					 
					foreach($mediaApiItems as $item) {
					    $mediaApi->remove($_product->getId(), $item['file']);
					}
					//$_product->save(); //before adding need to save product

					
					//Obtiene la imagene
                    $uid=uniqid();
                    $rutaLocal=Mage::getBaseDir().'/qz/sync_module/tmp/'.$uid.'.jpg';
                    $rutaImagen=$info->imagen;
                    $this->descargar($rutaLocal,$rutaImagen);
                    //var_dump($rutaLocal);
                    //var_dump($rutaImagen);
                    $_product->addImageToMediaGallery($rutaLocal, array('image','thumbnail','small_image'), false, false);

                    #product save and image fix
                    $_product->getResource()->save($_product);			//Guarda el producto
					
                    $gallery=$_product->getData('media_gallery');
                    array_pop($gallery['images']);						//Guarda la ultima posicion del array "images"
                    $_product->setData('media_gallery', $gallery);
                    $_product->getResource()->save($_product);			//
                    */

		
                #UPDATE OPTIONS
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
                $customOptions=$_product->getOptions();
                $models=array();
                foreach($info->submodelous as $title => $plus){
                    $models[]=array(
                        'title'=> $title,
                        'price_type'=> 'fixed',
                        'price' => $plus
                    );
                }

                #delete options
                Mage::getSingleton('catalog/product_option')->unsetOptions();
                foreach($customOptions as $option){
                    if($option->getTitle()=='modelou'){
                        $option->setIsDelete(true);
                        $option->delete();
                    }
                }
				/*
				NO TOCAR NI MIRAR
                #create options
                $_product
                    ->setHasOptions(1)
                    ->setProductOptions(array(array(
                        'title' => 'modelou',
                        'type' => 'drop_down',
                        'is_require' => 1,
                        'values' => $models
                    )))
                    ->setCanSaveCustomOptions(true);
					*/

                try{
                    $_product->save($_product);
                    $this->msg("Los precios se han actualizado con éxito.", false, true);
                }
                catch(Exception $e){
                    $this->msg("Hubo un problema al actualizar los precios. (<small>{$e->getMessage()}</small>)", true);
                }
            }
            else if($disponible===0){
                $this->msg("El producto no existe, lo crea");
                

				$palabras=$this->buscarPalabraEnString(array('ACERO','ACRILICO','ALUMINIO','ALUMINIO INYECTADO','CERAMICA','COBRE','CRISTAL','CRISTAL OPAL','CRISTAL PYREX','FIBRA DE VIDRIO','GOMA','HIERO','HORMIGON','MADERA','METAL','MYLON','PLASTICO','PMMA OPAL','POLICARBONATO','PVC','SILICONA','TELA','TERCIOPELO','TEXTIL','ZINC'),$info->Material);

                #create product
                $_product=Mage::getModel('catalog/product');
                //Atributos especiales(Select,Multiselect)
				$info->coleccion = $this->attributeValueExists('coleccion', 'Art');
				$info->Materiales = $this->setAttributeSelectMultiple('materiales',$palabras);
				
                try{
                	//var_dump($info);
                    $_product
                        ->setWebsiteIds(array(1))
                        ->setAttributeSetId(4)
                        ->setTypeId('simple')
                        ->setCreatedAt(strtotime('now'))
                        ->setSku($sku)																//SKU
                        ->setName(utf8_encode($info->Descripition))									//Nombre producto
                        ->setWeight($info->UnitWeight)												//Peso
                        ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                        ->setTaxClassId(5)
                        ->setPeriodoEntrega(63)
                        ->setOpciongrabado(61)
                        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                        ->setPrice($info->PVP)														//precio_minimo pasa a ser PVP
                        ->setMetaTitle(utf8_encode($info->Descripition))
                        ->setMetaDescription(utf8_encode($info->Descripition))
                        ->setDescription(utf8_encode($info->Descripition))							//Descripcion
                        ->setShortDescription(utf8_encode($info->Descripition))						//Descripcion corta
                        ->setMediaGallery(array('images' => array(), 'values' => array()))
                        ->setCategoryIds($info->Numero)		//$info->categorias	

                        ->setData('largo',utf8_encode($info->UnitLength))							//Longitud			*
                        ->setData('alto',utf8_encode($info->UnitHigh))								//Altura			*
                        ->setData('ancho',utf8_encode($info->UnitWidth))							//Anchura			*
                        ->setData('diametro',utf8_encode($info->Dimiter))							//Diametro			*
                        ->setData('volumen',utf8_encode($info->ExportVolume))						//Volumen			*
                        ->setData('ip',utf8_encode($info->IP))										//IP				*
                        ->setData('clase_electrica',utf8_encode($info->ElectricClass))				//Clase electrica de la bombilla*
                        ->setData('fuente_de_luz_incluida',utf8_encode($info->BulbIncluded))		//Bombilla incluida
                        ->setData('fuente_de_luz',utf8_encode($info->BulbDescription))				//Bombilla descripcion
                        ->setData('transformador_incluida',utf8_encode($info->Driver1))				//Transformador incluye	*
                        ->setData('transformador',utf8_encode($info->Driver2))						//Transformador		*
                        ->setData('coleccion',$info->coleccion)  
                        ->setData('materiales',$info->Materiales)									//Materiales						                       
                        ->setData('barcode',utf8_encode($info->Barcode))							//Codigo de barra	*
                        ->setStockData(array('use_config_manage_stock' => 0))						//					*
                        ;

						
                    #image
                    $uid=uniqid();
                    $rutaLocal=Mage::getBaseDir().'/qz/sync_module/tmp/'.$uid.'.jpg';
                    $rutaImagen=$info->imagen;
                    $this->descargar($rutaLocal,$rutaImagen);
                    //var_dump($rutaLocal);
                    //var_dump($rutaImagen);
                    $_product->addImageToMediaGallery($rutaLocal, array('image','thumbnail','small_image'), false, false);

                    #product save and image fix
                    $_product->getResource()->save($_product);			//Guarda el producto
					
                    $gallery=$_product->getData('media_gallery');
                    array_pop($gallery['images']);						//Guarda la ultima posicion del array "images"
                    $_product->setData('media_gallery', $gallery);
                    $_product->getResource()->save($_product);			//

                    $this->msg("El producto se ha guardado con éxito.", false, true);

                    #MODELS
                    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
                    $models=array();
                    foreach($info->subReferences as $title => $plus){
                        $models[]=array(
                            'title'=> $title,
                            'price_type'=> 'fixed',
                            'price' => $plus
                        );
                    }
					/*
                    $model_option=array(
                        'title' => 'modelou',
                        'type' => 'drop_down',
                        'is_require' => 1,
                        'values' => $models
                    );*/

                    Mage::getSingleton('catalog/product_option')->unsetOptions();
                    $_product
                        ->setHasOptions(1)
                        ->setProductOptions(array($model_option))
                        ->setCanSaveCustomOptions(true);

                    $_product->save($_product);
                    $this->msg("Los modelous se han guardado con éxito.", false, true);

                }
                catch (Exception $e) {
                    $this->msg("Hubo un problema al guardar el producto. (<small>{$e->getMessage()}</small>)", true);
                }
            }
        }
    }
}