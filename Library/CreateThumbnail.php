<?php
// Create thumbnail at 72 dpi. Requires PHP 5+ with GD library
// generated thumbnail (output file) will replace any existing file with the same output file name
/**
* 
* @dependency: GD library 2.0.1 bundled version (2.0.28 or newer recommended)
* @dependency: PHP >= 5.1 for sharpen option
* @throw exception on critical errors (see documentation)
* @return array getLog(): opening log ('open') and process log ('process'). See documentation for details
* @version: 1.02 - 2012-02-08 - 
* @author: iXoft (contact@ixoft.com). Transparency preservation for PNG by Tim McDaniels (TimThumb). Transparency preservation for GIF by markglibres (PHP.net forum).
* @input file can be GIF, JPEG or PNG images
* @todo: fill with specified color in order to constraint output size ?
*/

/*	documentation : see included getThisDoc() at the end of this file, or visit ixoft.com */

/*
TERMS OF USE

Copyright 2010 iXoft
All rights reserved.

This code is distributed as freeware, so it can be used for free but can not be sold.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
    * Neither the name of the author nor the names of contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

class CreateThumbnail {
	// -------------------------------------------------------------------------------- definition des types et modes acceptes
	private static $listeTypesOK = array(
		'GIF' => array('extensions' => array('gif'), 'type' => IMAGETYPE_GIF), // PHP IMAGETYPE constantes
		'JPG' => array('extensions' => array('jpg','jpeg'), 'type' => IMAGETYPE_JPEG),
		'PNG' => array('extensions' => array('png'), 'type' => IMAGETYPE_PNG)
	);
	
	const THIS_CLASS_VERS = 1.02; /////
	// -------------------------------------------------------------------------------- RETOUR ERREURS ET STATUS
	const ERROR_INTERNAL_GENERAL = 1;
	const ERROR_OPEN_GENERAL = 100;
	const ERROR_OPEN_BADFILE = 101;
	const ERROR_PROCESS_GENERAL = 200;
	const ERROR_WRITE_GENERAL = 300;
	const MAX_PIXELS = 4000; // maximum image width or height
	
	const QUALITY_MEDIUM = 75; // compression : de 1 a 100
	const SHARPEN_SOFT = 22;
	const SHARPEN_MEDIUM = 18;
	const SHARPEN_HARD = 14;
	
	protected $log = array();
	
	// -------------------------------------------------------------------------------- DATA TRAITEMENT
	protected $enTest = FALSE; ///// affichage debug
	protected $image; // ressource image
	protected $canvas; // ressource GD
	
	// -------------------------------------------------------------------------------- PROPRIETES IMAGE
	protected $largeurVoulue = 0; // param traitement
	protected $hauteurVoulue = 0; // param traitement
	protected $qualiteVoulue = self::QUALITY_MEDIUM; // param traitement
	protected $sharpenVoulu = ''; // param traitement
	protected $brightnessVoulue = 0; // param traitement
	protected $prefixeVoulu = ''; // param sortie
	protected $suffixeVoulu = ''; // param sortie
	protected $destination = ''; // param sortie
	protected $altTxt = ''; // param sortie
	
	// -------------------------------------------------------------------------------- CONSTRUCTEURS
	public function __construct($fichierSource='', $fichierDest='', $largeur=0, $hauteur=0, $qualite=self::QUALITY_MEDIUM, $sharpen='', $brightness=0, $prefix='', $suffix='', $alt='') {
		if (!function_exists('imagecreatetruecolor')) throw new Exception('GD library not loaded',self::ERROR_INTERNAL_GENERAL);
		
		// --------- si params passés dans contructeur
		if (!self::isEmpty($suffix)) $this->setSuffix($suffix);
		if (!self::isEmpty($prefix)) $this->setPrefix($prefix);
		if (!self::isEmpty($brightness)) $this->setBrightness($brightness);
		if (!self::isEmpty($sharpen)) $this->setSharpen($sharpen);
		if (!self::isEmpty($qualite)) $this->setQuality($qualite);
		if (!self::isEmpty($largeur)) $this->setWidth($largeur);
		if (!self::isEmpty($hauteur)) $this->setHeight($hauteur);
		if (!self::isEmpty($alt)) $this->setAlt($alt);
		if (!empty($fichierSource)) {
			$this->open($fichierSource);
			$this->process($fichierDest);
		}
	}
	
	// -------------------------------------------------------------------------------- ACCESSEURS
	// -------------- voir les méthodes statiques en fin de document
	public function getLog($element='') { // 'open', 'process' ou log complet par defaut
		if ($element != '' && isset($this->log[$element])) {
			return $this->log[$element];
		}else{
			return $this->log;
		}
	}
	
	public function getWidth() { // raccourci pour log['process']['width']
		return (isset($this->log['process']['width']))? $this->log['process']['width'] : 0;
	}
	
	public function getHeight() { // raccourci pour log['process']['height']
		return (isset($this->log['process']['height']))? $this->log['process']['height'] : 0;
	}
	
	public function getName() { // raccourci pour log['process']['longName']
		return (isset($this->log['process']['longName']))? $this->log['process']['longName'] : '';
	}
	
	public function getAlt() { // raccourci pour log['process']['alt']
		return (isset($this->log['process']['alt']))? $this->log['process']['alt'] : '';
	}
	
	public function setWidth($param=0) {
		$this->largeurVoulue = intval($param);
		return $this;
	}
	
	public function setHeight($param=0) {
		$this->hauteurVoulue = intval($param);
		return $this;
	}
	
	public function setQuality($param=self::QUALITY_MEDIUM) {
		$this->qualiteVoulue = min(100,max(1,intval($param)));
		return $this;
	}
	
	public function setSharpen($param=self::SHARPEN_MEDIUM) {
		switch (strtolower($param)) {
			case 'soft':
				$this->sharpenVoulu = self::SHARPEN_SOFT;
				break;
			case 'medium':
				$this->sharpenVoulu = self::SHARPEN_MEDIUM;
				break;
			case 'hard':
				$this->sharpenVoulu = self::SHARPEN_HARD;
				break;
			default: // ou 'none'
				$this->sharpenVoulu = '';
		}
		return $this;
	}
	
	public function setBrightness($param=0) {
		$this->brightnessVoulue = min(10,max(-10,intval($param)));
		return $this;
	}
	
	public function setPrefix($param='') {
		$this->prefixeVoulu = substr($param,0,255);
		return $this;
	}
	
	public function setSuffix($param='') {
		$this->suffixeVoulu = substr($param,0,255);
		return $this;
	}
	
	public function setAlt($param='') {
		$this->altTxt = substr($param,0,255);
		return $this;
	}
	
	// -------------------------------------------------------------------------------- OUVERTURE et LECTURE INFOS
	public function open($fichier='') {
		// --------------------------------------------------------- test validité fichier et ecriture log 'open'
		if (empty($fichier)) $this->exitExceptionOpen('No file parameter.'.$fichier,self::ERROR_OPEN_GENERAL);
		if (!file_exists($fichier)) $this->exitExceptionOpen('Unable to find file: '.$fichier,self::ERROR_OPEN_GENERAL);
		$this->initLog();
		$this->log['open']['longName'] = $fichier;
		$temp = pathinfo($fichier);
		$this->log['open']['shortName'] = self::stripFileExtension($temp['basename']);
		$this->log['open']['path'] = $temp['dirname'];
		$this->log['open']['extension'] = $temp['extension'];
		if (substr($temp['basename'],0,1) == '.' || is_dir($fichier)) {
			$this->exitExceptionOpen('Not a valid file: '.$fichier,self::ERROR_OPEN_BADFILE);
		}
		$this->log['open']['type'] = self::getTypeFichierImage(strtolower($this->log['open']['extension'])); // 1ere évaluation du type d'après l'extension
		if ($this->log['open']['type'] == '') $this->exitExceptionOpen('Bad file extension: '.$this->log['open']['extension'],self::ERROR_OPEN_BADFILE);
		
		// --------------------------------------------------------- ouverture fichier source et vérifications
		// -------------------------------- dimensions
		$infosSource = @getimagesize($fichier);
		if ($infosSource == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_OPEN_GENERAL);
		$temp = $this->log['open']['type'];
		if ($infosSource[2] != self::$listeTypesOK[$temp]['type']) $this->exitExceptionOpen('Wrong image type/extension: '.$fichier,self::ERROR_OPEN_BADFILE);
		$this->log['open']['width'] = $infosSource[0];
		$this->log['open']['height'] = $infosSource[1];
		if ($this->log['open']['width'] < 1) $this->exitExceptionOpen('Bad image width: '.$this->log['open']['width'],self::ERROR_OPEN_BADFILE);
		if ($this->log['open']['height'] < 1) $this->exitExceptionOpen('Bad image height: '.$this->log['open']['height'],self::ERROR_OPEN_BADFILE);
		
		// -------------------------------- GD
		$image = $this->openImage($fichier);
		return $this;
	}
	
	// -------------------------------------------------------------------------------- TRAITEMENT
	public function process($fichierDest='') {
		// -------------------------------- test destination ici (en début de process) pour économie ressource
		if (!empty($fichierDest)) {
			$this->destination = $fichierDest;
		}else{
			$temp = ($this->log['open']['path'] == '.')? '' : $this->log['open']['path'].'/';
			$this->destination = $temp.$this->prefixeVoulu.$this->log['open']['shortName'].$this->suffixeVoulu.'.'.$this->log['open']['extension'];
		}
		if ($this->destination == $this->log['open']['longName']) $this->exitExceptionOpen('Output file cannot replace input file.',self::ERROR_WRITE_GENERAL);
		
		// -------------------------------- MAJ log et détermination dimensions
		$this->initLogProcess();
		$this->checkDimensions(); // vérifications et modifications
		
		// -------------------------------- traitement
		$this->thumbnail();
		$this->log['process']['width'] = $this->largeurVoulue;
		$this->log['process']['height'] = $this->hauteurVoulue;
		
		$this->write();
		$this->log['process']['longName'] = $this->destination;
		$temp = pathinfo($this->destination);
		$this->log['process']['shortName'] = self::stripFileExtension($temp['basename']);
		$this->log['process']['extension'] = $temp['extension'];
		$this->log['process']['quality'] = $this->qualiteVoulue;
		$this->log['process']['sharpen'] = $this->sharpenVoulu;
		$this->log['process']['brightness'] = $this->brightnessVoulue;
		$this->log['process']['alt'] = (!self::isEmpty($this->altTxt))? $this->altTxt : $this->log['open']['shortName'];
		
		// ----------------------
		$this->destroy();
		return $this;
	}
	
	// -------------------------------------------------------------------------------- METHODES INTERNES
	
	private static function getTypeFichierImage($extension) {
		if (substr($extension,0,1) == '.') $extension = substr($extension,1);
		foreach (self::$listeTypesOK as $cle => $ligne) {
			if (in_array($extension,$ligne['extensions']) !== FALSE) return $cle;
		}
		return '';
	}
	
	protected function checkDimensions() {
		// vérification des dimensions passées et calcul des nouvelles dimensions
		if ($this->largeurVoulue == 0 && $this->hauteurVoulue == 0) {
			$this->largeurVoulue = $this->log['open']['width'];
			$this->hauteurVoulue = $this->log['open']['height'];
		}else{
			$rapport = $this->log['open']['width'] / $this->log['open']['height'];
			
			if ($this->largeurVoulue > 0) {
				if ($this->hauteurVoulue < 1) {
					// ------------------------- largeur seule passée (x)
					$this->hauteurVoulue = round($this->largeurVoulue / $rapport,0);
				}elseif ($this->hauteurVoulue == $this->largeurVoulue){
					// ------------------------- x = y : l'image doit rentrer dans une zone carrée
					if ($rapport > 1) {
						// image horizontale
						$this->hauteurVoulue = round($this->largeurVoulue / $rapport,0); // forçage y "à la best-fit"
					}else{
						// image verticale
						$this->largeurVoulue = round($this->hauteurVoulue * $rapport,0); // forçage x "à la best-fit"
					}
				}else{
					// ------------------------- x et y sont passées : resize strict avec déformation éventuelle
				}
			}else{
				if ($this->hauteurVoulue > 0) {
					// ------------------------- hauteur seule passée (y)
					$this->largeurVoulue = round($this->hauteurVoulue * $rapport,0);
				}else{
					$this->exitExceptionProcess('Width and height not defined.',self::ERROR_PROCESS_GENERAL);
				}
			}
		}
		
		// vérification basique des dimensions passées
		if ($this->largeurVoulue > $this->log['open']['width'] || $this->hauteurVoulue > $this->log['open']['height']) {
			$this->exitExceptionProcess('Desired width too large: '.$this->largeurVoulue.'x'.$this->hauteurVoulue,self::ERROR_PROCESS_GENERAL);
		}
		if ($this->largeurVoulue > self::MAX_PIXELS || $this->hauteurVoulue > self::MAX_PIXELS) {
			$this->exitExceptionProcess('Desired height too large: '.$this->largeurVoulue.'x'.$this->hauteurVoulue,self::ERROR_PROCESS_GENERAL);
		}
	}

	protected function openImage($fichier) {
		switch ($this->log['open']['type']) {
			case 'GIF':
				$this->image = @imagecreatefromgif($fichier); // identifiant de ressource image a partir du fichier source
				if ($this->image == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
				break;
			case 'JPG':
				$this->image = @imagecreatefromjpeg($fichier); // identifiant de ressource image a partir du fichier source
				if ($this->image == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
				break;
			case 'PNG':
				$this->image = @imagecreatefrompng($fichier); // identifiant de ressource image a partir du fichier source
				if ($this->image == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
				break;
			default:
				$this->exitExceptionOpen('Error when opening image: undefined type.',self::ERROR_INTERNAL_GENERAL);
		}
	}
	
	protected function thumbnail() { // GD
		$this->canvas = @imagecreatetruecolor($this->largeurVoulue,$this->hauteurVoulue); // cree une ressource true color noire
		if ($this->canvas == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
		
		// ---------------------------- preservation de la couche transparente (PNG et GIF)
		if ($this->log['open']['type'] == 'PNG') {
			$temp = @imagealphablending($this->canvas,false);
			if ($temp == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
			$color = @imagecolorallocatealpha($this->canvas,0,0,0,127); // cree une nouvelle couleur transparente
			if ($color == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
			$temp = @imagefill($this->canvas,0,0,$color); // Rempli le fond de ressourceCanvas avec la couleur allouee
			if ($temp == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
			$temp = @imagesavealpha($this->canvas,true);
			if ($temp == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
		}elseif ($this->log['open']['type'] == 'GIF') {
			$transparencyIndex = @imagecolortransparent($this->image);
			if ($transparencyIndex == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
			$transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);
			if ($transparencyIndex >= 0) $transparencyColor = @imagecolorsforindex($this->image, $transparencyIndex);
			if ($transparencyColor == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
			$transparencyIndex = @imagecolorallocate($this->canvas, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
			if ($transparencyIndex == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
			$temp = @imagefill($this->canvas, 0, 0, $transparencyIndex);
			if ($temp == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
			$temp = @imagecolortransparent($this->canvas, $transparencyIndex);
			if ($temp == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
		}
		
		$temp = @imagecopyresampled($this->canvas,$this->image,0,0,0,0,$this->largeurVoulue, $this->hauteurVoulue, $this->log['open']['width'], $this->log['open']['height']); // copie une zone rectangulaire de image vers canvas avec resampling
		if ($temp == FALSE) $this->exitExceptionOpen(error_get_last(),self::ERROR_INTERNAL_GENERAL);
		
		// --------------------------------- sharpen
		if (!empty($this->sharpenVoulu) && function_exists('imageconvolution')) {
			$sharpenMatrix = array (
				array (-1,-1,-1),
				array (-1,$this->sharpenVoulu,-1),
				array (-1,-1,-1),
			);
			$divisor = array_sum(array_map('array_sum',$sharpenMatrix));
			$offset = 0;
			$temp = @imageconvolution($this->canvas,$sharpenMatrix,$divisor,$offset);
			if ($temp == FALSE) {
				$this->log['process']['error'] = 'GD error: unable to process imageconvolution().';
				$this->log['process']['errorType'] = self::ERROR_INTERNAL_GENERAL;
			}
		}
		
		// --------------------------------- filter brightness
		// valeurs possibles : -255 = min brightness, 0 = no change, +255 = max brightness
		// valeurs tronquées dans la classe à de -10 à +10 (-100 à +100)
		if (!self::isEmpty($this->brightnessVoulue) && function_exists('imagefilter')) {
			$temp = @imagefilter($this->canvas,IMG_FILTER_BRIGHTNESS,$this->brightnessVoulue * 10);
			if ($temp == FALSE) {
				$this->log['process']['error'] = 'GD error: unable to process imagefilter().';
				$this->log['process']['errorType'] = self::ERROR_INTERNAL_GENERAL;
			}
		}
	}

	protected function write() {
		switch ($this->log['open']['type']) {
			case 'GIF':
				$temp = @imagegif($this->canvas,$this->destination);
				if ($temp == FALSE) $this->exitExceptionProcess(error_get_last(),self::ERROR_WRITE_GENERAL);
				break;
			case 'JPG':
				$temp = @imagejpeg($this->canvas,$this->destination,$this->qualiteVoulue);
				if ($temp == FALSE) $this->exitExceptionProcess(error_get_last(),self::ERROR_WRITE_GENERAL);
				break;
			case 'PNG':
				$temp = @imagepng($this->canvas,$this->destination,self::qualityJpgToPng($this->qualiteVoulue));
				if ($temp == FALSE) $this->exitExceptionProcess(error_get_last(),self::ERROR_WRITE_GENERAL);
				break;
			default:
				$this->exitExceptionOpen('Error when writing image: undefined type.',self::ERROR_INTERNAL_GENERAL);
		}
	}

	protected function destroy() { // remove ressources image from memory
		if (is_resource($this->canvas)) {
			$temp = @imagedestroy($this->canvas);
			if ($temp == FALSE) $this->exitExceptionProcess(error_get_last(),self::ERROR_INTERNAL_GENERAL);
		}
		if (is_resource($this->image)) {
			$temp = @imagedestroy($this->image);
			if ($temp == FALSE) $this->exitExceptionProcess(error_get_last(),self::ERROR_INTERNAL_GENERAL);
		}
	}
	
	protected function exitExceptionOpen($errorStr,$errorNum=self::ERROR_OPEN_GENERAL) {
		$strError = (is_array($errorStr))? $errorStr['message'] : $errorStr; // pour cas ou l'erreur vient de error_get_last()
		$this->log['open']['error'] = $strError;
		$this->log['open']['errorType'] = $errorNum;
		$this->destroy();
		throw new Exception($strError,$errorNum);
	}
	
	protected function exitExceptionProcess($errorStr,$errorNum=self::ERROR_PROCESS_GENERAL) {
		$strError = (is_array($errorStr))? $errorStr['message'] : $errorStr; // pour cas ou l'erreur vient de error_get_last()
		$this->log['process']['error'] = $strError;
		$this->log['process']['errorType'] = $errorNum;
		$this->destroy();
		throw new Exception($strError,$errorNum);
	}
	
	protected function initLog() {
		$this->log = array(
			'open' => array(
				'longName' => '',
				'shortName' => '',
				'path' => '',
				'extension' => '',
				'type' => '',
				'width' => 0,
				'height' => 0,
				'errorType' => '', // numero de l'erreur jetée
				'error' => '' //getMessage() de l'erreur jetée
			),
			'process' => array()
		);
	}
	
	protected function initLogProcess() {
		$this->log['process'] = array(
			'longName' => '',
			'shortName' => '',
			'extension' => '',
			'width' => 0,
			'height' => 0,
			'alt' => '',
			'quality' => self::QUALITY_MEDIUM,
			'sharpen' => '',
			'brightness' => 0,
			'errorType' => '', // numero de l'erreur jetée
			'error' => '' // getMessage() de l'erreur jetée
		);
	}

	// -------------------------------------------------------------------------------- METHODES EXTERNES
	private static function stripFileExtension($nomFichier) { // utile si PHP < 5.2
		$pos = strrpos($nomFichier,'.');
		if ($pos === FALSE) return $nomFichier;
		return substr($nomFichier,0,$pos);
	}
	
	private static function qualityJpgToPng($qualite) {
		return round((100 - $qualite) * 0.09);
	}
	
	private static function isEmpty($laVar){ // attention : ne fonctionne pas pour les constantes (utiliser defined() )
		if (func_num_args() < 1) return true;
		if (is_array($laVar)) {
			return empty($laVar);
		}else{
			return ((!isset($laVar)) || ($laVar === '') || is_null($laVar));
		}
	}
	
	public static function getThisVersion() {
		return self::THIS_CLASS_VERS;
	}
	
	public static function getThisDoc() {
		$exemple = '
Minimal usage example:
------------------------------------------------
	$data = new CreateThumbnail();
	$data->setWidth($outputWidth)->setHeight($outputHeight); // output size in pixels
	try {
		$data->open($sourceFile);
		$data->process($outputFile);
	}catch (Exception $e){
		echo $e->getCode()." - ".$e->getMessage();
	}
	
Shortened and dirty usage example:
------------------------------------------------
	$data = new CreateThumbnail($sourceFile, $outputFile, $width, [$height, [$quality, [$sharpen, [$brightness, [$prefix, [$suffix] ]]]]]);
	
Full options usage example:
------------------------------------------------
	$data = new CreateThumbnail();
	$data->setWidth($pixels);
	$data->setWidth($outputWidth); // in pixels
	$data->setHeight($outputHeight); // in pixels
	// $data->setPrefix($outputPrefixName); // suffix for output file name (string)
	// $data->setSuffix($outputSuffixName); // prefix for output file name (string)
	$data->setQuality($qualityCoeff); // integer from 1 to 100
	$data->setSharpen($sharpenStyle); // "none" or "soft" or "medium" or "hard"
	$data->setBrightness(brightnessCoeff); // integer from -10 to 10
	
	$sourceFile = "myFolder/myImage.jpg";
	$outputFile = "myOutputFolder/thumb"; // if not specified, output file is created in the source folder
	
	try {
		$data->open($sourceFile);
		// ----- image opening OK : go on
		try {
			$data->process($outputFile);
		}catch (Exception $e){
			echo $e->getCode()." - ".$e->getMessage();
		}
	}catch (Exception $e){
		echo $e->getCode()." - ".$e->getMessage();
	}
	
	echo "OPEN LOG:".print_r($data->getLog("open"), 1);
	echo "PROCESS LOG:".print_r($data->getLog("process"), 1);
		';
		
		$methodes = '
Public methods:
------------------------------------------------
	new CreateThumbnail( [params] ) // instanciate class
	open(string $imageFile) // open and read image file
	process( [string $outputFile] ) // create processed image file. If not specified, output file is created in the source folder
	
	setWidth(int $pixels) // output image width in pixels
	setHeight(int $pixels) // output image height in pixels
	setQuality(int $qualityCoeff) // output image quality, from 1 (smallest file) to 100 (biggest file but best quality). Default is 75
	setSharpen(string $sharpenStyle) // can be "soft", "medium", "hard" or "none". "none" or empty means no modification
	setBrightness(int $brightnessCoeff) // output image brightness, from -10 (dark) to 10 (bright). 0 or empty means no modification
	setPrefix(string $outputPrefix) // adds specified prefix to output file name
	setSuffix(string $outputSuffix) // adds specified suffix to output file name
	setAlt(string $altText) // optional string that will be part of process log (see below)
	
	getLog( ["open"] | ["process"] ) // return full log (default) or specified part log as array
	getName() // shortcut to getLog(["process"]["longName"])
	getWidth() // shortcut to getLog(["process"]["width"])
	getHeight() // shortcut to getLog(["process"]["height"])
	getAlt() // shortcut to getLog(["process"]["alt"]). If no ALT text was specified with setAlt(), getAlt() returns getLog(["process"]["shortName"])
	
Public static methods:
------------------------------------------------
	getThisDoc() // returns this basic documentation as string
	getThisVersion() // returns the version of this class as number
	
Error constants:
------------------------------------------------
	ERROR_INTERNAL_GENERAL: generic internal error
	ERROR_OPEN_GENERAL: generic open error
	ERROR_OPEN_BADFILE: not a valid image file
	ERROR_PROCESS_GENERAL: generic process error
	ERROR_WRITE_GENERAL: generic write error
		';
		$doc = "
Output width and height parameters:
------------------------------------------------
	- if only width is specified, output image will have this width and its height will be proportional (depending of the input image)
	- if only height is specified, output image will have this height and its width will be proportional (depending of the input image)
	- if width and height are both specified, output image will have specified sizes (distorsion is possible in this case)
	- if width and height are both specified and identical, the class will use the bigger size and output image based on this size

Warning:
------------------------------------------------
	Applying 'sharpen' option to a PNG image make its transparency get lost.
	Output image cannot have size bigger than 4000 pixels.
	";
		return $exemple.$methodes.$doc;
	}
}
?>
